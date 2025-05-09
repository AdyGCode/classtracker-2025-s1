<?php

use App\Models\User;

test('authenticated user can create a new user', function () {
    $authUser = User::factory()->create();
    $token = $authUser->createToken('TestToken')->plainTextToken;

    $data = [
        'given_name' => 'Nini',
        'family_name' => 'Maunela',
        'pronouns' => 'he/him',
        'email' => 'nini@example.com',
        'password' => 'password',
    ];

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->postJson(route('api.v1.users.store'), $data);

    $response->assertStatus(201)
        ->assertJson([
            'success' => true,
            'message' => 'User created successfully',
        ]);

    $this->assertDatabaseHas('users', ['email' => 'nini@example.com']);
});

