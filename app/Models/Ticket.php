<?php

namespace App\Models;

use App\Domain\Entity\Ticket as TicketEntity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ticket extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['customer_id', 'topic', 'body', 'status'];

    public static function from_entity(TicketEntity $entity): self {
        return new self([
            'customer_id' => $entity->customerId,
            'topic' => $entity->topic,
            'body' => $entity->body,
            'status' => $entity->status->value,
        ]);
    }
}