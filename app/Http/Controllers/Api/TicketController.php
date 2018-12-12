<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Chat as Ticket;
use App\Http\Resources\DBResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\TicketResource;
use App\Http\Resources\TicketCollection;
use App\Repositories\Facades\TicketRepo;

class TicketController extends Controller
{
    public function index()
    {
        if (auth_user()->hasPermissionTo('manage_tickets', 'api')) {
            $tickets = TicketRepo::getAll();
        } else {
            $tickets = TicketRepo::getByUser(auth_user());
        }
        return new TicketCollection($tickets);
    }

    public function store(Request $request)
    {
        $createdTicket = TicketRepo::create($request->all());

        if ($createdTicket === 0) {
            return new DBResource($createdTicket);
        }

        return new TicketResource($createdTicket);
    }

    public function show(Ticket $ticket)
    {
        if ($ticket->type === enum('chat.type.ticket')) {
            return new TicketResource($ticket->load(['comments', 'comments.media']));
        } else {
            return Response::modelNotFound();
        }
    }

    public function update(Request $request, Ticket $ticket)
    {
        $createdComment = TicketRepo::storeComment($ticket, $request->all());

        if ($createdComment === 0) {
            return new DBResource(0);
        }

        return new TicketResource($createdComment);
    }
}
