<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            $faker = Faker::create();
    
            foreach (range(1, 30) as $index) {
                $randomDateTime = Carbon::now()->subDays(90)->addSeconds(rand(0, 330 * 24 * 3600));
                DB::table('lessons')->insert([
                    'course_id' => $faker->numberBetween(1, 5), 
                    'instructor_id' => $faker->numberBetween(2, 6), 
                    'user_id' => $faker->numberBetween(2, 6),
                    'module_id' => $faker->numberBetween(1, 15),
                    'title' => $faker->sentence,
                    'slug' => $faker->slug,
                    'video_link' => '',
                    'short_description' => $faker->paragraph,
                    'status' => $faker->randomElement(['pending', 'published']),
                    'type' => $faker->randomElement(['video']),
                    'created_at' => $randomDateTime,
                    'updated_at' => Carbon::now(),
                ]);
            }
    }
}
