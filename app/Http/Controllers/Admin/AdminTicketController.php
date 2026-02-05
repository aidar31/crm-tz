<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ticket;

use App\Services\TicketService;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;


class AdminTicketController extends Controller
{
    public function index(Request $request, TicketService $service)
    {
        $tickets = $service->getFilteredTickets($request->all());
        return view('admin.tickets.index', compact(var_name: 'tickets'));
    }
    public function show(Ticket $ticket)
    {
        $ticketEntity = $ticket->to_entity();

        return view('admin.tickets.show', [
            'ticket' => $ticketEntity
        ]);
    }
    public function updateStatus(Request $request, TicketService $service, int $id)
    {
        $service->changeStatus($id, $request->status);
        return back()->with('success', 'Статус обновлен');
    }
}