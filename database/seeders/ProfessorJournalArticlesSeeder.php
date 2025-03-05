<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\ArticleStatusEnum;
use App\Enums\MonthEnum;
use App\Models\Reviewable;
use Faker\Factory as Faker;
use App\Models\JournalArticleType;
use App\Models\Professor;
use App\Models\PublicationStatus;
use App\Models\PublicationPrimaryField;
use App\Models\PublicationSecondaryField;

class ProfessorJournalArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('en_US');
        for ($i = 1; $i <= 15; $i++) {
            $article = [
                'year' => rand(2000, 2025),
                'month' => MonthEnum::values()[array_rand(MonthEnum::values())],
                'journal_article_type_id' => JournalArticleType::inRandomOrder()->first()->id,
                'publication_status_id' => PublicationStatus::inRandomOrder()->first()->id,
                'professor_id' => 3,
                'title' => $faker->streetName(),
                'volume' => 'Volume ' . rand(1, 5),
                'issue' => 'Issue ' . rand(1, 5),
                'pages' => rand(1, 100),
                'notes' => $faker->paragraph(),
                'primary_field_id' => PublicationPrimaryField::inRandomOrder()->first()->id,
                'secondary_field_id' => PublicationSecondaryField::inRandomOrder()->first()->id,
                'admin_status' => ArticleStatusEnum::VALIDATED,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $articleId = DB::table('professor_journal_articles')->insertGetId($article);

            $review = new Reviewable([
                'reviewable_type' => 'App\Models\ProfessorJournalArticle',
                'status' => ArticleStatusEnum::VALIDATED,
                'type_id' => null,
                'reviewable_id' => $articleId,
                'reason' => null,
            ]);

            $review->save();
        }
    }
}
