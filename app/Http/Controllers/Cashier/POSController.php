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
        if (!$cart) {
            return redirect()->back()->withErrors('Cart is empty');
        }

        $request->validate([
            'payment_method' => 'required|string|in:cash,card,mobile',
            'amount_given' => 'nullable|numeric|min:0',
        ]);

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $amountGiven = $request->input('amount_given', 0);
        $paymentMethod = $request->input('payment_method');

        $balance = 0;
        if ($paymentMethod === 'cash') {
            $balance = max(0, $amountGiven - $total);
        }

        // Generate invoice number starting at 1000
        $lastOrder = Order::orderByDesc('id')->first();
        if ($lastOrder && is_numeric($lastOrder->invoice_number)) {
            $newInvoiceNumber = intval($lastOrder->invoice_number) + 1;
        } else {
            $newInvoiceNumber = 1000;
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'total' => $total,
            'payment_method' => $paymentMethod,
            'amount_given' => $amountGiven,
            'balance' => $balance,
            'invoice_number' => $newInvoiceNumber,
            // other fields...
        ]);

        // Save order items here...

        session()->forget('cart');

        return redirect()->route('cashier.orders.receipt', $order)->with('success', 'Order completed successfully!');
    }
}
