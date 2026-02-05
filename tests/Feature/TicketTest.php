<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Storage;
use Tests\TestCase;


class TicketTest extends TestCase
{
    public function test_ticket_can_be_stored_with_attachments()
    {
        Storage::fake('public'); // Фейковое хранилище

        $response = $this->postJson('/api/tickets', [
            'name' => 'testtest',
            'email' => 'test@test.com',
            'topic' => 'testsetest',
            'body' => 'tessetsetsetestsettessetsetsetestset',
            'phone_number' => '77705144416',
            'attachments' => [
                UploadedFile::fake()->image('test.jpg'),
                UploadedFile::fake()->create('teststest.pdf', 100),
            ],
        ]);

        $response->assertStatus(200);
    }

}
