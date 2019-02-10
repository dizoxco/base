<?php

namespace App\Http\Controllers\Web;

use Auth;
use App\Models\Ticket;
use App\Models\Business;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\StoreBusinessChatRequest;

class ChatController extends Controller
{
    public function store(StoreBusinessChatRequest $request, Business $business)
    {
        $request->merge(['user_id' => Auth::id()]);
        Ticket::firstOrCreate(['user_id' => Auth::id(), 'business_id' => $business->id])
            ->comments()->create($request->all());

        return redirect()->route('businesses.chat.show', $business->slug);
    }

    public function show(Business $business)
    {
        if ($chat = $business->tickets()->whereUserId(Auth::id())->first()) {
            $chat->load('comments');
        }

        return view('web.businesses.chat', compact('chat', 'business'));
    }
}
