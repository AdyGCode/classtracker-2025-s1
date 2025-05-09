<?php

use App\Models\User;

test('authenticated user can view a single user', function () {
    $authUser = User::factory()->create();
    $token = $authUser->createToken('TestToken')->plainTextToken;

    $userToShow = User::factory()->create([
        'given_name' => 'Alice',
        'email' => 'alice@example.com',
    ]);

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->getJson(route('api.v1.users.show', $userToShow->id));

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'User found successfully',
            'data' => [
                'id' => $userToShow->id,
                'given_name' => 'Alice',
                'email' => 'alice@example.com',
            ]
        ]);
});

