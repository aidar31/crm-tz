<?php

namespace App\Services;

use App\Domain\Entity\Ticket as TicketEntity;
use App\Repositories\CustomerRepo;
use App\Repositories\TicketRepo;
use App\Models\Ticket as TicketModel;

use Propaganistas\LaravelPhone\PhoneNumber;

class TicketService
{
    public function __construct(
        private TicketRepo $ticket_repo,
        private CustomerRepo $customer_repo
    ) {
    }

    // TODO: вынести в CreateTicketDTO =(
    // TODO: обернуть все в одну транзакцию для надежности
    public function createTicket(array $data, array $uploadedFiles = []): TicketEntity
    {

        // TODO:  вынести в отдельный сервис Customer но пока его нет.
        // TODO: вынести E.164 в utils
        $customerEntity = new \App\Domain\Entity\Customer(
            name: $data['name'],
            email: $data['email'],
            phone_number: (string) phone($data['phone_number'])->formatE164()
        );

        $customer = $this->customer_repo->findOrCreate($customerEntity);

        $ticket = new TicketEntity(
            customerId: $customer->id,
            topic: $data["topic"],
            body: $data["body"],
        );

        return $this->ticket_repo->save($ticket, $uploadedFiles);
    }
}