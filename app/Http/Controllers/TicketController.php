<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Resources\TicketResource;
use App\Services\TicketService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Request;

class TicketController extends Controller {
    public function store(StoreTicketRequest $request, TicketService $service): TicketResource {
        $ticketEntity = $service->createTicket(
            data: $request->validated(),
            uploadedFiles: $request->file('files', [])
        );

        return new TicketResource($ticketEntity);
    }

    public function getStatistics(Request $request, TicketService $service) {
        $stats = $service->getStatistics();
        return response()->json([
            'data' => [
                'tickets_count' => [
                    'last_day' => $stats['day'],
                    'last-week' => $stats['week'],
                    'month' => $stats['month'],
                    'test' => $stats['test'],
                ]
            ]
        ]);
    }
}