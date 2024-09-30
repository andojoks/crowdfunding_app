<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Donation;
use App\Models\User;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 2 donations for each user
        User::all()->each(function ($user) {
            Donation::factory()->count(5)->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
