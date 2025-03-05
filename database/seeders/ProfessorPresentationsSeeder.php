<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\MonthEnum;
use Faker\Factory as Faker;
use App\Models\Professor;
use App\Models\Country;
use App\Models\IntellectualContribution;

class ProfessorPresentationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('en_US');
        for ($i = 1; $i <= 15; $i++) {
            $presentation = [
                'name' => $faker->streetName(),
                'year' => rand(2000, 2025),
                'month' => MonthEnum::values()[array_rand(MonthEnum::values())],
                'days' => $faker->numberBetween(1, 31),
                'event_name' => $faker->state .' ' . $faker->city . ' Conference',
                'professor_id' => 3,
                'country_id' => Country::inRandomOrder()->first()->id,
                'town' => $faker->city,
                'is_published_in_proceedings' => $faker->boolean,
                'intellectual_contribution_id' => IntellectualContribution::inRandomOrder()->first()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            DB::table('professor_presentations')->insert($presentation);
        }
    }
}
