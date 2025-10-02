<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cart)
    {
    }

    public function index()
    {
        $items = $this->cart->items();
        $total = $this->cart->total();

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock
        ]);

        $this->cart->add($product, $request->quantity);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        $this->cart->update($productId, $request->quantity);

        return redirect()->back()->with('success', 'Cart updated!');
    }

    public function remove($productId)
    {
        $this->cart->remove($productId);

        return redirect()->back()->with('success', 'Item removed from cart!');
    }
}