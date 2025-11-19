<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Cache each page of the product listing for a short time to reduce DB load.
        // Include the search query in the cache key so different searches don't collide.
        $q = trim((string) $request->input('q', ''));
        $page = $request->get('page', 1);
        $cacheKey = "products.page.{$page}.q." . md5($q);

        $products = cache()->remember($cacheKey, 30, function () use ($q) {
            $query = Product::select('id', 'name', 'price', 'image', 'stock')
                ->orderBy('id', 'desc');

            if ($q !== '') {
                // simple partial match on name (case-insensitive depending on DB collation)
                $query->where('name', 'like', "%{$q}%");
            }

            return $query->paginate(12);
        });

        // Ensure pagination links keep the search query
        if ($q !== '') {
            $products->appends(['q' => $q]);
        }

        return view('home', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('product.show', compact('product'));
    }

    // ✅ tampilkan keranjang
    public function cart(Request $request)
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // ✅ tambahkan produk ke keranjang
    public function addToCart($id)
    {
        // Fetch only needed fields to minimize DB load
        $product = Product::select('id', 'name', 'price', 'image', 'stock')
            ->where('id', $id)
            ->firstOrFail();
        $cart = session()->get('cart', []);

        // kalau produk sudah ada di keranjang, tambahkan quantity
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'stock' => $product->stock ?? 0,
                'image' => $product->image,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }
}
    

