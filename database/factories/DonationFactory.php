<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donation>
 */
class DonationFactory extends Factory
{

    // Possible statuses for donations
    //    $statuses = ['draft', 'open', 'closed'];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id, // Assign a random user
            'target_amount' => $this->faker->numberBetween(5000, 10000),
            'status' => 'open', // Default status
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(15),
            'due_date' => Carbon::now('Africa/Lagos')->addDays(rand(8, 20))->setTimezone('UTC'),
            'details' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
