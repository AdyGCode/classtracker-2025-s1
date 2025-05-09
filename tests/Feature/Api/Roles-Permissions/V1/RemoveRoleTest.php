<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

test('authenticated user can remove a role from another user', function () {
    $authUser = User::factory()->create([
        'given_name' => 'Admin User',
        'email' => 'admin@example.com',
    ]);

    $userRoleToRemove = User::factory()->create([
        'given_name' => 'Sofia Neri',
        'email' => 'sofia@example.com',
    ]);

    Role::create(['name' => 'Admin']);
    Role::create(['name' => 'Super Admin']);

    $authUser->assignRole('Super Admin');
    $userRoleToRemove->assignRole('Admin');

    $token = $authUser->createToken('TestToken')->plainTextToken;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->deleteJson('/api/v1/roles-permissions/remove', [
            'user_id' => $userRoleToRemove->id,
            'role' => 'Admin',
        ]);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Role removed from user successfully.',
        ]);

    $this->assertFalse($userRoleToRemove->fresh()->hasRole('Admin'));
});
