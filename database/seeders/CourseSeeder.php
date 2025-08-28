<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            $faker = Faker::create();
    
            foreach (range(1, 10) as $index) {
                $randomDateTime = Carbon::now()->subDays(180)->addSeconds(rand(0, 330 * 24 * 3600));
                DB::table('courses')->insert([
                    'title' => $faker->sentence,
                    'auto_complete' => $faker->boolean,
                    'user_id' => $faker->numberBetween(2, 6), // Replace with your user ID range
                    'slug' => $faker->slug,
                    'price' => $faker->randomFloat(2, 20, 100),
                    'offer_price' => $faker->randomFloat(2, 15, 50),
                    'categories' => $faker->words(2, true),
                    'thumbnail' => 'thumbnail'.$index.'.png',
                    'short_description' => $faker->paragraph,
                    'description' => $faker->paragraphs(3, true),
                    'meta_keyword' => $faker->words(3, true),
                    'meta_description' => $faker->sentence,
                    'hascertificate' => $faker->boolean,
                    'sample_certificates' => 'certificate'.$faker->numberBetween(1, 5).'.png',
                    'status' => $faker->randomElement(['draft', 'published']),
                    'allow_review' => $faker->boolean,
                    'language' => $faker->languageCode,
                    'platform' => $faker->word,
                    'objective' => $faker->paragraph,
                    'curriculum' => 'curriculum' . $faker->randomNumber(3),
                    'objective_details' => $faker->paragraph,
                    'created_at' => $randomDateTime,
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
