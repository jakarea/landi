<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class SubscriptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Get existing subscription package IDs
        $packageIds = DB::table('subscription_packages')->pluck('id')->toArray();
        
        // Get existing instructor IDs (users with role 'instructor')
        $instructorIds = DB::table('users')->where('user_role', 'instructor')->pluck('id')->toArray();
        
        // If no instructors exist, create some dummy ones
        if (empty($instructorIds)) {
            $instructorIds = [2, 3, 4, 5, 6]; // Fallback IDs
        }
        
        // If no packages exist, create some dummy ones
        if (empty($packageIds)) {
            $packageIds = [1, 2, 3, 4, 5, 6]; // Fallback IDs
        }

        // Create realistic subscriptions
        foreach (range(1, 25) as $index) {
            $packageId = $faker->randomElement($packageIds);
            $instructorId = $faker->randomElement($instructorIds);
            
            // Get package details for realistic data
            $package = DB::table('subscription_packages')->where('id', $packageId)->first();
            
            if (!$package) {
                continue; // Skip if package doesn't exist
            }
            
            // Calculate realistic dates using Carbon
            $startDate = Carbon::now()->subMonths(rand(0, 6));
            $endDate = clone $startDate;
            
            // Add duration based on package type
            if ($package->type === 'monthly') {
                $endDate->addMonth();
            } else {
                $endDate->addYear();
            }
            
            // Add trial period for some subscriptions
            $trialEndsAt = null;
            if ($faker->boolean(30)) { // 30% chance of having trial
                $trialEndsAt = clone $startDate;
                $trialEndsAt->addDays(7);
            }
            
            // Determine status based on dates
            $now = Carbon::now();
            $status = 'active';
            if ($endDate->lt($now)) {
                $status = 'expired';
            } elseif ($startDate->gt($now)) {
                $status = 'pending';
            }
            
            // Use package pricing for amount - convert to integer (cents)
            $amount = $package->sales_price ?: $package->regular_price;
            $amountInCents = (int)($amount * 100); // Convert to cents for integer storage
            
            // Generate realistic Stripe plan IDs
            $stripePlanIds = [
                'pi_' . strtoupper($faker->regexify('[a-zA-Z0-9]{24}')),
                'pi_' . strtoupper($faker->regexify('[a-zA-Z0-9]{24}')),
                'pi_' . strtoupper($faker->regexify('[a-zA-Z0-9]{24}')),
                'pi_' . strtoupper($faker->regexify('[a-zA-Z0-9]{24}')),
                'pi_' . strtoupper($faker->regexify('[a-zA-Z0-9]{24}')),
            ];
            
            DB::table('subscriptions')->insert([
                'subscription_packages_id' => $packageId,
                'instructor_id' => $instructorId,
                'name' => $package->name,
                'stripe_plan' => $faker->randomElement($stripePlanIds),
                'amount' => $amountInCents,
                'quantity' => $faker->randomElement([1, 2, 3]), // Some instructors might have multiple seats
                'start_at' => $startDate,
                'end_at' => $endDate,
                'trial_ends_at' => $trialEndsAt,
                'status' => $status,
                'created_at' => $startDate,
                'updated_at' => Carbon::now(),
            ]);
        }
        
        // Create some expired subscriptions for historical data
        foreach (range(1, 10) as $index) {
            $packageId = $faker->randomElement($packageIds);
            $instructorId = $faker->randomElement($instructorIds);
            
            $package = DB::table('subscription_packages')->where('id', $packageId)->first();
            if (!$package) continue;
            
            $startDate = Carbon::now()->subMonths(rand(6, 12));
            $endDate = clone $startDate;
            
            if ($package->type === 'monthly') {
                $endDate->addMonth();
            } else {
                $endDate->addYear();
            }
            
            // Convert amount to cents
            $amount = $package->sales_price ?: $package->regular_price;
            $amountInCents = (int)($amount * 100);
            
            DB::table('subscriptions')->insert([
                'subscription_packages_id' => $packageId,
                'instructor_id' => $instructorId,
                'name' => $package->name,
                'stripe_plan' => 'pi_' . strtoupper($faker->regexify('[a-zA-Z0-9]{24}')),
                'amount' => $amountInCents,
                'quantity' => 1,
                'start_at' => $startDate,
                'end_at' => $endDate,
                'trial_ends_at' => null,
                'status' => 'expired',
                'created_at' => $startDate,
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
