<?php

use App\Models\Donation;
use App\Models\User;

test('shows top 3 popular donations on the homepage', function () {
    User::factory()->create();
    Donation::factory()->count(5)->create(['status' => 'open']);

    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertViewHas('popularDonations', function ($popularDonations) {
        return $popularDonations->count() <= 3;
    });
});
