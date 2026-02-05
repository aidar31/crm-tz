<?php

namespace App\Models;

use App\Domain\Entity\Ticket as TicketEntity;

use App\Domain\Entity\TicketStatus;
use App\Domain\Entity\Customer as CustomerEntity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ticket extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['customer_id', 'topic', 'body', 'status'];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

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

    public function scopeCreatedAfter($query, $hours)
    {
        return $query->where('created_at', '>=', Carbon::now()->subHours($hours));
    }

    public function scopeCreatedSince($query, $date)
    {
        return $query->where('created_at', '>=', $date);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['status'] ?? null, function ($q, $status) {
            $q->where('status', $status);
        })
            ->when($filters['date_from'] ?? null, function ($q, $date) {
                $q->whereDate('created_at', '>=', $date);
            })
            ->when($filters['date_to'] ?? null, function ($q, $date) {
                $q->whereDate('created_at', '<=', $date);
            })
            // Фильтрация по полям связанной модели Customer
            ->when($filters['search'] ?? null, function ($q, $search) {
                $q->whereHas('customer', function ($q) use ($search) {
                    $q->where('email', 'like', "%{$search}%")
                        ->orWhere('phone_number', 'like', "%{$search}%");
                });
            });
    }

    public function to_entity(): TicketEntity
    {
        $customerEntity = $this->customer ? new CustomerEntity(
            name: $this->customer->name,
            email: $this->customer->email,
            phone_number: $this->customer->phone_number,
            id: (string) $this->customer->id
        ) : null;

        return new TicketEntity(
            customerId: (string) $this->customer_id,
            topic: $this->topic,
            body: $this->body,
            status: TicketStatus::from($this->status),
            id: (string) $this->id,
            customer: $customerEntity,
            files: $this->getMedia('attachments')->map(fn($media) => $media->getFullUrl())->toArray()
        );
    }
}