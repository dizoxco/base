<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Ticket;

class ChatManagementController extends Controller
{
    public function index(Business $business)
    {
        $business->load('chats');

        return view('profile.businesses.chats', compact('business'));
    }

    public function show(Business $business, Ticket $chat)
    {
        $business->load('chats.comments');

        return view('profile.businesses.chats', compact('business'));
    }

    public function store(Business $business, Ticket $chat)
    {
        $chat->comments()->create([
            'user_id' => auth()->id(),
            'body' => request()->body,
        ]);

        return back();
    }
}
