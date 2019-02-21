<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Order;

class OrderManagementController extends Controller
{
    public function orders(Business $business)
    {
        $orders = $business->products()->with('relatedVariations.orders.city', 'relatedVariations.orders.user')->get();
        $orders = $orders->pluck('relatedVariations')->collapse()->pluck('orders')->collapse();

        return view('profile.businesses.orders', compact('orders', 'business'));
    }

    public function showOrder(Business $business, Order $order)
    {
        $variations = $order->load('variations')->variations;

        return view('profile.businesses.showOrder', compact('business', 'order', 'variations'));
    }
}
