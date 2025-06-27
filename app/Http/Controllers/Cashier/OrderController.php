<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->get();
        return view('cashier.orders.index', compact('orders'));
    }

    public function receipt(Order $order)
    {
        return view('cashier.receipt', compact('order'));
    }

}
