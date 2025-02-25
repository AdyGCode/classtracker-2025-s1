<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/data/courses.csv"), "r");

        $line = true;
        while (($data = fgetcsv($csvFile, 1000, ",")) !== FALSE) {
            if (!$line) {
                DB::table('courses')->insert([
                    "national_code" => $data[0],
                    "aqf_level" => $data[1],
                    "title" => $data[2],
                    "tga_status" => $data[3],
                    "state_code" => $data[4],
                    "nominal_hours" => $data[5],
                    "type" => $data[6],
                    "qa" => $data[7],
                    "nat_code" => $data[8],
                    "nat_title" => $data[9],
                    "nat_code_title" => $data[10],
                ]);
            }
            $line = false;
        }

        fclose($csvFile);
    }
}
