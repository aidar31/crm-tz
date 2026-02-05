<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Resources\TicketResource;
use App\Services\TicketService;
use Illuminate\Routing\Controller;

class TicketController extends Controller {
    public function store(StoreTicketRequest $request, TicketService $service): TicketResource {
        $ticketEntity = $service->createTicket(
            data: $request->validated(),
            uploadedFiles: $request->file('files', [])
        );

        return new TicketResource($ticketEntity);
    }
}