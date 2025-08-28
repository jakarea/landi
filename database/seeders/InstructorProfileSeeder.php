<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class InstructorProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(15, 20) as $index) {
                $randomDateTime = Carbon::now()->subDays(330)->addSeconds(rand(0, 330 * 24 * 3600));
                $subdomain = $faker->userName;
                $email = 'instructor'.$index.'@yopmail.com';
                $links = "https://facebook.com/".$faker->userName.",https://twitter.com/".$faker->userName.",https://instagram.com/".$faker->userName;
                
                $instructorId = DB::table('users')->insertGetId([
                    'name' => $faker->name,
                    'email' => $email,
                    // 'subdomain' => 'instructor'.$index, // Removed - no subdomain system
                    'user_role' => 'instructor', // Default user role
                    'company_name' => $faker->company,
                    'short_bio' => $faker->sentence,
                    'phone' => $faker->phoneNumber,
                    'description' => $faker->paragraph,
                    'recivingMessage' => 1,
                    'avatar' => 'uploads/users/'.$faker->numberBetween(1, 25).'.jpeg',
                    'email_verified_at' => Carbon::now(),
                    'password' => bcrypt(1234567890), // You can set a default password
                    'status' => 'active', // Default user status
                    'social_links' => $links,
                    // Stripe keys removed - no payment system
                    'updated_at' => $randomDateTime,
                    'created_at' => $randomDateTime,
                ]);
                
                DB::table('vimeo_data')->insert([
                    'client_id' => '9b9327a8ad7087c1026d89a0e44dc86dee9fa385',
                    'client_secret' => 'VuARaezQdBxBpxeFs4esXAvX8EEZ/FzTcAxVnxsUzb92QY8UVJNhXFpZaFcxwAntc6BrkcKTrXhQsLZpCouhvWQWTf3JQT2DW6FWtd8RvSTTwUj/GtixFoczkr4N81j7',
                    'access_key' => '4324498bedca1cbf865b359196f066a0',
                    'user_id' => $instructorId
                ]);

                // Subscription creation removed - no payment system

                DB::table('instructor_module_settings')->insert([
                    'instructor_id' => $instructorId,
                    'value' => '{"primary_color":"#ffffff","secondary_color":"#000000","lp_layout":"","meta_title":null,"meta_desc":null}',
                    'created_at' => $randomDateTime,
                    'updated_at' => $randomDateTime,
                ]);
                foreach (range(122, 125) as $index) {
                    $randomDateTime = Carbon::now()->subDays(330)->addSeconds(rand(0, 330 * 24 * 3600));
                    $randomDateFutureTime = Carbon::now()->addDays(30)->addSeconds(rand(0, 330 * 24 * 3600));
                
                    $email = 'student'.mt_rand(0, 330 * 24 * 3600).'@yopmail.com';
                    $links = "https://facebook.com/".$faker->userName.",https://twitter.com/".$faker->userName.",https://instagram.com/".$faker->userName;
                    $studentId = DB::table('users')->insertGetId([
                        'name' => $faker->name,
                        'email' => $email,
                        'user_role' => 'student',
                        'short_bio' => $faker->sentence,
                        'phone' => $faker->phoneNumber,
                        'description' => $faker->paragraph,
                        'recivingMessage' => 1,
                        'avatar' => 'uploads/users/'.$faker->numberBetween(1, 25).'.jpeg',
                        'email_verified_at' => Carbon::now(),
                        'password' => bcrypt(1234567890), // You can set a default password
                        'status' => 'active', // Default user status
                        'social_links' => $links,
                        'updated_at' => $randomDateTime,
                        'created_at' => $randomDateTime,
                    ]);
                   

                   

                } //student loop
                foreach (range(20, 23) as $index) {
                    $randomDateTime = Carbon::now()->subDays(330)->addSeconds(rand(0, 330 * 24 * 3600));
                    $courseId = DB::table('courses')->insertGetId([
                        'title' => $faker->sentence,
                        'auto_complete' => $faker->boolean,
                        'user_id' => $instructorId, // Replace with your user ID range
                        'slug' => $faker->slug,
                        'price' => $faker->randomFloat(2, 20, 100),
                        'offer_price' => $faker->randomFloat(2, 10, 50),
                        'categories' => $faker->words(2, true),
                        'thumbnail' => 'assets/images/courses/thumbnail'.$faker->numberBetween(1, 15).'.png',
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
                        'updated_at' => $randomDateTime,
                    ]);

                    foreach (range(1, $faker->numberBetween(1, 4)) as $index) {
                        $randomDateTime = Carbon::now()->subDays(330)->addSeconds(rand(0, 330 * 24 * 3600));
                        $moduleId = DB::table('modules')->insertGetId([
                            'course_id' => $courseId, 
                            'instructor_id' => $instructorId, 
                            'user_id' => $instructorId,
                            'title' => $faker->sentence,
                            'slug' => $faker->slug,
                            'status' => $faker->randomElement(['draft', 'published']),
                            'created_at' => $randomDateTime,
                            'updated_at' => $randomDateTime,
                        ]);

                        foreach (range(1, $faker->numberBetween(1, 5)) as $index) {
                            $randomDateTime = Carbon::now()->subDays(300)->addSeconds(rand(0, 330 * 24 * 3600));
                            $lessonId = DB::table('lessons')->insertGetId([
                                'course_id' => $courseId, 
                                'instructor_id' => $instructorId, 
                                'user_id' => $instructorId,
                                'module_id' => $moduleId,
                                'title' => $faker->sentence,
                                'slug' => $faker->slug,
                                'duration' => $faker->randomNumber(3),
                                'video_link' => $faker->randomElement(['/videos/870001793', '/videos/870001728']),
                                'short_description' => $faker->paragraph,
                                'status' => $faker->randomElement(['pending', 'published']),
                                'type' => $faker->randomElement(['video', 'text','audio']),
                                'created_at' => $randomDateTime,
                                'updated_at' => $randomDateTime,
                            ]);

                            if($faker->boolean){
                                DB::table('course_activities')->insert([
                                    'course_id' => $courseId,
                                    'user_id' => $studentId,
                                    'instructor_id' => $instructorId,
                                    'module_id' => $moduleId,
                                    'lesson_id' => $lessonId,
                                    'is_completed' => $faker->boolean,
                                    'duration' => $faker->randomNumber(3),
                                    'created_at' => $randomDateTime,
                                ]);
                            }
                            
                        } // End lesson loop

                    } // End of Module loop

                   

                }// end of course loop
                $amount = $faker->randomNumber(3);
                DB::table('course_user')->insert([
                    'course_id' => $courseId,
                    'user_id' => $studentId,
                    'instructor_id' => $instructorId,
                    'payment_method' => 'Stripe',
                    'amount' => $amount,
                    'paid' => 1,
                    'start_at' => $randomDateTime,
                    'end_at' => $randomDateFutureTime,
                    'created_at' => $randomDateTime,
                ]);

                DB::table('checkouts')->insert([
                    'course_id' => $courseId,
                    'user_id' => $studentId,
                    'instructor_id' => $instructorId,
                    'payment_method' => 'Stripe',
                    'payment_status' => 'Paid',
                    'payment_id' => $faker->randomElement(['pm_1NwMGBAElm5ocjhNazmVuPjL', 'pi_3NwMGCAElm5ocjhN1shnLduR','pi_3LxXaBAElm5ocjhN11BKMRFf']),
                    'status' => 'completed',
                    'amount' => $amount,
                    'start_date' => $randomDateTime,
                    'end_date' => $randomDateFutureTime,
                    'created_at' => $randomDateTime,
                ]);

            } // end of user loop
    }
}
