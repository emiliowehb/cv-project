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
use App\Models\PublicationStatus;
use App\Models\Field;
use App\Models\PublicationPrimaryField;
use App\Models\PublicationSecondaryField;

class ProfessorBooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('en_US');
        for ($i = 1; $i <= 15; $i++) {
            $book = [
                'year' => rand(2000, 2025),
                'month' => MonthEnum::values()[array_rand(MonthEnum::values())],
                'book_type_id' => BookType::inRandomOrder()->first()->id,
                'professor_id' => 3,
                'work_classification_id' => WorkClassification::inRandomOrder()->first()->id,
                'name' => $faker->streetName(),
                'volume' => 'Volume ' . rand(1, 5),
                'research_area_id' => ResearchArea::inRandomOrder()->first()->id,
                'nb_pages' => rand(100, 500),
                'publisher_id' => Publisher::inRandomOrder()->first()->id,
                'publication_status_id' => PublicationStatus::inRandomOrder()->first()->id,
                'primary_field_id' => PublicationPrimaryField::inRandomOrder()->first()->id,
                'secondary_field_id' => PublicationSecondaryField::inRandomOrder()->first()->id,
                'admin_status' => ArticleStatusEnum::VALIDATED,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $bookId = DB::table('professor_books')->insertGetId($book);

            $review = new Reviewable([
                'reviewable_type' => 'App\Models\ProfessorBook',
                'status' => ArticleStatusEnum::VALIDATED,
                'type_id' => null,
                'professor_id' => 3,
                'reviewable_id' => $bookId,
                'reason' => null,
            ]);

            $review->save();
        }
    }
}
