<?php

namespace Database\Seeders;

use App\Models\ArticleType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $types = [
            'Case',
            'Magazine',
            'Newsletter',
            'Newspaper',
        ];

        foreach ($types as $type) {
            ArticleType::create([
                'name' => $type,
            ]);
        }
    }
}
