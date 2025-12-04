<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Constructor - solo checkout requiere autenticación
     */
    public function __construct()
    {
        $this->middleware('auth')->only(['checkout']);
    }

    /**
     * Display the shopping cart.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            // Usuario autenticado - obtener del carrito en BD
            $cartItems = Cart::where('user_id', Auth::id())
                ->with('product')
                ->get();
        } else {
            // Usuario no autenticado - obtener de la sesión
            $sessionCart = Session::get('cart', []);
            $cartItems = collect();
            
            foreach ($sessionCart as $productId => $quantity) {
                $product = Product::find($productId);
                if ($product) {
                    $cartItems->push((object)[
                        'id' => $productId,
                        'product' => $product,
                        'quantity' => $quantity
                    ]);
                }
            }
        }

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add a product to cart
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Verificar stock disponible
        if ($request->quantity > $product->stock) {
            return back()->with('error', 'No hay suficiente stock disponible.');
        }

        if (Auth::check()) {
            // Usuario autenticado - guardar en BD
            $cartItem = Cart::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->first();

            if ($cartItem) {
                $newQuantity = $cartItem->quantity + $request->quantity;
                
                if ($newQuantity > $product->stock) {
                    return back()->with('error', 'No hay suficiente stock disponible.');
                }
                
                $cartItem->update(['quantity' => $newQuantity]);
            } else {
                Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity
                ]);
            }
        } else {
            // Usuario no autenticado - guardar en sesión
            $cart = Session::get('cart', []);
            
            if (isset($cart[$request->product_id])) {
                $newQuantity = $cart[$request->product_id] + $request->quantity;
                
                if ($newQuantity > $product->stock) {
                    return back()->with('error', 'No hay suficiente stock disponible.');
                }
                
                $cart[$request->product_id] = $newQuantity;
            } else {
                $cart[$request->product_id] = $request->quantity;
            }
            
            Session::put('cart', $cart);
        }

        return back();
    }

    /**
     * Update cart item quantity
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $cartItemId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cartItemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        if (Auth::check()) {
            // Usuario autenticado - actualizar en BD
            $cart = Cart::findOrFail($cartItemId);
            
            if ($cart->user_id !== Auth::id()) {
                abort(403);
            }

            if ($request->quantity > $cart->product->stock) {
                if ($request->ajax()) {
                    return response()->json(['error' => 'No hay suficiente stock disponible.'], 400);
                }
                return back()->with('error', 'No hay suficiente stock disponible.');
            }

            $cart->update(['quantity' => $request->quantity]);
            $newTotal = $cart->product->price * $request->quantity;
        } else {
            // Usuario no autenticado - actualizar en sesión
            $sessionCart = Session::get('cart', []);
            $product = Product::find($cartItemId);
            
            if (!$product || $request->quantity > $product->stock) {
                if ($request->ajax()) {
                    return response()->json(['error' => 'No hay suficiente stock disponible.'], 400);
                }
                return back()->with('error', 'No hay suficiente stock disponible.');
            }
            
            $sessionCart[$cartItemId] = $request->quantity;
            Session::put('cart', $sessionCart);
            $newTotal = $product->price * $request->quantity;
        }

        if ($request->ajax()) {
            // Calcular nuevo total del carrito
            $cartTotal = $this->getCartTotal();
            
            return response()->json([
                'success' => true,
                'newItemTotal' => number_format($newTotal, 2),
                'cartTotal' => number_format($cartTotal, 2),
                'cartTotalWithShipping' => number_format($cartTotal >= 50 ? $cartTotal : $cartTotal + 5, 2),
                'freeShipping' => $cartTotal >= 50
            ]);
        }

        return back();
    }

    /**
     * Remove item from cart
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $cartItemId
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request, $cartItemId)
    {
        if (Auth::check()) {
            // Usuario autenticado - eliminar de BD
            $cart = Cart::findOrFail($cartItemId);
            
            if ($cart->user_id !== Auth::id()) {
                abort(403);
            }
            
            $cart->delete();
        } else {
            // Usuario no autenticado - eliminar de sesión
            $sessionCart = Session::get('cart', []);
            unset($sessionCart[$cartItemId]);
            Session::put('cart', $sessionCart);
        }

        if ($request->ajax()) {
            // Calcular nuevo total del carrito
            $cartTotal = $this->getCartTotal();
            
            return response()->json([
                'success' => true,
                'cartTotal' => number_format($cartTotal, 2),
                'cartTotalWithShipping' => number_format($cartTotal >= 50 ? $cartTotal : $cartTotal + 5, 2),
                'freeShipping' => $cartTotal >= 50,
                'removed' => true
            ]);
        }

        return back();
    }

    /**
     * Clear cart
     *
     * @return \Illuminate\Http\Response
     */
    public function clear()
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())->delete();
        } else {
            Session::forget('cart');
        }

        return back();
    }

    /**
     * Migrate session cart to database when user logs in
     */
    public function migrateSessionCart()
    {
        if (Auth::check()) {
            $sessionCart = Session::get('cart', []);
            
            foreach ($sessionCart as $productId => $quantity) {
                $existingItem = Cart::where('user_id', Auth::id())
                    ->where('product_id', $productId)
                    ->first();
                
                if ($existingItem) {
                    $existingItem->update([
                        'quantity' => $existingItem->quantity + $quantity
                    ]);
                } else {
                    Cart::create([
                        'user_id' => Auth::id(),
                        'product_id' => $productId,
                        'quantity' => $quantity
                    ]);
                }
            }
            
            Session::forget('cart');
        }
    }

    /**
     * Get cart total
     *
     * @return float
     */
    private function getCartTotal()
    {
        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())
                ->with('product.offers')
                ->get();

            return $cartItems->sum(function ($item) {
                return $item->product->final_price * $item->quantity;
            });
        } else {
            $sessionCart = Session::get('cart', []);
            $total = 0;
            
            foreach ($sessionCart as $productId => $quantity) {
                $product = Product::with('offers')->find($productId);
                if ($product) {
                    $total += $product->final_price * $quantity;
                }
            }
            
            return $total;
        }
    }

    /**
     * Proceed to checkout
     *
     * @return \Illuminate\Http\Response
     */
    public function checkout()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.checkout', compact('cartItems', 'total'));
    }
}
