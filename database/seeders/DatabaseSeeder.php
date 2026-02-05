<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Ticket;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        $this->call([
            RoleSeeder::class,
        ]);

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password'=> bcrypt('test12345678'),
        ]);

        $user->assignRole(['manager']);


        Customer::factory(10)
        ->has(Ticket::factory()->count(rand(2, 5)))
        ->create();

        $vipCustomer = Customer::factory()->create(['name' => 'VIP Customer']);

        Ticket::factory(5)->create([
            'customer_id' => $vipCustomer->id,
            'created_at' => now()->subHours(rand(1, 5)),
        ]);

        Ticket::factory(10)->create([
            'customer_id' => $vipCustomer->id,
            'created_at' => now()->subDays(10),
        ]);
    }
}
