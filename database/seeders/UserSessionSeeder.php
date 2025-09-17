<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class UserSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get user IDs
        $userIds = DB::table('users')->pluck('id')->toArray();

        if (empty($userIds)) {
            return; // No users found
        }

        // Create sample user sessions
        foreach ($userIds as $userId) {
            // Create 1-3 sessions per user
            for ($i = 0; $i < rand(1, 3); $i++) {
                $sessionId = $faker->uuid;
                $isCurrent = $i === 0; // First session is current

                DB::table('user_sessions')->insert([
                    'user_id' => $userId,
                    'session_id' => $sessionId,
                    'device_name' => $faker->randomElement([
                        'iPhone 14 Pro',
                        'Samsung Galaxy S23',
                        'MacBook Pro',
                        'Windows PC',
                        'iPad Air',
                        'Android Tablet'
                    ]),
                    'device_type' => $faker->randomElement(['mobile', 'desktop', 'tablet']),
                    'browser' => $faker->randomElement([
                        'Chrome',
                        'Firefox',
                        'Safari',
                        'Edge',
                        'Opera'
                    ]),
                    'os' => $faker->randomElement([
                        'iOS 17.0',
                        'Android 14',
                        'macOS Sonoma',
                        'Windows 11',
                        'Linux Ubuntu'
                    ]),
                    'ip_address' => $faker->ipv4,
                    'country' => $faker->randomElement([
                        'Bangladesh',
                        'India',
                        'Pakistan',
                        'Nepal',
                        'Sri Lanka'
                    ]),
                    'city' => $faker->city,
                    'latitude' => $faker->latitude(20, 26),
                    'longitude' => $faker->longitude(88, 93),
                    'user_agent' => $faker->userAgent,
                    'last_activity' => Carbon::now()->subMinutes(rand(0, 1440)),
                    'is_current' => $isCurrent,
                    'created_at' => Carbon::now()->subDays(rand(0, 30)),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}