<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageLevelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a seeder for LanguageLevel using this array
        $levels = [['id' => '1', 'name' => 'Beginner'],
        ['id' => '2', 'name' => 'Working Knowledge'],
        ['id' => '3', 'name' => 'Intermediate'],
        ['id' => '4', 'name' => 'Fluent'],
        ['id' => '5', 'name' => 'N/A'],
    ];
        foreach ($levels as $level) {
            \App\Models\LanguageLevel::create($level);
        };

    }
}
