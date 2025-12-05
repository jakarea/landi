<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CourseEnrollmentController extends Controller
{
    public function __construct() 
    {
        // Auth middleware is applied at route level
    }

    /**
     * Show enrollment form for a course
     */
    public function show($slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        
        // Check if student is already enrolled
        $existingEnrollment = CourseEnrollment::where('course_id', $course->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingEnrollment) {
            return redirect()->route('courses.overview', $course->slug)->with('info', 'You have already applied for this course.');
        }

        return view('courses.enroll', compact('course'));
    }

    /**
     * Store enrollment application
     */
    public function store(Request $request, $slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        
        // Basic validation
        $request->validate([
            'payment_method' => 'required|in:bkash,nogod,rocket,cash',
            'transaction_id' => 'nullable|string|max:255',
            'payment_screenshot' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            'promo_code' => 'nullable|string|max:50',
        ], [
            'payment_screenshot.image' => 'Payment screenshot must be a valid image (JPEG, PNG, JPG, GIF).',
            'payment_screenshot.mimes' => 'Payment screenshot must be a JPEG, PNG, JPG, or GIF file.',
            'payment_screenshot.max' => 'Payment screenshot size must not exceed 5MB.',
        ]);

        // Custom validation for digital payments - require either transaction_id OR payment_screenshot
        if ($request->payment_method !== 'cash') {
            if (empty($request->transaction_id) && !$request->hasFile('payment_screenshot')) {
                return redirect()->route('courses.enroll', $course->slug)
                    ->withErrors(['payment_proof' => 'For digital payments, please provide either transaction ID or payment screenshot.'])
                    ->withInput();
            }
        }

        // Check if student is already enrolled
        $existingEnrollment = CourseEnrollment::where('course_id', $course->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingEnrollment) {
            return redirect()->route('courses.overview', $course->slug)->with('error', 'You have already applied for this course.');
        }

        // Calculate final amount (considering promo code if provided)
        $finalAmount = $course->offer_price ?? $course->price;
        $promoDiscount = 0;
        
        if ($request->promo_code) {
            // Simple promo code validation (in production, this should be in database)
            $promoCodes = [
                'SAVE10' => ['type' => 'percentage', 'value' => 10],
                'SAVE500' => ['type' => 'fixed', 'value' => 500],
                'WELCOME' => ['type' => 'percentage', 'value' => 15],
                'STUDENT' => ['type' => 'fixed', 'value' => 1000],
            ];
            
            $promoCode = strtoupper($request->promo_code);
            if (isset($promoCodes[$promoCode])) {
                $promo = $promoCodes[$promoCode];
                if ($promo['type'] === 'percentage') {
                    $promoDiscount = round($finalAmount * ($promo['value'] / 100));
                } else {
                    $promoDiscount = $promo['value'];
                }
                
                // Ensure discount doesn't exceed total (minimum ৳100)
                if ($promoDiscount >= $finalAmount) {
                    $promoDiscount = $finalAmount - 100;
                }
                
                $finalAmount -= $promoDiscount;
            }
        }

        // Handle file upload to public/uploads folder
        $screenshotPath = null;
        if ($request->hasFile('payment_screenshot')) {
            try {
                $file = $request->file('payment_screenshot');
                
                // Validate file is actually uploaded and valid
                if (!$file->isValid()) {
                    $error = $file->getErrorMessage();
                    Log::error('Invalid file upload: ' . $error);
                    return redirect()->route('courses.enroll', $course->slug)
                        ->withErrors(['payment_screenshot' => 'The uploaded file is corrupted: ' . $error])
                        ->withInput();
                }
                
                // Check file size (Laravel validation should catch this, but double check)
                if ($file->getSize() > 5 * 1024 * 1024) { // 5MB
                    return redirect()->route('courses.enroll', $course->slug)
                        ->withErrors(['payment_screenshot' => 'File size exceeds 5MB limit.'])
                        ->withInput();
                }
                
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('uploads/enrollments');
                
                // Create directory if it doesn't exist
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                
                // Move file and check if successful
                if ($file->move($destinationPath, $fileName)) {
                    $screenshotPath = 'uploads/enrollments/' . $fileName;
                } else {
                    return redirect()->route('courses.enroll', $course->slug)
                        ->withErrors(['payment_screenshot' => 'Failed to upload payment screenshot. Please try again.'])
                        ->withInput();
                }
                
            } catch (\Exception $e) {
                Log::error('Payment screenshot upload failed: ' . $e->getMessage(), [
                    'file_size' => $file->getSize(),
                    'file_name' => $file->getClientOriginalName(),
                    'file_mime' => $file->getMimeType(),
                    'course_slug' => $course->slug,
                    'user_id' => Auth::id()
                ]);
                return redirect()->route('courses.enroll', $course->slug)
                    ->withErrors(['payment_screenshot' => 'Upload failed: ' . $e->getMessage() . '. Please try a smaller image or different format.'])
                    ->withInput();
            }
        } else if ($request->payment_method !== 'cash') {
            // No file uploaded but digital payment selected
            Log::info('No payment screenshot uploaded for digital payment', [
                'payment_method' => $request->payment_method,
                'has_transaction_id' => !empty($request->transaction_id)
            ]);
        }

        // Create enrollment
        // If student provides payment info, they've "paid" - just waiting instructor approval
        // If no payment info (cash), it's payment pending
        $status = ($request->payment_method === 'cash' && empty($request->transaction_id) && !$request->hasFile('payment_screenshot')) 
                 ? CourseEnrollment::STATUS_PAYMENT_PENDING 
                 : CourseEnrollment::STATUS_PENDING;
        
        $paid = ($status === CourseEnrollment::STATUS_PENDING); // True if payment submitted
        
        CourseEnrollment::create([
            'course_id' => $course->id,
            'user_id' => Auth::id(),
            'instructor_id' => $course->user_id,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'amount' => $finalAmount,
            'original_amount' => $course->offer_price ?? $course->price,
            'promo_code' => $request->promo_code,
            'promo_discount' => $promoDiscount,
            'status' => $status,
            'paid' => $paid,
            'payment_screenshot' => $screenshotPath,
        ]);

        $message = ($status === CourseEnrollment::STATUS_PENDING) 
                  ? 'Your enrollment has been submitted successfully with payment proof. Wait for instructor approval.'
                  : 'Your enrollment application has been submitted. Please complete payment to proceed.';
        
        return redirect()->route('student.dashboard')
            ->with('success', $message);
    }

    /**
     * Show pending enrollments for instructor (paid, waiting approval)
     */
    public function pendingEnrollments()
    {
        $enrollments = CourseEnrollment::with(['course', 'student'])
            ->where('instructor_id', Auth::id())
            ->pending()  // Students who paid, waiting approval
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('instructor.enrollments.pending-tailwind', compact('enrollments'));
    }

    /**
     * Show payment pending enrollments for instructor (not paid yet)
     */
    public function paymentPendingEnrollments()
    {
        $enrollments = CourseEnrollment::with(['course', 'student'])
            ->where('instructor_id', Auth::id())
            ->paymentPending()  // Students who haven't paid yet
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('instructor.enrollments.payment-pending-tailwind', compact('enrollments'));
    }

    /**
     * Show all enrollments for instructor
     */
    public function allEnrollments(Request $request)
    {
        $query = CourseEnrollment::with(['course', 'student'])
            ->where('instructor_id', Auth::id());

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            })->orWhereHas('course', function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('course')) {
            $query->where('course_id', $request->course);
        }

        $enrollments = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('instructor.enrollments.all-tailwind', compact('enrollments'));
    }

    /**
     * Approve enrollment with payment verification
     */
    public function approve(Request $request, CourseEnrollment $enrollment)
    {
        $this->authorize('manage', $enrollment);

        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $enrollment->update([
            'status' => CourseEnrollment::STATUS_APPROVED,
            'paid' => true,
            'start_at' => now(),
            'end_at' => now()->addYear(), // 1 year access
            'admin_notes' => $request->admin_notes,
        ]);

        // Create notification for student
        Notification::create([
            'instructor_id' => Auth::id(),
            'course_id' => $enrollment->course_id,
            'user_id' => $enrollment->user_id,
            'type' => 'enrollment_approved',
            'message' => "আপনার {$enrollment->course->title} কোর্সের এনরোলমেন্ট অনুমোদিত হয়েছে! এখন আপনি কোর্স অ্যাক্সেস করতে পারবেন।",
            'status' => 'unseen'
        ]);

        // Mark instructor notification as seen
        Notification::where('instructor_id', Auth::id())
            ->where('course_id', $enrollment->course_id)
            ->where('user_id', $enrollment->user_id)
            ->where('type', 'new_enrollment')
            ->update(['status' => 'seen']);

        return redirect()->back()->with('success', 'Enrollment approved successfully with payment verification.');
    }

    /**
     * Approve enrollment without payment (manual/free access)
     */
    public function approveWithoutPayment(Request $request, CourseEnrollment $enrollment)
    {
        $this->authorize('manage', $enrollment);

        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $enrollment->update([
            'status' => CourseEnrollment::STATUS_APPROVED,
            'paid' => false, // Mark as unpaid but approved (free access)
            'amount' => 0, // Set amount to 0 for free access
            'start_at' => now(),
            'end_at' => now()->addYear(), // 1 year access
            'admin_notes' => $request->admin_notes . ' [FREE ACCESS GRANTED]',
            'rejection_reason' => null, // Clear any previous rejection reason
        ]);

        return redirect()->back()->with('success', 'Free access granted successfully.');
    }

    /**
     * Reject enrollment
     */
    public function reject(Request $request, CourseEnrollment $enrollment)
    {
        $this->authorize('manage', $enrollment);

        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $enrollment->update([
            'status' => CourseEnrollment::STATUS_REJECTED,
            'rejection_reason' => $request->rejection_reason,
        ]);

        // Create notification for student
        Notification::create([
            'instructor_id' => Auth::id(),
            'course_id' => $enrollment->course_id,
            'user_id' => $enrollment->user_id,
            'type' => 'enrollment_declined',
            'message' => "আপনার {$enrollment->course->title} কোর্সের এনরোলমেন্ট প্রত্যাখ্যান করা হয়েছে। কারণ: {$request->rejection_reason}",
            'status' => 'unseen'
        ]);

        // Mark instructor notification as seen
        Notification::where('instructor_id', Auth::id())
            ->where('course_id', $enrollment->course_id)
            ->where('user_id', $enrollment->user_id)
            ->where('type', 'new_enrollment')
            ->update(['status' => 'seen']);

        return redirect()->back()->with('success', 'Enrollment rejected.');
    }

    /**
     * Re-approve a previously rejected enrollment
     */
    public function reapprove(Request $request, CourseEnrollment $enrollment)
    {
        $this->authorize('manage', $enrollment);

        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
            'approve_type' => 'required|in:with_payment,without_payment'
        ]);

        $updateData = [
            'status' => CourseEnrollment::STATUS_APPROVED,
            'start_at' => now(),
            'end_at' => now()->addYear(),
            'rejection_reason' => null, // Clear rejection reason
        ];

        if ($request->approve_type === 'without_payment') {
            $updateData['paid'] = false;
            $updateData['amount'] = 0;
            $updateData['admin_notes'] = $request->admin_notes . ' [RE-APPROVED - FREE ACCESS]';
        } else {
            $updateData['paid'] = true;
            $updateData['admin_notes'] = $request->admin_notes . ' [RE-APPROVED - PAYMENT VERIFIED]';
        }

        $enrollment->update($updateData);

        $message = $request->approve_type === 'without_payment' 
            ? 'Enrollment re-approved with free access.' 
            : 'Enrollment re-approved with payment verification.';

        return redirect()->back()->with('success', $message);
    }

    /**
     * Grant free access to a student for a specific course
     */
    public function grantFreeAccess(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        // Verify the course belongs to the instructor
        $course = Course::where('id', $request->course_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$course) {
            return response()->json([
                'error' => 'You can only grant access to your own courses'
            ], 403);
        }

        // Check if student is already enrolled
        $existingEnrollment = CourseEnrollment::where('user_id', $request->user_id)
            ->where('course_id', $request->course_id)
            ->first();

        if ($existingEnrollment) {
            if ($existingEnrollment->status === CourseEnrollment::STATUS_APPROVED) {
                return response()->json([
                    'error' => 'Student is already enrolled in this course'
                ], 422);
            } else {
                // Update existing enrollment to approved with free access
                $existingEnrollment->update([
                    'status' => CourseEnrollment::STATUS_APPROVED,
                    'paid' => false,
                    'amount' => 0,
                    'original_amount' => $course->offer_price ?? $course->price,
                    'start_at' => now(),
                    'end_at' => now()->addYear(),
                    'admin_notes' => ($request->admin_notes ?? '') . ' [INSTRUCTOR GRANTED FREE ACCESS]',
                    'rejection_reason' => null
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Student\'s existing enrollment updated to free access'
                ]);
            }
        }

        // Create new enrollment with free access
        CourseEnrollment::create([
            'course_id' => $request->course_id,
            'user_id' => $request->user_id,
            'instructor_id' => Auth::id(),
            'payment_method' => 'free_access',
            'transaction_id' => null,
            'amount' => 0,
            'original_amount' => $course->offer_price ?? $course->price,
            'promo_code' => null,
            'promo_discount' => 0,
            'status' => CourseEnrollment::STATUS_APPROVED,
            'paid' => false, // Free access
            'start_at' => now(),
            'end_at' => now()->addYear(),
            'payment_screenshot' => null,
            'admin_notes' => ($request->admin_notes ?? '') . ' [INSTRUCTOR GRANTED FREE ACCESS]',
            'rejection_reason' => null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Free access granted successfully'
        ]);
    }

    /**
     * Show student's enrollments
     */
    public function myEnrollments()
    {
        $enrollments = CourseEnrollment::with('course')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('students.enrollments', compact('enrollments'));
    }
}
