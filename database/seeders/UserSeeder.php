<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // get the Super Admin and Admin roles for the Administrator, Lecturer and Student
        $roleSuperAdmin = Role::whereName('Super Admin')->get();
        $roleAdmin = Role::whereName('Admin')->get();
        $roleStaff = Role::whereName('Staff')->get();
        $roleStudent = Role::whereName('Student')->get();

        // Create Super Admin User and assign the role to him.
        $userSuperAdmin = User::create([
            'id' => 111,
            'given_name' => 'Administrator',
            'family_name' => 'Ad',
            'preferred_name' => 'Administrator',
            'pronouns' => 'they/them',
            'email' => 'admin@example.com',
            'password' => 'Password1',
            'email_verified_at' => now(),
        ]);
        $userSuperAdmin->assignRole([$roleSuperAdmin]);

        // Create Admin User and assign the role to them
        $userAdmin = User::create([
            'id' => 222,
            'given_name' => 'Cat',
            'family_name' => 'A\'Tonic',
            'preferred_name' => 'Cat',
            'pronouns' => 'she/her',
            'email' => 'cat.atonic@example.com',
            'password' => 'Password1',
            'email_verified_at' => now(),
        ]);
        $userAdmin->assignRole([$roleAdmin]);

        $userStaff = User::create([
            'id' => 555,
            'given_name' => 'Adrian',
            'family_name' => 'Gould',
            'preferred_name' => 'Adrian',
            'pronouns' => 'he/him',
            'email' => 'adrian.gould@example.com',
            'password' => 'Password1',
            'email_verified_at' => now(),
        ]);
        $userStaff->assignRole([$roleStaff]);

        $userStudent = User::create([
            'id' => 666,
            'given_name' => 'Dee',
            'family_name' => 'Mouser',
            'preferred_name' => 'Dee',
            'pronouns' => 'they/them',
            'email' => 'dee.mouser@example.com',
            'password' => 'Password1',
            'email_verified_at' => now(),
        ]);
        $userStudent->assignRole([$roleStudent]);

        $userStudent = User::create([
                'given_name' => 'Staff1',
                'family_name' => 'User1',
                'preferred_name' => 'Staff1',
                'pronouns' => 'he/him',
                'email' => 'test1@example.com',
                'password' => Hash::make('Password1'),
                'email_verified_at' => now(),
        ]);
        $userStudent->assignRole([$roleStaff]);

        $userStudent = User::create([
                'given_name' => 'Student2',
                'family_name' => 'User2',
                'preferred_name' => 'Student2',
                'pronouns' => 'she/her',
                'email' => 'test2@example.com',
                'password' => Hash::make('Password1'),
                'email_verified_at' => now(),
        ]);
        $userStudent->assignRole([$roleStudent]);

        $userStudent = User::create([
                'given_name' => 'Student3',
                'family_name' => 'User3',
                'preferred_name' => 'Student3',
                'pronouns' => 'they/them',
                'email' => 'test3@example.com',
                'password' => Hash::make('Password1'),
                'email_verified_at' => now(),
        ]);
        $userStudent->assignRole([$roleStudent]);

        $userStudent = User::create([
            'given_name' => 'Student4',
            'family_name' => 'User4',
            'preferred_name' => 'Student4',
            'pronouns' => 'they/them',
            'email' => 'test4@example.com',
            'password' => Hash::make('Password1'),
            'email_verified_at' => now(),
        ]);
        $userStudent->assignRole([$roleStudent]);

//        User::factory()->createMany([
//            [
//
//        ]);
    }
}
