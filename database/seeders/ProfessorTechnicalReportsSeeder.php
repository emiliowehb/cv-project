<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\MonthEnum;
use Faker\Factory as Faker;
use App\Models\Professor;
use App\Models\Publisher;
use App\Models\WorkClassification;
use App\Models\ResearchArea;
use App\Models\PublicationStatus;
use App\Models\IntellectualContribution;

class ProfessorTechnicalReportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('en_US');
        for ($i = 1; $i <= 15; $i++) {
            $technicalReport = [
                'professor_id' => 3,
                'year' => rand(2000, 2025),
                'month' => MonthEnum::values()[array_rand(MonthEnum::values())],
                'publisher_id' => Publisher::inRandomOrder()->first()->id,
                'identifying_number' => 'PB-' . $faker->numberBetween(4875, 637498),
                'volume' => 'Volume ' . rand(1, 5),
                'nb_pages' => rand(100, 500),
                'work_classification_id' => WorkClassification::inRandomOrder()->first()->id,
                'research_area_id' => ResearchArea::inRandomOrder()->first()->id,
                'notes' => $faker->sentence(1),
                'publication_status_id' => PublicationStatus::inRandomOrder()->first()->id,
                'intellectual_contribution_id' => IntellectualContribution::inRandomOrder()->first()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            DB::table('professor_technical_reports')->insert($technicalReport);
        }
    }
}
