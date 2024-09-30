<?php

use App\Models\User;
use App\Models\Donation;

test('can view open donations', function () {
    User::factory()->create();
    Donation::factory()->count(5)->create(['status' => 'open']);
    Donation::factory()->count(5)->create(['status' => 'closed']);

    $response = $this->get('/causes');

    $response->assertStatus(200);
    $response->assertViewHas('donations');
    $response->assertViewHas('donations', function ($donations) {
        return $donations->count() == 5;
    });
});

test('user can view personally created causes', function () {
    $user = User::factory()->create();
    Donation::factory()->count(3)->create(['status' => 'open', 'user_id' => $user->id]);

    $this->actingAs($user);

    // Act: Make a GET request to view the user's own causes
    $response = $this->get('/my-causes');
    

    // Assert: Check that the response contains the user's causes
    $response->assertStatus(200);
    $response->assertViewHas('donations', function ($donations) use ($user) {
        return $donations->every(fn($donation) => $donation->user_id === $user->id);
    });
});
