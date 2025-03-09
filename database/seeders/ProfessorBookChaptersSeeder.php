<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\ArticleStatusEnum;
use App\Enums\MonthEnum;
use App\Models\Reviewable;
use Faker\Factory as Faker;
use App\Models\BookType;
use App\Models\Professor;
use App\Models\WorkClassification;
use App\Models\ResearchArea;
use App\Models\Publisher;
use App\Models\IntellectualContribution;
use App\Models\PublicationStatus;

class ProfessorBookChaptersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('en_US');
        for ($i = 1; $i <= 15; $i++) {
            $chapter = [
                'published_year' => rand(2000, 2025),
                'published_month' => MonthEnum::values()[array_rand(MonthEnum::values())],
                'book_type_id' => BookType::inRandomOrder()->first()->id,
                'professor_id' => 3,
                'work_classification_id' => WorkClassification::inRandomOrder()->first()->id,
                'publication_status_id' => PublicationStatus::inRandomOrder()->first()->id,
                'book_name' => $faker->streetName(),
                'author_name' => $faker->firstName() . ' ' . $faker->lastName(),
                'chapter_title' => $faker->streetName(),
                'volume' => 'Volume ' . rand(1, 5),
                'research_area_id' => ResearchArea::inRandomOrder()->first()->id,
                'nb_pages' => rand(100, 500),
                'publisher_id' => Publisher::inRandomOrder()->first()->id,
                'admin_status' => ArticleStatusEnum::VALIDATED,
                'notes' => $faker->paragraph(),
                'intellectual_contribution_id' => IntellectualContribution::inRandomOrder()->first()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $chapterId = DB::table('professor_book_chapters')->insertGetId($chapter);

            $review = new Reviewable([
                'reviewable_type' => 'App\Models\ProfessorBookChapter',
                'status' => ArticleStatusEnum::VALIDATED,
                'type_id' => null,
                'professor_id' => 3,
                'reviewable_id' => $chapterId,
                'reason' => null,
            ]);

            $review->save();
        }
    }
}
