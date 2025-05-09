<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

test('authenticated user can get users roles', function () {
    $superUser = User::factory()->create([
        'preferred_name' => 'Taylor Jadyn',
        'email' => 'adam@example.com',
    ]);

    $adminUser = User::factory()->create([
        'preferred_name' => 'Sofia Neri',
        'email' => 'Sofia@example.com',
    ]);

    $staffUser = User::factory()->create([
        'preferred_name' => 'Jorja Bean',
        'email' => 'jorja@example.com',
    ]);

    Role::create(['name' => 'Super Admin']);
    Role::create(['name' => 'Admin']);
    Role::create(['name' => 'Staff']);

    $superUser->assignRole('Super Admin');
    $adminUser->assignRole('Admin');
    $staffUser->assignRole('Staff');

    $token = $superUser->createToken('TestToken')->plainTextToken;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
    ->getJson('/api/v1/roles-permissions/user/2');


    $response->assertStatus(200);

    $response->assertJson([
        'success' => true,
        'message' => 'User roles retrieved successfully',
        'data' => [
            'user' => 'Sofia Neri',
            'roles' => [
                'Admin',
            ],
        ],
    ]);
});
