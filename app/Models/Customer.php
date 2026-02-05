<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Domain\Entity\Customer as CustomerEntity;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'phone_number'];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public static function from_entity(CustomerEntity $entity): self
    {
        $model = new self([
            'name' => $entity->name,
            'email' => $entity->email,
            'phone_number' => $entity->phone_number,
        ]);

        if ($entity->id) {
            $model->id = $entity->id;
            $model->exists = true;
        }

        return $model;
    }

    public function to_entity(): CustomerEntity
    {
        return new CustomerEntity(
            name: $this->name,
            email: $this->email,
            phone_number: $this->phone_number,
            id: $this->id ? (string) $this->id : null
        );
    }
}