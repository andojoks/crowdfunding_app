<?php

use App\Models\User;
use App\Models\Donation;


test('only authenticated users can access edit donation cause page', function () {
    // Arrange: Create a user and a donation cause
    $user = User::factory()->create();
    $donation = Donation::factory()->create(['status' => 'open', 'user_id' => $user->id]);

    // Act: Try to edit a donation cause without being authenticated
    $response = $this->get("/causes/{$donation->id}/edit");

    // Assert: Ensure unauthenticated users are redirected to the login page
    $response->assertRedirect('/login');

    // Act: Authenticate and try to edit the donation cause
    $this->actingAs($user);
    $response = $this->get("/causes/{$donation->id}/edit");

    // Assert: Ensure authenticated user can access the edit form
    $response->assertStatus(200);
    $response->assertViewHas('donation', fn($viewDonation) => $viewDonation->id === $donation->id);
});

test('only authenticated users can access the create donation cause page', function () {
    // Act: Try to access the create cause page without being authenticated
    $response = $this->get('/causes/add');

    // Assert: Ensure unauthenticated users are redirected to the login page
    $response->assertRedirect('/login');

    // Arrange: Create a user
    $user = User::factory()->create();

    // Act: Authenticate and try to access the create cause page
    $this->actingAs($user);
    $response = $this->get('/causes/add');

    // Assert: Ensure the authenticated user can access the create form
    $response->assertStatus(200);
    $response->assertViewIs('causes.cause_form');  // Assuming the create form is in 'causes.create' view
});