<?php

namespace Database\Seeders;

use App\Enums\MonthEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\Professor;
use App\Models\ReviewedMedium;
use App\Models\IntellectualContribution;

class ProfessorBookReviewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public $randomMediums = [
        'Neuroscientific',
        'Psychological',
        'Philosophical',
        'Sociological',
        'Economic',
        'Political',
        'Historical',
        'Biological',
        'Medical',
    ];

    public function run(): void
    {
        $faker = Faker::create('en_US');
        for ($i = 1; $i <= 15; $i++) {
            $bookReview = [
                'professor_id' => 3,
                'reviewed_medium_id' => ReviewedMedium::inRandomOrder()->first()->id,
                'year' => rand(2000, 2025),
                'month' => MonthEnum::values()[array_rand(MonthEnum::values())],
                'name' => $this->randomMediums[rand(0, count($this->randomMediums) - 1)] . ' ' . $faker->streetName(),
                'periodical_title' => $faker->streetName(),
                'reviewed_work_authors' => $faker->firstName() . ' ' . $faker->lastName(),
                'notes' => $faker->sentence(),
                'intellectual_contribution_id' => IntellectualContribution::inRandomOrder()->first()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            DB::table('professor_book_reviews')->insert($bookReview);
        }
    }
}
