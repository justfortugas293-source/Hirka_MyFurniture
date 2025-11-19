<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1,
                'stock' => $product->stock ?? 0,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    /**
     * Buy now: put only this product in the session cart (with requested qty) and redirect to checkout.
     */
    public function buyNow($id, \Illuminate\Http\Request $request)
    {
        $product = Product::select('id', 'name', 'price', 'image', 'stock')
            ->where('id', $id)
            ->first();

        if (!$product) {
            return redirect()->back()->withErrors('Product not found.');
        }

        $qty = (int) $request->query('qty', 1);
        if ($qty < 1) $qty = 1;
        if (($product->stock ?? 0) < $qty) {
            // If requested qty exceeds stock, limit to stock
            $qty = $product->stock ?? 0;
        }

        $cart = [];
        $cart[$product->id] = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->image,
            'quantity' => $qty,
            'stock' => $product->stock ?? 0,
        ];

        session()->put('cart', $cart);

        return redirect()->route('checkout');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart!');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        return view('cart.checkout', compact('cart'));
    }

    public function processCheckout(Request $request)
    {
        $cart = session()->get('cart', []);

        // If quantities were adjusted on the checkout page, update the session cart
        if ($request->has('quantities') && is_array($request->input('quantities'))) {
            $quantities = $request->input('quantities');
            foreach ($quantities as $pid => $q) {
                if (isset($cart[$pid])) {
                    $qty = (int) $q;
                    if ($qty < 1) $qty = 1;
                    // limit to available stock if provided
                    $stock = $cart[$pid]['stock'] ?? 0;
                    if ($stock > 0 && $qty > $stock) $qty = $stock;
                    $cart[$pid]['quantity'] = $qty;
                }
            }
            session()->put('cart', $cart);
        }

        if (empty($cart)) {
            return redirect()->route('cart.index')->withErrors('Your cart is empty.');
        }

        $data = $request->validate([
            'shipping_address' => 'required|string|max:1000',
        ]);

        // Validate stock availability
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if (!$product) {
                return redirect()->route('cart.index')->withErrors('Product not found: ' . $item['name']);
            }
            if (($product->stock ?? 0) < ($item['quantity'] ?? 1)) {
                return redirect()->route('cart.index')->withErrors('Not enough stock for ' . $product->name);
            }
        }

        // Everything ok, compute subtotal and shipping
        $subtotal = 0;
        foreach ($cart as $id => $it) {
            $subtotal += ($it['price'] * ($it['quantity'] ?? 1));
        }

        // shipping fee (in IDR); default 20.000 if not provided via request/env
        $shippingFee = (int) $request->input('shipping_fee', env('SHIPPING_FEE', 20000));
        if ($shippingFee < 0) $shippingFee = 0;

        $total = $subtotal + $shippingFee;

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'shipping_address' => $data['shipping_address'] ?? null,
                'shipping_fee' => $shippingFee,
            ]);

            foreach ($cart as $productId => $item) {
                $qty = $item['quantity'] ?? 1;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'price' => $item['price'],
                    'quantity' => $qty,
                ]);

                // decrement stock
                $product = Product::find($productId);
                $product->decrement('stock', $qty);
            }

            DB::commit();

            // clear cart
            session()->forget('cart');

            return redirect()->route('checkout.confirmation', $order->id)->with('success', 'Order placed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Log the exception for debugging and show a clear error on the checkout page
            try {
                \Illuminate\Support\Facades\Log::error('Checkout failed: ' . $e->getMessage(), ['exception' => $e]);
            } catch (\Throwable $t) {
                // ignore logging failures
            }

            return redirect()->back()->withErrors('Failed to place order: ' . $e->getMessage())->withInput();
        }
    }

    public function confirmation($orderId)
    {
        $order = Order::with('items.product')->findOrFail($orderId);
        return view('cart.confirmation', compact('order'));
    }

    /**
     * Show printable invoice for an order. Only the owner or admins can view.
     */
    public function invoice($orderId)
    {
        $order = Order::with('items.product', 'user')->findOrFail($orderId);

        // authorization: owner or admin
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }

        if ($order->user_id !== $user->id && !($user->is_admin ?? false)) {
            abort(403);
        }

        return view('cart.invoice', compact('order'));
    }
    

}
