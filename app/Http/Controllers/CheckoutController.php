<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the shipping information form
     */
    public function shipping()
    {
        // Verificar si hay items en el carrito
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                           ->with('error', 'Tu carrito está vacío. Agrega algunos productos antes de proceder al checkout.');
        }

        // Obtener datos de envío guardados en sesión
        $shippingData = session('checkout.shipping', []);

        return view('checkout.shipping', compact('shippingData'));
    }

    /**
     * Process shipping information and redirect to payment
     */
    public function processShipping(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:2',
            'postal_code' => 'nullable|string|max:10',
            'notes' => 'nullable|string|max:500',
        ]);

        // Guardar información de envío en sesión con nombres de ciudad y estado
        $shippingData = $validated;
        
        // Obtener nombres de ciudad y estado desde la API
        try {
            // Obtener nombre del departamento
            $departmentResponse = file_get_contents("https://api-colombia.com/api/v1/Department/{$validated['state']}");
            $department = json_decode($departmentResponse, true);
            $shippingData['state_name'] = $department['name'] ?? $validated['state'];
            
            // Obtener nombre de la ciudad
            $cityResponse = file_get_contents("https://api-colombia.com/api/v1/City/{$validated['city']}");
            $city = json_decode($cityResponse, true);
            $shippingData['city_name'] = $city['name'] ?? $validated['city'];
        } catch (Exception $e) {
            // Si falla la API, usar los valores originales
            $shippingData['state_name'] = $validated['state'];
            $shippingData['city_name'] = $validated['city'];
        }
        
        session(['checkout.shipping' => $shippingData]);

        return redirect()->route('checkout.confirm');
    }

    /**
     * Show the confirmation page
     */
    public function showConfirm()
    {
        if (!session('checkout.shipping')) {
            return redirect()->route('checkout.shipping')
                           ->with('error', 'Por favor, completa la información de envío primero.');
        }

        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product.offers')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                           ->with('error', 'Tu carrito está vacío.');
        }

        // Calcular totales
        $subtotal = $cartItems->sum(function($item) {
            return $item->product->final_price * $item->quantity;
        });

        // Determinar costo de envío basado en ubicación
        $shippingData = session('checkout.shipping');
        $cityName = strtolower(trim($shippingData['city_name'] ?? $shippingData['city']));
        $stateName = strtolower(trim($shippingData['state_name'] ?? $shippingData['state']));
        
        $shippingCost = 17000; // Costo base de envío

        // Envío gratis para La Paz, Cesar o cualquier municipio de La Guajira
        if (($cityName === 'la paz' && $stateName === 'cesar') || 
            $stateName === 'la guajira') {
            $shippingCost = 0;
        }

        $total = $subtotal + $shippingCost;

        return view('checkout.confirm', compact('cartItems', 'subtotal', 'shippingCost', 'total'));
    }

    public function process(Request $request)
    {
        // Verificar si existe información de envío
        if (!session('checkout.shipping')) {
            return redirect()->route('checkout.shipping')
                           ->with('error', 'Por favor, completa la información de envío primero.');
        }

        $validated = session('checkout.shipping');

        try {
            // Iniciar transacción
            DB::beginTransaction();

            // Obtener items del carrito
            $cartItems = Cart::where('user_id', Auth::id())
                ->with('product.offers')
                ->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')
                               ->with('error', 'Tu carrito está vacío.');
            }

            // Calcular totales
            $subtotal = $cartItems->sum(function($item) {
                return $item->product->final_price * $item->quantity;
            });

            // Determinar costo de envío basado en ubicación
            $shipping = 17000; // Costo base de envío
            $cityName = strtolower(trim($validated['city']));
            $stateName = strtolower(trim($validated['state']));

            // Envío gratis para La Paz, Cesar o cualquier municipio de La Guajira
            if (($cityName === 'la paz' && $stateName === 'cesar') || 
                $stateName === 'la guajira') {
                $shipping = 0;
            }

            $total = $subtotal + $shipping;

            // Crear la orden
            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => 'pending',
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total' => $total,
                'first_name' => $validated['first_name'],
                'last_name' => '', // Ya no se usa apellido
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'country' => $validated['country'],
                'postal_code' => $validated['postal_code'],
                'notes' => $validated['notes'],
            ]);

            // Crear los items de la orden
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'final_price' => $item->product->final_price,
                ]);
            }

            // Guardar la orden en la sesión para el checkout
            Session::put('checkout_order_id', $order->id);

            // Commit la transacción
            DB::commit();

            // Redirigir a la pasarela de pago de Wompi
            return redirect()->route('checkout.payment');

        } catch (\Exception $e) {
            // Rollback en caso de error
            DB::rollBack();

            return redirect()->back()
                           ->with('error', 'Hubo un error al procesar tu orden. Por favor, intenta nuevamente.')
                           ->withInput();
        }
    }

    /**
     * Show the Wompi payment form
     */
    public function payment()
    {
        // Verificar si hay una orden en proceso
        if (!Session::has('checkout_order_id')) {
            return redirect()->route('cart.index')
                           ->with('error', 'No hay una orden en proceso. Por favor, comienza el checkout nuevamente.');
        }

        $order = Order::findOrFail(Session::get('checkout_order_id'));

        return view('checkout.payment', compact('order'));
    }

    /**
     * Show the success page after payment
     */
    public function success()
    {
        // Verificar si hay una orden completada
        if (!Session::has('checkout_order_id')) {
            return redirect()->route('home')
                           ->with('error', 'No se encontró información de la orden.');
        }

        $order = Order::findOrFail(Session::get('checkout_order_id'));
        
        // Limpiar el carrito del usuario
        Cart::where('user_id', Auth::id())->delete();
        
        // Limpiar la sesión
        Session::forget('checkout_order_id');
        
        return view('checkout.success', compact('order'));
    }

    /**
     * Handle the Wompi webhook
     */
    public function webhook(Request $request)
    {
        // Verificar la firma del webhook
        $signature = $request->header('X-Wompi-Signature');
        // TODO: Implementar verificación de firma

        $event = $request->input('event');
        $data = $request->input('data');

        // Procesar el evento
        switch ($event) {
            case 'transaction.updated':
                $orderId = $data['reference'];
                $status = $data['status'];

                $order = Order::find($orderId);
                if ($order) {
                    $order->status = $status;
                    $order->payment_id = $data['id'];
                    $order->save();

                    if ($status === 'APPROVED') {
                        // TODO: Enviar email de confirmación
                        // TODO: Actualizar inventario
                    }
                }
                break;
        }

        return response()->json(['status' => 'success']);
    }
}
