<?php

use App\Models\User;

test('authenticated user can update a user', function () {
    $authUser = User::factory()->create();
    $token = $authUser->createToken('TestToken')->plainTextToken;

    $user = User::factory()->create([
        'given_name' => 'Louis',
        'family_name' => 'Carrington',
    ]);

    $updateData = [
        'given_name' => 'Jonathan',
        'family_name' => 'Cadge',
    ];

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->putJson(route('api.v1.users.update', $user->id), $updateData);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'User updated successfully',
        ]);

    $this->assertDatabaseMissing('users', [
        'id' => $user->id,
        'given_name' => 'Louis',
        'family_name' => 'Carrington',
    ]);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'given_name' => 'Jonathan',
        'family_name' => 'Cadge',
    ]);
});
