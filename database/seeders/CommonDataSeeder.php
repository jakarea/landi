<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class CommonDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        
        // Create vimeo data for instructors
        foreach (range(1, 10) as $index) {
            $randomDateTime = Carbon::now()->subDays(230)->addSeconds(rand(0, 330 * 24 * 3600));
            
            DB::table('vimeo_data')->insert([
                'client_id' => '9b9327a8ad7087c1026d89a0e44dc86dee9fa385',
                'client_secret' => 'VuARaezQdBxBpxeFs4esXAvX8EEZ/FzTcAxVnxsUzb92QY8UVJNhXFpZaFcxwAntc6BrkcKTrXhQsLZpCouhvWQWTf3JQT2DW6FWtd8RvSTTwUj/GtixFoczkr4N81j7',
                'access_key' => '4324498bedca1cbf865b359196f066a0',
                'user_id' => $faker->numberBetween(2, 6)
            ]);
        }

        // Create course enrollments
        foreach (range(1, 15) as $index) {
            $randomDateTime = Carbon::now()->subDays(230)->addSeconds(rand(0, 330 * 24 * 3600));
            $randomDateFutureTime = Carbon::now()->addDays(30)->addSeconds(rand(0, 330 * 24 * 3600));
            
            $amount = $faker->randomNumber(3);
            DB::table('course_user')->insert([
                'course_id' => $faker->numberBetween(1, 10),
                'user_id' =>  $faker->numberBetween(7, 15),
                'instructor_id' =>  $faker->numberBetween(2, 6),
                'payment_method' => 'Stripe',
                'amount' => $amount,
                'paid' => 1,
                'start_at' => $randomDateTime,
                'end_at' => $randomDateFutureTime,
                'created_at' => $randomDateTime,
            ]);

            DB::table('checkouts')->insert([
                'course_id' =>$faker->numberBetween(1, 10),
                'user_id' => $faker->numberBetween(7, 15),
                'instructor_id' => $faker->numberBetween(2, 6),
                'payment_method' => 'Stripe',
                'payment_status' => 'Paid',
                'payment_id' => $faker->randomElement(['pm_1NwMGBAElm5ocjhNazmVuPjL', 'pi_3NwMGCAElm5ocjhN1shnLduR','pi_3LxXaBAElm5ocjhN11BKMRFf']),
                'status' => 'completed',
                'amount' => $amount,
                'start_date' => $randomDateTime,
                'end_date' => $randomDateFutureTime,
                'created_at' => $randomDateTime,
            ]);
        }
    }
}
