<?php

namespace App\Http\Controllers\Web;

use App\Models\Order;
use App\Models\Business;
use App\Http\Controllers\Controller;

class OrderManagementController extends Controller
{
    public function index(Business $business)
    {
        $orders = $business->products()->with('variations.orders.city', 'variations.orders.user')->get();
        $orders = $orders->pluck('variations')->collapse()->pluck('orders')->collapse();

        return view('profile.businesses.orders.index', compact('orders', 'business'));
    }

    public function show(Business $business, Order $order)
    {
        $variations = $order->load('variations')->variations;

        return view('profile.businesses.orders.show', compact('business', 'order', 'variations'));
    }
}
