<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

test('authenticated user can fetch roles and users', function () {
    // Create a user named Sofia Neri
    $user = User::factory()->create([
        'given_name' => 'Sofia Neri',
        'email' => 'sofia@example.com'
    ]);

    $role = Role::create(['name' => 'admin']);

    $token = $user->createToken('TestToken')->plainTextToken;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->getJson('/api/v1/roles-permissions');

    $response->assertStatus(200);

    $response->assertJson([
        'success' => true,
        'message' => 'Roles and users retrieved successfully',
        'data' => [
            'roles' => [
                [
                    'name' => 'admin'
                ]
            ],
            'users' => [
                [
                    'given_name' => 'Sofia Neri',
                    'email' => 'sofia@example.com'
                ]
            ]
        ]
    ]);
});
