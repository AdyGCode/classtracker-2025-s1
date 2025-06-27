<?php

namespace Database\Seeders;

use App\Models\Lesson;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(env('APP_ENV') === 'production') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }
        // Truncate related tables first to avoid FK conflicts
        DB::table('lesson_user')->truncate();
        DB::table('lessons')->truncate();

        // Re-enable foreign key checks
        if(env('APP_ENV') === 'production') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        // Seed lessons
        Lesson::factory(20)->create();
    }
}
