<?php 

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory 
{
    public function definition(): array 
    {
        return [
            'customer_id' => Customer::factory(),
            'topic' => $this->faker->sentence(5),
            'body' => $this->faker->paragraph(5),
            'status' => $this->faker->randomElement(['new', 'in_work', 'done']),
            'created_at' => $this->faker->dateTimeBetween('-60 days', 'now'),
            'updated_at' => function (array $attributes) {
                return $attributes['created_at'];
            },
        ];
    }
}