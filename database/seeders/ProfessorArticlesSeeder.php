<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\ArticleStatusEnum;
use Faker\Factory as Faker;
use App\Models\ArticleType;
use App\Models\Professor;
use App\Models\Publisher;
use App\Models\Reviewable;

class ProfessorArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('en_US');
        for ($i = 1; $i <= 30; $i++) {
            $article_type_id = ArticleType::inRandomOrder()->first()->id;
            $article = [
                'professor_id' => 3,
                'article_type_id' => $article_type_id,
                'title' => $faker->streetName(),
                'publisher_name' => Publisher::inRandomOrder()->first()->name,
                'year' => rand(2000, 2025),
                'nb_pages' => rand(1, 100),
                'admin_status' => ArticleStatusEnum::VALIDATED,
                'url' => $faker->url(),
                'notes' => $faker->sentence(),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $articleId = DB::table('professor_articles')->insertGetId($article);

            $review = new Reviewable([
                'reviewable_type' => 'App\Models\ProfessorArticle',
                'status' => ArticleStatusEnum::VALIDATED,
                'type_id' => $article_type_id,
                'reviewable_id' => $articleId,
                'reason' => null,
            ]);

            $review->save();
        }
    }
}
