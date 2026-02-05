<?php

namespace App\Domain\Entity;

use InvalidArgumentException;


final class Customer
{
    // TODO: Переписать id на ValueObjects

    public function __construct(
        public readonly string $name,                     
        public readonly string $email,
        public readonly string $phone_number,
        public readonly ?string $id = null
    ) {}
}