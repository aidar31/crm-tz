<?php 
namespace App\Repositories;


use App\Domain\Entity\Ticket as TicketEntity;
use App\Models\Ticket;

class TicketRepo {
    public function save(TicketEntity $ticket, array $files = []): TicketEntity {
        $model = Ticket::from_entity($ticket);
        $model->save();

        foreach ($files as $file) {
            $model->addMedia($file)->toMediaCollection('attachments');
        }

        $model->load('media');

        return $model->to_entity();
    }

    public function get_by_id(string $id): TicketEntity {
        $model = Ticket::findOrFail(intval($id));
        return $model->to_entity();
    }
}