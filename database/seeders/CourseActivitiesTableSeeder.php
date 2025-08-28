<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class CourseActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1, 100) as $index) {
            $randomDateTime = Carbon::now()->subDays(130)->addSeconds(rand(0, 330 * 24 * 3600));
                DB::table('course_activities')->insert([
                    'course_id' => $faker->numberBetween(1, 10), 
                    'instructor_id' => $faker->numberBetween(2, 6),
                    'module_id' => $faker->numberBetween(1, 20),
                    'lesson_id' => $faker->numberBetween(1, 30),
                    'user_id' => $faker->numberBetween(7, 15),
                    'is_completed' => $faker->boolean,
                    'created_at' => $randomDateTime,
                    'updated_at' => Carbon::now(),
                ]);
            }
    }
}
