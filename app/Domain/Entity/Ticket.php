<?php

namespace App\Domain\Entity;

use InvalidArgumentException;


final class Ticket
{

    public string $topic {
        set => match (true) {
            strlen($value) < 7 => throw new InvalidArgumentException('Topic too short'),
            strlen($value) > 100 => throw new InvalidArgumentException('Topic too long'),
            default => $field = $value,
        };
    }

    public string $body {
        set => match (true) {
            strlen($value) < 20 => throw new InvalidArgumentException('Topic too short'),
            strlen($value) > 1665 => throw new InvalidArgumentException('Topic too long'),
            default => $field = $value,
        };
    }

    public function __construct(
        public readonly string $customerId,
        string $topic,                     
        string $body,
        public private(set) TicketStatus $status = TicketStatus::New
    ) {
        $this->topic = $topic;
        $this->body = $body;
    }
}