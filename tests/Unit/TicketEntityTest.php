<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\Domain\Entity\Ticket;
use App\Domain\Entity\TicketStatus;

class TicketEntityTest extends TestCase
{
    public function test_ticket_entity_correctly_validate(): void
    {
        $id = '13245';
        $topic = 'Hello world';
        $body = 'hello my dear friends, i love mr robot :D';
        $status = TicketStatus::New;

        $ticket = new Ticket(
            customerId: $id,
            topic: $topic,
            body: $body,
            status: $status
        );

        $this->assertEquals($id, $ticket->customerId);
        $this->assertEquals($topic, $ticket->topic);
        $this->assertEquals($body, $ticket->body);
        $this->assertEquals($status, $ticket->status);
        $this->assertStringContainsString('hello', $ticket->body);
    }


    public function test_ticket_thorow_exception_topic_too_long(): void
    {
        $id = '13245';
        $topic = str_repeat('hello', 100);
        $body = 'hello my dear friends, i love mr robot :D';
        $status = TicketStatus::New;

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Topic too long');

        $ticket = new Ticket(
            customerId: $id,
            topic: $topic,
            body: $body,
            status: $status
        );
    }


    public function test_ticket_thorow_exception_topic_too_short(): void
    {
        $id = '13245';
        $topic = 'hell';
        $body = 'hello my dear friends, i love mr robot :D';
        $status = TicketStatus::New;

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Topic too short');

        $ticket = new Ticket(
            customerId: $id,
            topic: $topic,
            body: $body,
            status: $status
        );
    }
}
