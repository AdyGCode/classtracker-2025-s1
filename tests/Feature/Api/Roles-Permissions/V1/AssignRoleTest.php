<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

test('authenticated user can assign a role to another user', function () {
    $authUser = User::factory()->create([
        'given_name' => 'Admin User',
        'email' => 'admin@example.com',
    ]);

    $userToAssign = User::factory()->create([
        'given_name' => 'Sofia Neri',
        'email' => 'sofia@example.com'
    ]);

    Role::create(['name' => 'Admin']);
    Role::create(['name' => 'Super Admin']);

    $authUser->assignRole('Super Admin');

    $token = $authUser->createToken('TestToken')->plainTextToken;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->postJson('/api/v1/roles-permissions/assign', [
            'user_id' => $userToAssign->id,
            'role' => 'Admin',
        ]);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Role assigned to user successfully.',
        ]);

    $this->assertTrue($userToAssign->fresh()->hasRole('Admin'));
});
