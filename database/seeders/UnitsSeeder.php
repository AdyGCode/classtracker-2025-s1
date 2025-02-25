<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path("database/data/units.csv"), "r");

        $line = true;
        while (($data = fgetcsv($csvFile, 1000, ",")) !== FALSE) {
            if (!$line) {
                DB::table('units')->insert([
                    "national_code" => $data[0],
                    "title" => $data[1],
                    "tga_status" => $data[2],
                    "state_code" => $data[3],
                    "nominal_hours" => $data[4],
                ]);
            }
            $line = false;
        }

        fclose($csvFile);
    }
}
