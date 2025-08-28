<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::where('instructor_id', Auth::id())
            ->with('instructor')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('instructor.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::where('user_id', Auth::id())->get();
        return view('instructor.coupons.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'applicable_courses' => 'nullable|array',
            'applicable_courses.*' => 'exists:courses,id',
            'usage_limit' => 'required|integer|min:1',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'is_active' => 'boolean'
        ]);

        $coupon = new Coupon();
        $coupon->code = $request->code ?: Coupon::generateCode();
        $coupon->name = $request->name;
        $coupon->description = $request->description;
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->instructor_id = Auth::id();
        $coupon->applicable_courses = $request->applicable_courses;
        $coupon->usage_limit = $request->usage_limit;
        $coupon->valid_from = $request->valid_from;
        $coupon->valid_until = $request->valid_until;
        $coupon->is_active = $request->is_active ?? true;
        $coupon->save();

        return redirect()->route('instructor.coupons.index')
            ->with('success', 'Coupon created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        $this->authorize('view', $coupon);
        return view('instructor.coupons.show', compact('coupon'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        $this->authorize('update', $coupon);
        $courses = Course::where('user_id', Auth::id())->get();
        return view('instructor.coupons.edit', compact('coupon', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $this->authorize('update', $coupon);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'applicable_courses' => 'nullable|array',
            'applicable_courses.*' => 'exists:courses,id',
            'usage_limit' => 'required|integer|min:1',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'is_active' => 'boolean'
        ]);

        $coupon->update([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'value' => $request->value,
            'applicable_courses' => $request->applicable_courses,
            'usage_limit' => $request->usage_limit,
            'valid_from' => $request->valid_from,
            'valid_until' => $request->valid_until,
            'is_active' => $request->is_active ?? true
        ]);

        return redirect()->route('instructor.coupons.index')
            ->with('success', 'Coupon updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $this->authorize('delete', $coupon);
        $coupon->delete();

        return redirect()->route('instructor.coupons.index')
            ->with('success', 'Coupon deleted successfully!');
    }

    /**
     * Toggle coupon status
     */
    public function toggleStatus(Coupon $coupon)
    {
        $this->authorize('update', $coupon);
        $coupon->update(['is_active' => !$coupon->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $coupon->is_active
        ]);
    }

    /**
     * Validate and apply coupon
     */
    public function validateCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'course_id' => 'required|exists:courses,id',
            'amount' => 'required|numeric|min:0',
            'user_id' => 'nullable|exists:users,id'
        ]);

        $coupon = Coupon::where('code', $request->code)->first();
        
        // Step 1: Check if coupon exists
        if (!$coupon) {
            return response()->json([
                'error' => 'Coupon code not found',
                'debug' => [
                    'step' => 'coupon_lookup',
                    'searched_code' => $request->code,
                    'message' => 'No coupon found with this code'
                ]
            ], 422);
        }

        // Step 2: Check if coupon is active
        if (!$coupon->is_active) {
            return response()->json([
                'error' => 'Coupon is not active',
                'debug' => [
                    'step' => 'active_check',
                    'coupon_id' => $coupon->id,
                    'is_active' => $coupon->is_active,
                    'message' => 'This coupon has been deactivated'
                ]
            ], 422);
        }

        // Step 3: Check date validity
        $now = now();
        if ($now->lt($coupon->valid_from)) {
            return response()->json([
                'error' => 'Coupon is not yet valid',
                'debug' => [
                    'step' => 'date_check',
                    'current_date' => $now->toDateTimeString(),
                    'valid_from' => $coupon->valid_from->toDateTimeString(),
                    'message' => 'Coupon validity starts later'
                ]
            ], 422);
        }

        if ($now->gt($coupon->valid_until)) {
            return response()->json([
                'error' => 'Coupon has expired',
                'debug' => [
                    'step' => 'date_check',
                    'current_date' => $now->toDateTimeString(),
                    'valid_until' => $coupon->valid_until->toDateTimeString(),
                    'message' => 'Coupon validity has ended'
                ]
            ], 422);
        }

        // Step 4: Check usage limit
        if ($coupon->used_count >= $coupon->usage_limit) {
            return response()->json([
                'error' => 'Coupon usage limit reached',
                'debug' => [
                    'step' => 'usage_limit_check',
                    'used_count' => $coupon->used_count,
                    'usage_limit' => $coupon->usage_limit,
                    'message' => 'This coupon has been used the maximum number of times'
                ]
            ], 422);
        }

        // Step 5: Check course applicability
        if (!$coupon->isApplicableToCourse($request->course_id)) {
            return response()->json([
                'error' => 'Coupon not applicable to this course',
                'debug' => [
                    'step' => 'course_applicability_check',
                    'requested_course_id' => $request->course_id,
                    'applicable_courses' => $coupon->applicable_courses,
                    'message' => 'This coupon can only be used for specific courses'
                ]
            ], 422);
        }

        // Step 6: Check if user already used this coupon for this course
        if ($request->user_id && !$coupon->canBeUsedByUser($request->user_id, $request->course_id)) {
            return response()->json([
                'error' => 'You have already used this coupon for this course',
                'debug' => [
                    'step' => 'user_usage_check',
                    'user_id' => $request->user_id,
                    'course_id' => $request->course_id,
                    'message' => 'Each user can only use a coupon once per course'
                ]
            ], 422);
        }

        // All validations passed - calculate discount
        $discount = $coupon->calculateDiscount($request->amount);
        $finalAmount = $request->amount - $discount;

        return response()->json([
            'success' => true,
            'discount' => $discount,
            'final_amount' => $finalAmount,
            'coupon' => $coupon,
            'debug' => [
                'step' => 'success',
                'original_amount' => $request->amount,
                'discount_type' => $coupon->type,
                'discount_value' => $coupon->value,
                'calculated_discount' => $discount,
                'final_amount' => $finalAmount
            ]
        ]);
    }

    /**
     * Apply coupon and record usage
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'course_id' => 'required|exists:courses,id',
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0'
        ]);

        return DB::transaction(function () use ($request) {
            $coupon = Coupon::where('code', $request->code)->lockForUpdate()->first();

            if (!$coupon) {
                return response()->json(['error' => 'Invalid coupon code'], 422);
            }

            if (!$coupon->isValid()) {
                return response()->json(['error' => 'Coupon has expired or reached usage limit'], 422);
            }

            if (!$coupon->isApplicableToCourse($request->course_id)) {
                return response()->json(['error' => 'Coupon is not applicable to this course'], 422);
            }

            if (!$coupon->canBeUsedByUser($request->user_id, $request->course_id)) {
                return response()->json(['error' => 'You have already used this coupon for this course'], 422);
            }

            $discount = $coupon->calculateDiscount($request->amount);
            $finalAmount = $request->amount - $discount;

            // Record coupon usage
            CouponUsage::create([
                'coupon_id' => $coupon->id,
                'user_id' => $request->user_id,
                'course_id' => $request->course_id,
                'original_amount' => $request->amount,
                'discount_amount' => $discount,
                'final_amount' => $finalAmount
            ]);

            // Update coupon usage count
            $coupon->markAsUsed();

            return response()->json([
                'success' => true,
                'discount' => $discount,
                'final_amount' => $finalAmount,
                'coupon' => $coupon->fresh()
            ]);
        });
    }
}
