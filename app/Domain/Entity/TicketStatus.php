<?php 

namespace App\Domain\Entity;

enum TicketStatus: string
{
    case New = 'new';
    case InWork = 'in_work';
    case Done = 'done';

    public function label(): string
    {
        return match ($this) {
            self::New => 'Новый тикет',
            self::InWork => 'В работе',
            self::Done => 'Обработан',
        };
    }
}