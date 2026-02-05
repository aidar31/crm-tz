<?php
namespace App\Repositories;


use App\Domain\Entity\Ticket as TicketEntity;
use App\Models\Ticket;
use DateTimeInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class TicketRepo
{
    public function save(TicketEntity $ticket, array $files = []): TicketEntity
    {
        $model = Ticket::from_entity($ticket);
        $model->save();

        foreach ($files as $file) {
            $model->addMedia($file)->toMediaCollection('attachments');
        }

        $model->load('media');

        return $model->to_entity();
    }

    public function getPaginated(array $filters, int $perPage = 10): LengthAwarePaginator
    {
        $query = Ticket::query()->with('customer');
        $query->filter($filters);
        $paginator = $query->latest()->paginate($perPage);

        $paginator->getCollection()->transform(fn($model) => $model->to_entity());
        return $paginator;
    }

    public function updateStatus(int $id, string $status): void
    {
        Ticket::where('id', $id)->update(['status' => $status]);
    }
    public function get_by_id(string $id): TicketEntity
    {
        $model = Ticket::findOrFail(intval($id));
        return $model->to_entity();
    }

    public function countSince(DateTimeInterface $date): int
    {
        return Ticket::createdSince($date)->count();
    }
}