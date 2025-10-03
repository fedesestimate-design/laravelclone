<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'total_products' => Product::count(),
            'total_customers' => User::where('role', 'customer')->count(),
        ];

        $recentOrders = Order::with('user')->latest()->limit(10)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}


// app/Http/Controllers/Admin/OrderController.php

