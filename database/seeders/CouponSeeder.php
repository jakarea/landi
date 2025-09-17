<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get instructor IDs
        $instructorIds = DB::table('users')->where('user_role', 'instructor')->pluck('id')->toArray();

        if (empty($instructorIds)) {
            return; // No instructors found
        }

        // Create some sample coupons
        $coupons = [
            [
                'code' => 'WELCOME10',
                'name' => 'Welcome Discount',
                'description' => 'Welcome discount for new students',
                'type' => 'percentage',
                'value' => 10.00,
                'instructor_id' => $instructorIds[0],
                'applicable_courses' => null,
                'usage_limit' => 100,
                'used_count' => 5,
                'valid_from' => Carbon::now(),
                'valid_until' => Carbon::now()->addMonths(6),
                'is_active' => true,
            ],
            [
                'code' => 'SAVE50',
                'name' => 'Fixed Amount Discount',
                'description' => 'Save 50 taka on any course',
                'type' => 'fixed',
                'value' => 50.00,
                'instructor_id' => $instructorIds[0],
                'applicable_courses' => null,
                'usage_limit' => 50,
                'used_count' => 0,
                'valid_from' => Carbon::now(),
                'valid_until' => Carbon::now()->addMonths(3),
                'is_active' => true,
            ],
        ];

        foreach ($coupons as $coupon) {
            DB::table('coupons')->insert(array_merge($coupon, [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]));
        }

        // Create random coupons for other instructors
        foreach ($instructorIds as $instructorId) {
            if ($instructorId == $instructorIds[0]) continue; // Skip first instructor

            DB::table('coupons')->insert([
                'code' => strtoupper($faker->word . $faker->numberBetween(10, 99)),
                'name' => $faker->words(2, true) . ' Discount',
                'description' => $faker->sentence,
                'type' => $faker->randomElement(['percentage', 'fixed']),
                'value' => $faker->randomFloat(2, 5, 100),
                'instructor_id' => $instructorId,
                'applicable_courses' => null,
                'usage_limit' => $faker->numberBetween(10, 100),
                'used_count' => 0,
                'valid_from' => Carbon::now(),
                'valid_until' => Carbon::now()->addMonths($faker->numberBetween(1, 12)),
                'is_active' => $faker->boolean(80),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}