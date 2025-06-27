<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Str;

class POSController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('cashier.pos.index', compact('products'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity
            ];
        }

        session(['cart' => $cart]);
        return back()->with('success', 'Product added to cart.');
    }

    public function checkout(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Cart is empty.');
        }

        $lastOrder = Order::orderBy('id', 'desc')->first();
        $invoiceNumber = $lastOrder ? ($lastOrder->id + 1000) : 1000;

        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        // Create the order
        $order = Order::create([
            'invoice_number' => $invoiceNumber,
            'total' => $total,
            'user_id' => auth()->id(),
        ]);

        // Create order items
        foreach ($cart as $item) {
            $order->items()->create([
                'item' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);
        }

        session()->forget('cart');
        return back()->with('success', 'Order placed successfully! Invoice No: ' . $invoiceNumber);
    }
}
