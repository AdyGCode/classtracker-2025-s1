<?php

use App\Models\User;

test('authenticated user can delete a user', function () {
    $authUser = User::factory()->create();
    $token = $authUser->createToken('TestToken')->plainTextToken;

    $user = User::factory()->create([
        'given_name' => 'Peter',
        'family_name' => 'Parker',
    ]);

    $givenName = $user->given_name;
    $userId = $user->id;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->deleteJson(route('api.v1.users.destroy', $userId));

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'User deleted successfully',
        ]);

    $this->assertDatabaseMissing('users', [
        'id' => $userId,
        'given_name' => $givenName,
    ]);
});
