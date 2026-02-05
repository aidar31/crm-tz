<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public function toArray($request): array 
    {
        return [
            'id' => $this->resource->id,
            'customer_id' => $this->resource->customerId,
            'topic' => $this->resource->topic,
            'body' => $this->resource->body,
            'status' => $this->resource->status,

            'attachments' => $this->resource->files,
        ];
    }
}