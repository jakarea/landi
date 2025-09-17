<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class LiveClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get instructor and course IDs
        $instructors = DB::table('users')->where('user_role', 'instructor')->get();
        $courses = DB::table('courses')->get();

        if ($instructors->isEmpty()) {
            return; // No instructors found
        }

        // Create sample live classes
        foreach ($instructors->take(3) as $instructor) {
            // Create 2-3 live classes per instructor
            for ($i = 0; $i < rand(2, 3); $i++) {
                $course = $courses->random();

                DB::table('live_classes')->insert([
                    'title' => $faker->catchPhrase . ' - Live Session',
                    'description' => $faker->paragraph,
                    'instructor_id' => $instructor->id,
                    'course_id' => $course->id,
                    'course_name' => $course->title,
                    'start_time' => Carbon::now()->addDays(rand(1, 30))->addHours(rand(9, 17)),
                    'duration_minutes' => $faker->randomElement([60, 90, 120]),
                    'zoom_meeting_id' => $faker->numerify('###########'),
                    'zoom_start_url' => 'https://zoom.us/s/' . $faker->numerify('###########'),
                    'zoom_join_url' => 'https://zoom.us/j/' . $faker->numerify('###########'),
                    'zoom_password' => $faker->password(6, 8),
                    'status' => $faker->randomElement(['scheduled', 'live', 'ended']),
                    'zoom_response' => json_encode([
                        'id' => $faker->numerify('###########'),
                        'topic' => $faker->catchPhrase,
                        'type' => 2,
                        'timezone' => 'Asia/Dhaka'
                    ]),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}