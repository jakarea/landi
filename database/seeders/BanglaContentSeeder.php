<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Course;
use App\Models\Module;
use App\Models\Lesson;
use App\Models\Checkout;

class BanglaContentSeeder extends Seeder
{
    /**
     * Run the database seeder.
     *
     * @return void
     */
    public function run()
    {
        // Check if seeder has already been run
        if (User::where('email', 'rahim@example.com')->exists()) {
            $this->command->info('Bangla content already exists. Skipping seeder.');
            return;
        }
        
        // Create 5 Students
        $students = [
            [
                'name' => 'রহিম উদ্দিন',
                'email' => 'rahim@example.com',
                'user_role' => 'student',
                'phone' => '01712345678',
                'description' => 'একজন উৎসাহী শিক্ষার্থী যিনি প্রযুক্তি শিখতে আগ্রহী।',
                'short_bio' => 'প্রযুক্তিপ্রেমী শিক্ষার্থী',
            ],
            [
                'name' => 'ফাতেমা খাতুন',
                'email' => 'fatema@example.com',
                'user_role' => 'student',
                'phone' => '01798765432',
                'description' => 'ওয়েব ডিজাইনে আগ্রহী একজন মেধাবী ছাত্রী।',
                'short_bio' => 'ওয়েব ডিজাইনার',
            ],
            [
                'name' => 'করিম আহমেদ',
                'email' => 'karim@example.com',
                'user_role' => 'student',
                'phone' => '01856789012',
                'description' => 'ডিজিটাল মার্কেটিং শিখতে আগ্রহী একজন উদ্যোক্তা।',
                'short_bio' => 'ডিজিটাল মার্কেটার',
            ],
            [
                'name' => 'সালমা বেগম',
                'email' => 'salma@example.com',
                'user_role' => 'student',
                'phone' => '01634567890',
                'description' => 'প্রোগ্রামিং শিখতে আগ্রহী একজন কলেজ ছাত্রী।',
                'short_bio' => 'প্রোগ্রামিং শিক্ষার্থী',
            ],
            [
                'name' => 'নাসির হোসেন',
                'email' => 'nasir@example.com',
                'user_role' => 'student',
                'phone' => '01723456789',
                'description' => 'গ্রাফিক ডিজাইনে দক্ষতা অর্জনের জন্য অধ্যয়নরত।',
                'short_bio' => 'গ্রাফিক ডিজাইনার',
            ],
        ];

        foreach ($students as $studentData) {
            User::create($studentData + [
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'status' => 'active',
            ]);
        }

        // Create 2 Instructors
        $instructors = [
            [
                'name' => 'ড. আব্দুল করিম',
                'email' => 'instructor1@example.com',
                'user_role' => 'instructor',
                'phone' => '01987654321',
                'description' => 'কম্পিউটার সায়েন্সে পিএইচডি। ১৫ বছরের শিক্ষকতার অভিজ্ঞতা রয়েছে। ওয়েব ডেভেলপমেন্ট এবং প্রোগ্রামিং ভাষায় বিশেষজ্ঞ।',
                'short_bio' => 'সিনিয়র সফটওয়্যার ইঞ্জিনিয়ার ও প্রশিক্ষক',
                'company_name' => 'টেক একাডেমি বাংলাদেশ',
            ],
            [
                'name' => 'সাবিনা আক্তার',
                'email' => 'instructor2@example.com',
                'user_role' => 'instructor',
                'phone' => '01845678901',
                'description' => 'ডিজিটাল মার্কেটিং এবং UI/UX ডিজাইনে বিশেষজ্ঞ। ১০ বছরের ইন্ডাস্ট্রি এক্সপেরিয়েন্স এবং ৫ বছরের শিক্ষকতার অভিজ্ঞতা।',
                'short_bio' => 'UI/UX ডিজাইনার ও ডিজিটাল মার্কেটিং এক্সপার্ট',
                'company_name' => 'ক্রিয়েটিভ সলিউশন',
            ],
        ];

        $createdInstructors = [];
        foreach ($instructors as $instructorData) {
            $createdInstructors[] = User::create($instructorData + [
                'password' => Hash::make('instructor123'),
                'email_verified_at' => now(),
                'status' => 'active',
            ]);
        }

        // Create 5 Demo Courses in Bengali
        $courses = [
            [
                'instructor_id' => $createdInstructors[0]->id,
                'title' => 'ওয়েব ডেভেলপমেন্ট বেসিক',
                'short_description' => 'এইচটিএমএল, সিএসএস এবং জাভাস্ক্রিপ্ট দিয়ে ওয়েবসাইট তৈরির প্রাথমিক শিক্ষা।',
                'description' => 'এই কোর্সে আপনি শিখবেন কিভাবে একটি সম্পূর্ণ ওয়েবসাইট তৈরি করতে হয়। এইচটিএমএল দিয়ে স্ট্রাকচার, সিএসএস দিয়ে স্টাইলিং এবং জাভাস্ক্রিপ্ট দিয়ে ইন্টারঅ্যাক্টিভিটি যোগ করার সম্পূর্ণ প্রক্রিয়া।',
                'objective' => 'এইচটিএমএল এর বেসিক ট্যাগ এবং স্ট্রাকচার শিখুন[objective]সিএসএস দিয়ে আকর্ষণীয় ডিজাইন তৈরি করুন[objective]জাভাস্ক্রিপ্ট দিয়ে ডায়নামিক ফিচার যোগ করুন[objective]রেসপন্সিভ ডিজাইন তৈরির কৌশল[objective]একটি সম্পূর্ণ ওয়েবসাইট প্রজেক্ট সম্পন্ন করুন',
                'categories' => 'ওয়েব ডেভেলপমেন্ট,প্রোগ্রামিং,বেসিক',
                'language' => 'বাংলা',
                'price' => 1500,
                'offer_price' => 999,
                'status' => 'published',
            ],
            [
                'instructor_id' => $createdInstructors[1]->id,
                'title' => 'ডিজিটাল মার্কেটিং মাস্টারক্লাস',
                'short_description' => 'ফেসবুক, গুগল এবং ইউটিউব মার্কেটিং এর সম্পূর্ণ গাইডলাইন।',
                'description' => 'ডিজিটাল মার্কেটিং এর যুগে এগিয়ে থাকার জন্য প্রয়োজনীয় সকল কৌশল শিখুন। সোশ্যাল মিডিয়া মার্কেটিং, সার্চ ইঞ্জিন অপটিমাইজেশন, কন্টেন্ট মার্কেটিং এবং পেইড অ্যাডভার্টাইজিং এর উপর বিস্তারিত আলোচনা।',
                'objective' => 'ফেসবুক এবং ইনস্টাগ্রাম মার্কেটিং কৌশল[objective]গুগল অ্যাডস এবং এসইও অপটিমাইজেশন[objective]কন্টেন্ট মার্কেটিং এবং ব্র্যান্ডিং[objective]ইমেইল মার্কেটিং ক্যাম্পেইন পরিচালনা[objective]অ্যানালিটিক্স এবং পারফরমেন্স ট্র্যাকিং',
                'categories' => 'ডিজিটাল মার্কেটিং,বিজনেস,সোশ্যাল মিডিয়া',
                'language' => 'বাংলা',
                'price' => 2500,
                'offer_price' => 1999,
                'status' => 'published',
            ],
            [
                'instructor_id' => $createdInstructors[0]->id,
                'title' => 'পাইথন প্রোগ্রামিং বেসিক টু অ্যাডভান্স',
                'short_description' => 'শূন্য থেকে পাইথন প্রোগ্রামিং শিখুন এবং প্রজেক্ট তৈরি করুন।',
                'description' => 'পাইথন প্রোগ্রামিং ভাষার সম্পূর্ণ কোর্স। বেসিক সিনট্যাক্স থেকে শুরু করে অ্যাডভান্স টপিক্স যেমন ডেটা সাইন্স, ওয়েব স্ক্র্যাপিং এবং API ইন্টিগ্রেশন পর্যন্ত।',
                'objective' => 'পাইথনের মৌলিক সিনট্যাক্স এবং ডেটা টাইপ[objective]কন্ডিশনাল স্টেটমেন্ট এবং লুপিং[objective]ফাংশন এবং ক্লাস তৈরি করা[objective]ফাইল হ্যান্ডলিং এবং এরর হ্যান্ডলিং[objective]রিয়েল ওয়ার্ল্ড প্রজেক্ট ডেভেলপমেন্ট',
                'categories' => 'প্রোগ্রামিং,পাইথন,সফটওয়্যার ডেভেলপমেন্ট',
                'language' => 'বাংলা',
                'price' => 3000,
                'offer_price' => 2499,
                'status' => 'published',
            ],
            [
                'instructor_id' => $createdInstructors[1]->id,
                'title' => 'গ্রাফিক ডিজাইন উইথ ফটোশপ',
                'short_description' => 'অ্যাডোবি ফটোশপ দিয়ে প্রফেশনাল গ্রাফিক ডিজাইন শিখুন।',
                'description' => 'অ্যাডোবি ফটোশপের সম্পূর্ণ টুলস এবং টেকনিক শিখে প্রফেশনাল মানের ডিজাইন তৈরি করুন। লোগো ডিজাইন, পোস্টার ডিজাইন, সোশ্যাল মিডিয়া ব্যানার এবং ওয়েব ডিজাইনের উপর হ্যান্ডস-অন প্র্যাক্টিস।',
                'objective' => 'ফটোশপের বেসিক টুলস এবং ইন্টারফেস[objective]ইমেজ এডিটিং এবং রিটাচিং টেকনিক[objective]টাইপোগ্রাফি এবং টেক্সট ইফেক্ট[objective]কালার থিওরি এবং কম্পোজিশন[objective]প্রিন্ট এবং ওয়েব ডিজাইনের জন্য প্রস্তুতি',
                'categories' => 'গ্রাফিক ডিজাইন,ফটোশপ,ক্রিয়েটিভ',
                'language' => 'বাংলা',
                'price' => 2000,
                'offer_price' => 1599,
                'status' => 'published',
            ],
            [
                'instructor_id' => $createdInstructors[0]->id,
                'title' => 'মোবাইল অ্যাপ ডেভেলপমেন্ট উইথ ফ্লাটার',
                'short_description' => 'ফ্লাটার ব্যবহার করে অ্যান্ড্রয়েড এবং আইওএস অ্যাপ তৈরি করুন।',
                'description' => 'গুগলের ফ্লাটার ফ্রেমওয়ার্ক ব্যবহার করে ক্রস-প্ল্যাটফর্ম মোবাইল অ্যাপ্লিকেশন ডেভেলপ করার সম্পূর্ণ গাইড। ডার্ট ল্যাঙ্গুয়েজের বেসিক থেকে কমপ্লেক্স অ্যাপ ডিপ্লয় পর্যন্ত।',
                'objective' => 'ডার্ট প্রোগ্রামিং ল্যাঙ্গুয়েজের বেসিক[objective]ফ্লাটার উইজেট এবং লেআউট সিস্টেম[objective]স্টেট ম্যানেজমেন্ট এবং নেভিগেশন[objective]API ইন্টিগ্রেশন এবং ডেটাবেস[objective]অ্যাপ পাবলিশিং এবং ডিপ্লয়মেন্ট',
                'categories' => 'মোবাইল ডেভেলপমেন্ট,ফ্লাটার,অ্যাপ ডেভেলপমেন্ট',
                'language' => 'বাংলা',
                'price' => 4000,
                'offer_price' => 3199,
                'status' => 'published',
            ],
        ];

        $createdCourses = [];
        foreach ($courses as $courseData) {
            $course = Course::create($courseData + [
                'user_id' => $courseData['instructor_id'],
                'slug' => \Illuminate\Support\Str::slug($courseData['title']) . '-' . time(),
                'curriculum' => 'এই কোর্সে ধাপে ধাপে শিক্ষা পদ্ধতি অনুসরণ করা হয়েছে।',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $createdCourses[] = $course;
        }

        // Create modules and lessons for each course
        $moduleData = [
            [
                'title' => 'পরিচিতি এবং সেটআপ',
                'lessons' => [
                    'কোর্সের পরিচিতি',
                    'প্রয়োজনীয় সফটওয়্যার ইনস্টলেশন',
                    'প্রজেক্ট সেটআপ',
                ]
            ],
            [
                'title' => 'মৌলিক বিষয়সমূহ',
                'lessons' => [
                    'বেসিক কনসেপ্ট',
                    'টুলস পরিচিতি',
                    'প্রথম প্রজেক্ট',
                ]
            ],
            [
                'title' => 'অ্যাডভান্স টপিকস',
                'lessons' => [
                    'অ্যাডভান্স টেকনিক',
                    'বেস্ট প্র্যাকটিস',
                    'ট্রাবলশুটিং',
                ]
            ],
            [
                'title' => 'প্রজেক্ট এবং অনুশীলন',
                'lessons' => [
                    'হ্যান্ডস-অন প্রজেক্ট',
                    'পরীক্ষা এবং মূল্যায়ন',
                    'চূড়ান্ত প্রজেক্ট',
                ]
            ]
        ];

        foreach ($createdCourses as $course) {
            foreach ($moduleData as $index => $moduleInfo) {
                $module = Module::create([
                    'course_id' => $course->id,
                    'instructor_id' => $course->instructor_id,
                    'title' => $moduleInfo['title'],
                    'slug' => \Illuminate\Support\Str::slug($moduleInfo['title']) . '-' . $course->id . '-' . $index,
                    'reorder' => $index + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                foreach ($moduleInfo['lessons'] as $lessonIndex => $lessonTitle) {
                    Lesson::create([
                        'course_id' => $course->id,
                        'module_id' => $module->id,
                        'instructor_id' => $course->instructor_id,
                        'title' => $lessonTitle,
                        'slug' => \Illuminate\Support\Str::slug($lessonTitle) . '-' . $module->id . '-' . $lessonIndex,
                        'type' => ['video', 'text', 'audio'][array_rand(['video', 'text', 'audio'])],
                        'status' => 'published',
                        'reorder' => $lessonIndex + 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        // Create some enrollments (checkout records)
        $studentUsers = User::where('user_role', 'student')->get();
        $enrollmentData = [];
        
        foreach ($studentUsers as $student) {
            // Enroll each student in 1-3 random courses
            $coursesToEnroll = collect($createdCourses)->random(rand(1, 3));
            
            foreach ($coursesToEnroll as $course) {
                $enrollmentData[] = [
                    'user_id' => $student->id,
                    'course_id' => $course->id,
                    'instructor_id' => $course->instructor_id,
                    'payment_method' => ['bkash', 'nogod', 'rocket'][array_rand(['bkash', 'nogod', 'rocket'])],
                    'payment_status' => 'completed',
                    'payment_id' => 'DEMO_' . strtoupper(uniqid()),
                    'transaction_id' => strtoupper(uniqid()),
                    'amount' => $course->offer_price ?: $course->price,
                    'status' => 'completed',
                    'is_manual' => true,
                    'start_date' => now()->subDays(rand(1, 30)),
                    'end_date' => now()->addYear(),
                    'payment_date' => now()->subDays(rand(1, 30)),
                    'notes' => 'ডেমো এনরোলমেন্ট',
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now(),
                ];
            }
        }

        foreach ($enrollmentData as $enrollment) {
            Checkout::create($enrollment);
        }

        $this->command->info('Bangla content seeded successfully!');
        $this->command->info('Created:');
        $this->command->info('- 5 Students');
        $this->command->info('- 2 Instructors');  
        $this->command->info('- 5 Courses with Bengali content');
        $this->command->info('- Modules and Lessons for each course');
        $this->command->info('- Demo enrollments');
    }
}