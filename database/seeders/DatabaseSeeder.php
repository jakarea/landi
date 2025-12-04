<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call seeders in order to maintain data integrity and foreign key constraints
        $this->call([
            // 1. Core user data first (required for foreign keys)
            UsersTableSeeder::class,

            // 2. Course-related data (depends on users)
            CourseSeeder::class,
            ModuleSeeder::class,
            LessonSeeder::class,

            // 3. Subscription and payment related
            // SubscriptionPlansTableSeeder::class,
            // SubscriptionsTableSeeder::class,

            // 4. Course interaction data (depends on courses and users)
            // CourseActivitiesTableSeeder::class,
            // CourseLikesTableSeeder::class,
            // CourseLogsTableSeeder::class,

            // 5. Coupon and discount system
            // CouponSeeder::class,

            // 6. Live classes (depends on users and courses)
            // LiveClassSeeder::class,

            // 7. User sessions (depends on users)
            // UserSessionSeeder::class,

            // 8. Profile and content data
            // InstructorProfileSeeder::class,
            // StudentProfileSeeder::class,
            // BanglaContentSeeder::class,

            // 9. Common/configuration data (should be last)
            // CommonDataSeeder::class,
        ]);
    }
}