<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class SubscriptionPlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Define realistic subscription packages
        $packages = [
            [
                'name' => 'Starter Plan',
                'slug' => 'starter-plan',
                'regular_price' => 29.99,
                'sales_price' => 19.99,
                'features' => 'Up to 5 courses,Basic analytics,Email support,Standard templates',
                'type' => 'monthly',
                'status' => 'active',
                'created_by' => 1,
            ],
            [
                'name' => 'Professional Plan',
                'slug' => 'professional-plan',
                'regular_price' => 79.99,
                'sales_price' => 59.99,
                'features' => 'Up to 20 courses,Advanced analytics,Priority support,Custom templates,API access',
                'type' => 'monthly',
                'status' => 'active',
                'created_by' => 1,
            ],
            [
                'name' => 'Enterprise Plan',
                'slug' => 'enterprise-plan',
                'regular_price' => 199.99,
                'sales_price' => 149.99,
                'features' => 'Unlimited courses,Enterprise analytics,24/7 support,Custom branding,White-label options,Advanced integrations',
                'type' => 'monthly',
                'status' => 'active',
                'created_by' => 1,
            ],
            [
                'name' => 'Starter Plan - Yearly',
                'slug' => 'starter-plan-yearly',
                'regular_price' => 299.99,
                'sales_price' => 199.99,
                'features' => 'Up to 5 courses,Basic analytics,Email support,Standard templates,2 months free',
                'type' => 'yearly',
                'status' => 'active',
                'created_by' => 1,
            ],
            [
                'name' => 'Professional Plan - Yearly',
                'slug' => 'professional-plan-yearly',
                'regular_price' => 799.99,
                'sales_price' => 599.99,
                'features' => 'Up to 20 courses,Advanced analytics,Priority support,Custom templates,API access,2 months free',
                'type' => 'yearly',
                'status' => 'active',
                'created_by' => 1,
            ],
            [
                'name' => 'Enterprise Plan - Yearly',
                'slug' => 'enterprise-plan-yearly',
                'regular_price' => 1999.99,
                'sales_price' => 1499.99,
                'features' => 'Unlimited courses,Enterprise analytics,24/7 support,Custom branding,White-label options,Advanced integrations,2 months free',
                'type' => 'yearly',
                'status' => 'active',
                'created_by' => 1,
            ],
        ];

        foreach ($packages as $package) {
            $randomDateTime = Carbon::now()->subDays(30)->addSeconds(rand(0, 30 * 24 * 3600));
            
            DB::table('subscription_packages')->insert([
                'name' => $package['name'],
                'slug' => $package['slug'],
                'regular_price' => $package['regular_price'],
                'sales_price' => $package['sales_price'],
                'features' => $package['features'],
                'type' => $package['type'],
                'status' => $package['status'],
                'created_by' => $package['created_by'],
                'created_at' => $randomDateTime,
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}