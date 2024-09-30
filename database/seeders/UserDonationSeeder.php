<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserDonation;
use App\Models\Donation;
use App\Models\User;
class UserDonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 2 donations for each user
        User::all()->each(function ($user) {
            // For each donation, create a random number of user donations
            Donation::all()->each(function ($donation) {
                // Create random number (between 1 and 5) of donations for each donation campaign
                UserDonation::factory()->count(rand(1, 5))->create([
                    'donation_id' => $donation->id,
                    'user_id' => User::inRandomOrder()->first()->id, // Random user donates
                ]);
            });
        });
    }
}
