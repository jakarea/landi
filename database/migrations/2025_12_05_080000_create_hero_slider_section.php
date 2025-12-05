<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\PageSection;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create hero_slider section with initial data from current static slider
        PageSection::create([
            'pageName' => 'home',
            'sectionName' => 'hero_slider',
            'sectionImage' => 'images/home/hero-1.png',
            'is_active' => true,
            'content' => [
                'slides' => [
                    [
                        'title' => 'সঠিক সময়ে, সুবর্ণ সুযোগে - <span class="text-gradient">স্কিল ডেভেলপ হবে যেকোনো জায়গা থেকে।</span>',
                        'description' => 'পিসি বা ল্যাপটপে, ঘরে কিংবা বাইরে - স্মার্ট লার্নিং একটি প্ল্যাটফর্মে।',
                        'cta_text' => 'কোর্সগুলো দেখুন',
                        'cta_link' => '#courses',
                        'bg_image' => 'images/home/hero-1.png'
                    ],
                    [
                        'title' => '<span class="text-gradient">AI - এর শক্তিতে</span> গড়ুন আগামীর ক্যারিয়ার',
                        'description' => 'সাধারণ দক্ষতা দিয়ে আর নয়, নিজেকে আপডেট করুন ফিউচার টেকনোলজির সাথে। আজই শুরু হোক আপনার AI জার্নি।',
                        'cta_text' => 'ফ্রি ক্লাস করুন',
                        'cta_link' => '#free-class',
                        'bg_image' => 'images/home/hero-2.png'
                    ],
                    [
                        'title' => '<span class="text-gradient">ইন্ডাস্ট্রি এক্সপার্টদের</span> গাইডলাইনে নিজেকে দক্ষ করে তুলুন',
                        'description' => 'শুধু ভিডিও টিউটোরিয়াল নয়, পাচ্ছেন সরাসরি মেন্টরের সাপোর্ট এবং রিয়েল লাইফ প্রজেক্টের অভিজ্ঞতা।',
                        'cta_text' => 'মেন্টর সম্পর্কে জানুন',
                        'cta_link' => '#mentors',
                        'bg_image' => 'images/home/hero-3.jpg'
                    ]
                ]
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        PageSection::where('pageName', 'home')
            ->where('sectionName', 'hero_slider')
            ->delete();
    }
};
