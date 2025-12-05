<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reviews = [
            [
                'reviewer_name' => 'রাহাত খান',
                'reviewer_designation' => 'গ্রাফিক ডিজাইনার',
                'review_text' => 'আগে একটা পোস্টার বানাতে ঘন্টার পর ঘন্টা লাগত। এখন এআই প্রম্পট দিয়ে মিনিটেই ভিজ্যুয়াল তৈরি করতে পারি। কাজের মান বেড়েছে আর ক্লায়েন্টও অনেক বেশি খুশি।',
                'reviewer_avatar' => 'images/avatar.webp',
                'rating' => 5,
                'display_order' => 1,
                'is_active' => true,
            ],
            [
                'reviewer_name' => 'নয়ন খান',
                'reviewer_designation' => 'গ্রাফিক ডিজাইনার',
                'review_text' => 'এআই শেখার পর ভিডিও বানানো অনেক সহজ হয়েছে। টেক্সট থেকে ভিডিও, লিপ-সিঙ্ক আর ইফেক্ট কয়েক মিনিটেই করা যায়। এখন আগের চেয়ে দ্বিগুণ প্রজেক্ট ডেলিভার করছি। এআই শেখার পর ভিডিও বানানো অনেক সহজ হয়েছে। টেক্সট থেকে ভিডিও, লিপ-সিঙ্ক',
                'reviewer_avatar' => 'images/avatar.webp',
                'rating' => 5,
                'display_order' => 2,
                'is_active' => true,
            ],
            [
                'reviewer_name' => 'সাইফুল ইসলাম',
                'reviewer_designation' => 'গ্রাফিক ডিজাইনার',
                'review_text' => 'আমি মূলত একজন শিক্ষার্থী, কিন্তু সবসময় কিছু ক্রিয়েটিভ স্কিল শিখতে চেয়েছি যা ভবিষ্যতে কাজে লাগবে। এআই বুটক্যাম্পে যোগ দিয়ে শিখলাম ইমেজ, ভিডিও আর মিউজিক জেনারেশন – সবকিছু একসাথে। কোর্স শেষে ছোট ছোট ফ্রিল্যান্স প্রজেক্ট নেওয়া শুরু করেছি, আর এআই টুলস দিয়ে দ্রুত কাজ শেষ করতে পারছি। এটা শুধু শেখা নয়, ভবিষ্যতের জন্য এক অসাধারণ ইনভেস্টমেন্ট মনে হচ্ছে। আমি বিশ্বাস করি এই স্কিল আমাকে ক্যারিয়ারে অনেক দূর এগিয়ে দেবে।',
                'reviewer_avatar' => 'images/avatar.webp',
                'rating' => 5,
                'display_order' => 3,
                'is_active' => true,
            ],
            [
                'reviewer_name' => 'তুহিন',
                'reviewer_designation' => 'গ্রাফিক ডিজাইনার',
                'review_text' => 'আগে একটা পোস্টার বানাতে ঘন্টার পর ঘন্টা লাগত। এখন এআই প্রম্পট দিয়ে মিনিটেই ভিজ্যুয়াল তৈরি করতে পারি। কাজের মান বেড়েছে আর ক্লায়েন্টও অনেক বেশি খুশি। এআই শেখার পর ভিডিও বানানো অনেক সহজ হয়েছে। টেক্সট থেকে ভিডিও, লিপ-সিঙ্ক আর ইফেক্ট কয়েক মিনিটেই করা যায়। এখন আগের চেয়ে দ্বিগুণ প্রজেক্ট ডেলিভার করছি।',
                'reviewer_avatar' => 'images/avatar.webp',
                'rating' => 5,
                'display_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($reviews as $review) {
            \App\Models\Review::create($review);
        }
    }
}
