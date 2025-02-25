<?php

namespace Database\Seeders;

use App\Models\Session;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(
            [
                RolesPermissionsSeeder::class,
                UserSeeder::class,
                ClustersSeeder::class,
                CoursesSeeder::class,
                UnitsSeeder::class,
                PackagesSeeder::class,
//                SessionSeeder::class,
            ]
        );

//        UserController::factory()->create([
//            'name' => 'Test UserController',
//            'email' => 'test@example.com',
//        ]);
    }
}
