<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Domain\Entity\Ticket as TicketEntity;
use App\Domain\Entity\TicketStatus;
use App\Repositories\TicketRepo;

class TicketRepoTest extends TestCase
{
    use RefreshDatabase;

    public function test_correctly_save(): void
    {
        $customer = \App\Models\Customer::factory()->create();

        $id = (string)$customer->id;
        $topic = 'Hello world';
        $body = 'hello my dear friends, i love mr robot :D';
        $status = TicketStatus::New;

        $ticket = new TicketEntity(
            customerId: $id,
            topic: $topic,
            body: $body,
            status: $status
        );

        $repo = new TicketRepo();
        $repo->save($ticket);

        $this->assertDatabaseHas('tickets', ['customer_id' => $id]);
    }

    public function test_get_by_id(): void {
        $customer = \App\Models\Customer::factory()->create();

        $id = (string)$customer->id;
        $topic = 'Hello world';
        $body = 'hello my dear friends, i love mr robot :D';
        $status = TicketStatus::New;

        $ticket = new TicketEntity(
            customerId: $id,
            topic: $topic,
            body: $body,
            status: $status
        );

        $repo = new TicketRepo();
        $saved_ticket = $repo->save($ticket);

        $found_ticket = $repo->get_by_id($saved_ticket->id);

        $this->assertEquals($saved_ticket->id, $found_ticket->id);
    }
}
