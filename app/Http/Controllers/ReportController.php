<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    // Daily Sales Report
    public function dailyReport(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());

        $orders = Order::whereDate('created_at', $date)->get();
        $total = $orders->sum('total');

        return view('reports.daily', compact('orders', 'date', 'total'));
    }

    // Monthly Sales Report
    public function monthlyReport(Request $request)
    {
        $month = $request->input('month', Carbon::now()->format('Y-m'));

        $orders = Order::whereYear('created_at', Carbon::parse($month)->year)
                       ->whereMonth('created_at', Carbon::parse($month)->month)
                       ->get();
        $total = $orders->sum('total');

        return view('reports.monthly', compact('orders', 'month', 'total'));
    }
}

