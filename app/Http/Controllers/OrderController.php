<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of user orders.
     */
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['items.product'])
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the specified order.
     */
    public function show(Order $order)
    {
        // Verificar que el pedido pertenece al usuario autenticado
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items.product']);
        return view('orders.show', compact('order'));
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'notes' => 'nullable|string|max:1000'
        ]);

        // Obtener items del carrito
        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío');
        }

        // Calcular total
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Crear el pedido
        $order = Order::create([
            'user_id' => auth()->id(),
            'total' => $total,
            'status' => 'pending',
            'shipping_address' => $request->shipping_address,
            'phone' => $request->phone,
            'notes' => $request->notes
        ]);

        // Crear los items del pedido
        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price
            ]);

            // Reducir stock del producto
            $cartItem->product->decrement('stock', $cartItem->quantity);
        }

        // Limpiar el carrito
        Cart::where('user_id', auth()->id())->delete();

        return redirect()->route('orders.show', $order)->with('success', 'Pedido realizado exitosamente');
    }

    /**
     * Admin: Display a listing of all orders.
     */
    public function adminIndex()
    {
        $orders = Order::with(['user', 'items.product'])
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Admin: Update order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('admin.pedidos.index')->with('success', 'Estado del pedido actualizado');
    }
}
