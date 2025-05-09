<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user index returns a list of users', function () {
    $user = User::factory()->create();
    $token = $user->createToken('TestToken')->plainTextToken;

    $users = User::factory()->count(3)->create();

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->getJson(route('api.v1.users.index'));

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                '*' => [
                    'id',
                    'given_name',
                    'family_name',
                    'preferred_name',
                    'pronouns',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                ]
            ]
        ])
        ->assertJson([
            'success' => true,
            'message' => 'All users found successfully.',
        ]);
});

test('unauthenticated user index call returns unauthorized', function () {
    $response = $this->getJson(route('api.v1.users.index'));

    $response->assertStatus(401);
});
