<?php

namespace App\Models;

use App\Domain\Entity\Ticket as TicketEntity;

use App\Domain\Entity\TicketStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ticket extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['customer_id', 'topic', 'body', 'status'];

    public static function from_entity(TicketEntity $entity): self
    {
        $model = new self([
            'customer_id' => $entity->customerId,
            'topic' => $entity->topic,
            'body' => $entity->body,
            'status' => $entity->status->value,
        ]);


        if ($entity->id) {
            $model->id = $entity->id;
            $model->exists = true;
        }

        return $model;
    }

    public function to_entity(): TicketEntity
    {
        return new TicketEntity(
            customerId: (string) $this->customer_id,
            topic: $this->topic,
            body: $this->body,
            status: TicketStatus::from($this->status),
            id: (string) $this->id,
            files: $this->getMedia('attachments')->map(fn($media) => $media->getFullUrl())->toArray()
        );
    }
}