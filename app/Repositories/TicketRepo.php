<?php 

use App\Domain\Entity\Ticket as TicketEntity;
use App\Models\Ticket;

class TicketRepo {
    public function save(TicketEntity $ticket): void {
        $model = Ticket::from_entity($ticket);

        $model->save();
    }
}