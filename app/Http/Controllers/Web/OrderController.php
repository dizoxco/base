<?php

namespace App\Http\Controllers\Web;

use Auth;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Auth::user()->orders()
            ->with('city', 'variations', 'variations.product')
            ->paginate($request->input('per_page', 12));

        return view('profile.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order = $order->load('variations.business', 'user');

        return view('profile.orders.show', compact('order'));
    }
}
