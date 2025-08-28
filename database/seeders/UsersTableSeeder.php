<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $randomDateTime = Carbon::now()->subDays(330)->addSeconds(rand(0, 330 * 24 * 3600));
        $links = "https://facebook.com/".$faker->userName.",https://twitter.com/".$faker->userName.",https://instagram.com/".$faker->userName;
        
        // Create admin user
        DB::table('users')->insert([
            'name' => 'Mr Admin',
            'email' => 'admin1@yopmail.com',
            'user_role' => 'admin',
            'company_name' => $faker->company,
            'short_bio' => $faker->sentence,
            'phone' => $faker->phoneNumber,
            'avatar' => 'assets/images/avatar.png',
            'description' => $faker->paragraph,
            'recivingMessage' => 1,
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt(1234567890),
            'stripe_secret_key' => null,
            'stripe_public_key' => null,
            'status' => 'active',
            'created_at' => $randomDateTime,
            'updated_at' => Carbon::now(),
        ]);

        // Create instructor users
        foreach (range(1, 5) as $index) {
            $randomDateTime = Carbon::now()->subDays(330)->addSeconds(rand(0, 330 * 24 * 3600));
            $email = 'instructor'.$index.'@yopmail.com';

            $links = "https://facebook.com/".$faker->userName.",https://twitter.com/".$faker->userName.",https://instagram.com/".$faker->userName;
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $email,
                'user_role' => 'instructor',
                'company_name' => $faker->company,
                'short_bio' => $faker->sentence,
                'phone' => $faker->phoneNumber,
                'description' => $faker->paragraph,
                'recivingMessage' => 1,
                'avatar' => 'uploads/users/'.$faker->numberBetween(1, 20).'.jpeg',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt(1234567890),
                'status' => 'active',
                'created_at' => $randomDateTime,
                'updated_at' => Carbon::now(),
            ]);
        }

        // Create student users
        foreach (range(1, 10) as $index) {
            $randomDateTime = Carbon::now()->subDays(330)->addSeconds(rand(0, 330 * 24 * 3600));
            $email = 'student'.$index.'@yopmail.com';

            $links = "https://facebook.com/".$faker->userName.",https://twitter.com/".$faker->userName.",https://instagram.com/".$faker->userName;
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $email,
                'user_role' => 'student',
                'company_name' => $faker->company,
                'short_bio' => $faker->sentence,
                'phone' => $faker->phoneNumber,
                'description' => $faker->paragraph,
                'recivingMessage' => 1,
                'avatar' => 'uploads/users/'.$faker->numberBetween(1, 20).'.jpeg',
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt(1234567890),
                'status' => 'active',
                'social_links' => $links,
                'created_at' => $randomDateTime,
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
