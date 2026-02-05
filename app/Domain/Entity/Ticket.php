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
            strlen($value) < 20 => throw new InvalidArgumentException('Body too short'),
            strlen($value) > 1665 => throw new InvalidArgumentException('Body too long'),
            default => $field = $value,
        };
    }

    // TODO: Переписать id на ValueObjects
    public function __construct(
        public readonly string $customerId,
        string $topic,                     
        string $body,
        public private(set) TicketStatus $status = TicketStatus::New,
        public readonly ?string $id = null,
        public array $files = [], // хз незнаю как правильнее, не хотел но тут url адресса на файлы
    ) {
        $this->topic = $topic;
        $this->body = $body;
    }
}