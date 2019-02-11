<?php

namespace App\Http\Controllers\Web;

use App\Models\Ticket;
use Auth;
use App\Models\Business;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\StoreTicketRequest;

class ChatController extends Controller
{
    public function index()
    {
        $chats = Auth::user()->chats()->with('business')->get();

        return view('profile.chats.index', compact('chats'));
    }

    public function show(Business $business)
    {
        $chat = $business->chats()->firstOrCreate(['user_id' => Auth::id()]);
        $comments = $chat->comments;

        return view('profile.chats.show', compact('chat', 'comments'));
    }

    public function store(StoreTicketRequest $request, Business $business)
    {
        $request->merge(['user_id' => Auth::id()]);
        Ticket::firstOrCreate(['user_id' => Auth::id(), 'business_id' => $business->id])
            ->comments()->create($request->all());
        return redirect()->route('profile.chats.show', $business->slug);
    }
}
