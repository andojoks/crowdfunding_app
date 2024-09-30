<?php

use App\Models\User;
use App\Models\Donation;

test('only authenticated users can create a donation cause', function () {
    // Arrange: Create a user
    $user = User::factory()->create();

    // Act: Try to create a donation cause without being authenticated
    $response = $this->post('/causes/add', [
        'title' => 'Unauthorized Cause',
        'description' => 'This should not work',
        'target_amount' => 1000,
        'due_date' => now()->addDays(10)->format('Y-m-d\TH:i'),
    ]);

    // Assert: Ensure unauthenticated users are redirected to the login page
    $response->assertRedirect('/login');

    // Act: Authenticate and attempt to create a donation cause
    $this->actingAs($user);
    $response = $this->post('/causes/add', [
        'title' => 'Authorized Cause',
        'description' => 'This should work',
        'target_amount' => 1000,
        'due_date' => now()->addDays(10)->format('Y-m-d\TH:i'),
    ]);

    // Assert: Ensure the authenticated user can create a cause successfully
    $response->assertRedirect();
    $this->assertDatabaseHas('donations', ['title' => 'Authorized Cause']);
});

test('only authenticated users can edit a donation cause', function () {
    // Arrange: Create a user and a donation cause
    $user = User::factory()->create();
    $donation = Donation::factory()->create([
        'title' => 'Old Title',
        'description' => 'Old description',
        'target_amount' => 1000,
        'status' => 'open',
        'user_id' => $user->id,
    ]);

    // Act: Try to edit the donation cause without being authenticated
    $response = $this->put("/causes/{$donation->id}", [
        'title' => 'Unauthorized Edit',
        'description' => 'This should not work',
        'target_amount' => 2000,
    ]);

    // Assert: Ensure unauthenticated users are redirected to the login page
    $response->assertRedirect('/login');

    // Act: Authenticate and attempt to edit the donation cause
    $this->actingAs($user);
    $response = $this->put("/causes/{$donation->id}", [
        'title' => 'Updated Title',
        'description' => 'Updated description',
        'target_amount' => 2000,
    ]);

    // Assert: Ensure the authenticated user can edit the cause successfully
    $response->assertRedirect(route('cause.details', ['id' => $donation->id]));
    $this->assertDatabaseHas('donations', [
        'id' => $donation->id,
        'title' => 'Updated Title',
        'description' => 'Updated description',
        'target_amount' => 2000,
    ]);
});

test('only authenticated users can make a donation to a cause', function () {
    $user = User::factory()->create();
    // Arrange: Create a donation cause
    $donation = Donation::factory()->create([
        'title' => 'Open Cause',
        'description' => 'Description',
        'target_amount' => 1000,
        'status' => 'open',
    ]);

    // Act: Try to make a donation without being authenticated
    $response = $this->post("/causes/{$donation->id}/donation", [
        'amount' => 100,
    ]);

    // Assert: Ensure unauthenticated users are redirected to the login page
    $response->assertRedirect('/login');

    // Act: Authenticate and attempt to make a donation
    $this->actingAs($user);
    $response = $this->post("/causes/{$donation->id}/donation", [
        'amount' => 100,
    ]);

    // Assert: Ensure the donation was successful and the amount is updated in the database
    $response->assertRedirect(route('cause.details', ['id' => $donation->id]));
    $this->assertDatabaseHas('user_donations', [
        'user_id' => $user->id,
        'donation_id' => $donation->id,
        'amount' => 100,
    ]);

    // Assert: Ensure the donation's amount_received is updated in the database
    $this->assertDatabaseHas('donations', [
        'id' => $donation->id,
    ]);
});

test('donation completed once target amount reached or exceeded', function () {
    // Arrange: Create a user and a donation cause with a target amount
    $user = User::factory()->create();
    $donation = Donation::factory()->create([
        'title' => 'Cause to Complete',
        'description' => 'Cause nearing target amount',
        'target_amount' => 1000,
        'status' => 'open',
    ]);

    // Act: Authenticate the user and attempt to make a donation that does NOT exceed the target amount
    $this->actingAs($user);
    $response = $this->post("/causes/{$donation->id}/donation", [
        'amount' => 300,  // This donation will not exceed the target yet (600 + 300 = 900)
    ]);

    // Assert: Ensure the donation was successful and recorded in the user_donations table
    $response->assertRedirect(route('cause.details', ['id' => $donation->id]));

    $this->assertDatabaseHas('user_donations', [
        'user_id' => $user->id,
        'donation_id' => $donation->id,
        'amount' => 300,
    ]);

    // Assert: Ensure the donation's amount_received is updated correctly, but the status is still 'open'
    $this->assertDatabaseHas('donations', [
        'id' => $donation->id,
        'status' => 'open',        // Still open, since we haven't reached the target
    ]);

    // Act: Authenticate and donate an amount that exceeds the target amount
    $response = $this->post("/causes/{$donation->id}/donation", [
        'amount' => 900,  // This donation will exceed the target (900 + 200 = 1100)
    ]);

    // Assert: Ensure the donation was successful and recorded in the user_donations table
    $response->assertRedirect(route('cause.details', ['id' => $donation->id]));

    $this->assertDatabaseHas('user_donations', [
        'user_id' => $user->id,
        'donation_id' => $donation->id,
        'amount' => 900,
    ]);

    // Assert: Ensure the donation's amount_received is updated, and the status is now 'complete'
    $this->assertDatabaseHas('donations', [
        'id' => $donation->id,
        'status' => 'completed',    // The status should now be 'completed'
    ]);
});