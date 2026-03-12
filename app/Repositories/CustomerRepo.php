<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Domain\Entity\Customer as CustomerEntity;

class CustomerRepo
{
    // TODO: this need refactoring
    public function findOrCreate(CustomerEntity $entity): CustomerEntity
    {
        $model = Customer::where('email', $entity->email)
        ->orWhere('phone_number', $entity->phone_number)
        ->first();

        if ($model) {
            $model = Customer::create([
                'email' => $entity->email,
                'name' => $entity->name,
                'phone_number' => $entity->phone_number,
            ]);
        }

        return $model->to_entity();
    }
}