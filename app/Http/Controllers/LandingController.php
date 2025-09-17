<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CourseEnrollment;
use App\Models\Notification;
use App\Models\Course;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LandingController extends Controller
{
    public function aiBootcamp()
    {
        $data = [
            'tools' => [
                'tools-01.svg', 'tools-02.svg', 'tools-03.svg',
                'tools-04.svg', 'tools-05.svg', 'tools-06.svg'
            ],

            'projects' => [
                ['project-01.webp', 'col-span-6 lg:col-span-4'],
                ['project-02.webp', 'col-span-6 lg:col-span-2'],
                ['project-03.webp', 'col-span-6 lg:col-span-2'],
                ['project-04.webp', 'col-span-6 lg:col-span-4'],
                ['project-05.webp', 'col-span-6 lg:col-span-3'],
                ['project-06.webp', 'col-span-6 lg:col-span-3'],
                ['project-07.webp', 'col-span-6 lg:col-span-3'],
                ['project-08.webp', 'col-span-6 lg:col-span-3']
            ],

            'clients' => [
                'clients/01.svg', 'clients/02.svg', 'clients/03.svg',
                'clients/04.svg', 'clients/05.svg', 'clients/06.svg',
                'clients/07.svg', 'clients/08.svg', 'clients/09.svg',
                'clients/10.svg', 'clients/11.svg', 'clients/grameenphone.svg',
                'clients/ifad.svg'
            ],

            'attendees' => [
                ['title' => 'ডিজাইনার', 'glow_class' => 'attend-card-glow'],
                ['title' => 'কনটেন্ট ক্রিয়েটর', 'glow_class' => 'attend-card-glow-variant'],
                ['title' => 'এআই শিখার আগ্রহী', 'glow_class' => 'attend-card-glow'],
                ['title' => 'শিক্ষার্থী', 'glow_class' => 'attend-card-glow-variant'],
                ['title' => 'বিজ্ঞাপণ নির্মাতা', 'glow_class' => 'attend-card-glow'],
                ['title' => 'মার্কেটার', 'glow_class' => 'attend-card-glow-variant'],
                ['title' => 'ভিডিও এডিটর', 'glow_class' => 'attend-card-glow'],
                ['title' => 'মিউজিশিয়ান', 'glow_class' => 'attend-card-glow-variant']
            ],

            'faqs' => [
                [
                    'question' => 'এই কোর্সে যোগ দেওয়ার জন্য কি কোনো বিশেষ যোগ্যতার প্রয়োজন আছে?',
                    'answer' => 'না, এই কোর্সে যোগ দিতে কোনো বিশেষ যোগ্যতার প্রয়োজন নেই। শুধু একটি কম্পিউটার/ল্যাপটপ এবং ইন্টারনেট সংযোগ থাকলেই আপনি এই কোর্সে অংশগ্রহণ করতে পারবেন।'
                ],
                [
                    'question' => 'কোর্স কমপ্লিট করলে কি সার্টিফিকেট পাবো?',
                    'answer' => 'হ্যাঁ, কোর্স সফলভাবে সম্পন্ন করলে আপনি একটি ডিজিটাল সার্টিফিকেট পাবেন যা আপনি আপনার CV এবং LinkedIn প্রোফাইলে যোগ করতে পারবেন।'
                ],
                [
                    'question' => 'পেমেন্ট করার পর কি রিফান্ড পাওয়া যাবে?',
                    'answer' => 'কোর্স শুরুর ২৪ ঘন্টা আগে পর্যন্ত রিফান্ডের সুবিধা রয়েছে। তবে কোর্স শুরু হওয়ার পর কোনো রিফান্ড প্রদান করা হবে না।'
                ],
                [
                    'question' => 'লাইভ ক্লাস মিস করলে কি রেকর্ডিং পাবো?',
                    'answer' => 'হ্যাঁ, সকল লাইভ সেশনের রেকর্ডিং পাবেন যা আপনি পরবর্তীতে দেখে নিতে পারবেন। রেকর্ডিং ৩০ দিন পর্যন্ত অ্যাক্সেস করতে পারবেন।'
                ],
                [
                    'question' => 'কোর্স শেষে কি কোনো সাপোর্ট পাবো?',
                    'answer' => 'হ্যাঁ, কোর্স শেষ হওয়ার পর ১৫ দিন পর্যন্ত কমিউনিটি সাপোর্ট এবং Q&A এর সুবিধা পাবেন।'
                ],
                [
                    'question' => 'এই কোর্সের AI টুলস কি ফ্রিতে ব্যবহার করা যাবে?',
                    'answer' => 'কোর্সে আমরা ফ্রি এবং পেইড দুই ধরনের AI টুলস নিয়ে আলোচনা করব। ফ্রি টুলস দিয়েই শুরু করতে পারবেন এবং পরবর্তীতে প্রয়োজন অনুযায়ী পেইড টুলস ব্যবহার করতে পারেন।'
                ]
            ]
        ];

        return view('landing.ai-bootcamp', $data);
    }

    public function enrollBootcamp(Request $request)
    {
        return $request->all();
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|string|max:20',
            'transaction_id' => 'nullable|string|max:100',
            'course_id' => 'required|integer',
            'instructor_id' => 'required|integer',
            'payment' => 'required|in:bkash,nogod,rocket,cash,free_access',
            'amount' => 'required|numeric|min:0',
        ], [
            'email.unique' => 'এই ইমেইল ঠিকানা দিয়ে ইতিমধ্যে একটি অ্যাকাউন্ট রয়েছে।',
            'name.required' => 'নাম আবশ্যক।',
            'email.required' => 'ইমেইল ঠিকানা আবশ্যক।',
            'email.email' => 'বৈধ ইমেইল ঠিকানা প্রদান করুন।',
            'phone.required' => 'ফোন নম্বর আবশ্যক।',
            'payment.required' => 'পেমেন্ট পদ্ধতি নির্বাচন করুন।',
            'amount.required' => 'কোর্সের মূল্য আবশ্যক।',
        ]);

        // Create new user account (email uniqueness already validated)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'user_role' => 'student',
            'password' => Hash::make(Str::random(12)), // Temporary password
            'email_verified_at' => now(), // Auto-verify for bootcamp students
        ]);

        // Create course enrollment
        $enrollment = CourseEnrollment::create([
            'user_id' => $user->id,
            'course_id' => $request->course_id,
            'instructor_id' => $request->instructor_id,
            'status' => 'pending', // Will be approved after instructor review
            'paid' => false,
            'transaction_id' => $request->transaction_id,
            'payment_method' => $request->payment,
            'amount' => $request->amount,
            'original_amount' => $request->amount,
            'start_at' => now(),
        ]);

        // Create notification for instructor
        $course = Course::find($request->course_id);
        $courseName = $course ? $course->title : 'AI Bootcamp';

        Notification::create([
            'instructor_id' => $request->instructor_id,
            'course_id' => $request->course_id,
            'user_id' => $user->id,
            'type' => 'new_enrollment',
            'message' => "🚨 নতুন এনরোলমেন্ট - পেমেন্ট যাচাই প্রয়োজন!\n\nশিক্ষার্থী: {$user->name} ({$user->email})\nকোর্স: {$courseName}\nপেমেন্ট: ৳" . number_format($request->amount) . "\nপেমেন্ট মাধ্যম: " . ucfirst($request->payment) . "\nট্রানজেকশন ID: {$request->transaction_id}\n\n⚠️ Enrollment Management এ গিয়ে পেমেন্ট যাচাই করে অনুমোদন/প্রত্যাখ্যান করুন।",
            'status' => 'unseen'
        ]);

        // Auto-login the user
        Auth::login($user);

        // Redirect to password setup page
        return redirect()->route('student.setup-password')->with('success', 'আপনার AI Bootcamp এনরোলমেন্ট সফল হয়েছে! আপনার অ্যাকাউন্ট তৈরি করা হয়েছে এবং পেমেন্ট ভেরিফিকেশনের জন্য অপেক্ষা করছে। দয়া করে একটি নিরাপদ পাসওয়ার্ড সেট করুন।');
    }
}
