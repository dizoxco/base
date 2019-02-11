<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\StoreTicketRequest;
use App\Models\Ticket;
use Auth;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Auth::user()->tickets;

        return view('profile.tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('profile.tickets.create');
    }

    public function store(StoreTicketRequest $request)
    {
        $ticket = Auth::user()->tickets()->create(['business_id' => 0]);
        $request->merge(['user_id' => Auth::id()]);
        $ticket->comments()->create($request->all());

        return redirect()->route('profile.tickets.show', $ticket);
    }

    public function show(Ticket $ticket)
    {
        $ticket->load('comments');

        return view('profile.tickets.show', compact('ticket'));
    }

    public function reply(Request $request, Ticket $ticket)
    {
        $request->merge(['user_id' => Auth::id(),]);
        $ticket->comments()->create($request->all());

        return redirect()->route('profile.tickets.show', $ticket);
    }

    public function toggle(Ticket $ticket)
    {
        $attr = $ticket->attribute;
        if ($ticket->is_open === null) {
            $attr = array_merge($attr, ['is_open' => false,]);
        } else {
            $attr = array_merge($attr, ['is_open' => ! $ticket->is_open,]);
        }

        $ticket->attribute = $attr;
        $ticket->saveOrFail();

        return redirect()->back();
    }
}
