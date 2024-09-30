<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Donation;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserDonation>
 */
class UserDonationFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id, // Random user
            'donation_id' => Donation::inRandomOrder()->first()->id, // Random donation
            'amount' => $this->faker->numberBetween(10, 100), // Random donation amount
        ];
    }
}
