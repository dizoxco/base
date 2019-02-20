<?php

namespace App\Http\Controllers\Web;

use Auth;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\Business;
use App\Http\Controllers\Controller;

class BusinessManagerController extends Controller
{
    public function index()
    {
        return view('profile.businesses.index')->withBusinesses(Auth::user()->businesses);
    }

    public function create()
    {
        return view('profile.businesses.create');
    }

    public function store()
    {
        request()->merge(['contact' => [], 'status' => 0]);
        $business = auth()->user()->businesses()->create(request()->all());
        return redirect()->route('profile.businesses.show', $business->slug);
        // dd($business);
    }

    public function show(Business $business)
    {
        return view('profile.businesses.show', compact('business'));
    }

    public function products(Business $business)
    {
        $products = $business->load('products')->products;

        return view('profile.businesses.products', compact('business', 'products'));
    }

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

    public function chats(Business $business)
    {
        $business->load('chats');

        return view('profile.businesses.chats', compact('business'));
    }

    public function showChat(Business $business, Ticket $chat)
    {
        $business->load('chats.comments');

        return view('profile.businesses.chats', compact('business'));
    }

    public function storeChatComment(Business $business, Ticket $chat)
    {
        $chat->comments()->create([
            'user_id' => auth()->id(),
            'body' => request()->body,
        ]);

        return back();
    }
}
