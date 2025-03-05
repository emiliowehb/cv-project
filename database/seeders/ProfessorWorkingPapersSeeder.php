<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\Professor;
use App\Models\Department;
use App\Models\IntellectualContribution;

class ProfessorWorkingPapersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('en_US');
        for ($i = 1; $i <= 15; $i++) {
            $workingPaper = [
                'professor_id' => 3,
                'department_id' => Department::inRandomOrder()->first()->id,
                'year' => rand(2000, 2025),
                'identifying_number' => 'WPB-' . $faker->numberBetween(982439, 10909009),
                'name' => $faker->streetName(),
                'notes' => $faker->sentence(),
                'intellectual_contribution_id' => IntellectualContribution::inRandomOrder()->first()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            DB::table('professor_working_papers')->insert($workingPaper);
        }
    }
}
