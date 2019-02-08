<?php

namespace App\Http\Controllers\Web;

use Auth;
use Illuminate\Http\Request;
use App\Models\Chat as Ticket;
use App\Http\Controllers\Controller;
use App\Repositories\Facades\TicketRepo;
use App\Http\Requests\Ticket\StoreTicketRequest;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = auth()->user()->tickets;

        return view('profile.tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('profile.tickets.create');
    }

    public function store(StoreTicketRequest $request)
    {
        TicketRepo::create($request->all());

        return redirect()->route('profile.tickets');
    }

    public function show(Ticket $ticket)
    {
        $ticket->load('comments', 'comments.user');

        return view('profile.tickets.show', compact('ticket'));
    }

    public function reply(Request $request, Ticket $ticket)
    {
        $request->merge([
            'user_id' => Auth::id(),
        ]);

        $ticket->comments()->create($request->all());

        return view('profile.tickets.show', compact('ticket'));
    }

    public function toggle(Ticket $ticket)
    {
        $attr = $ticket->attribute;
        if ($ticket->is_open === null) {
            $attr = array_merge($attr, [
                'is_open' => false,
            ]);
        } else {
            $attr = array_merge($attr, [
                'is_open' => ! $ticket->is_open,
            ]);
        }

        $ticket->attribute = $attr;
        $ticket->saveOrFail();

        return redirect()->back();
    }
}
