<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::orderBy('display_order', 'asc')->get();
        return view('dashboard.admin.reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admin.reviews.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reviewer_name' => 'required|string|max:255',
            'reviewer_designation' => 'nullable|string|max:255',
            'review_text' => 'required|string',
            'reviewer_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'display_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Handle avatar upload
        if ($request->hasFile('reviewer_avatar')) {
            $file = $request->file('reviewer_avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/reviews'), $filename);
            $validated['reviewer_avatar'] = 'images/reviews/' . $filename;
        }

        $validated['is_active'] = $request->has('is_active');

        Review::create($validated);

        return redirect()->route('cms.reviews.index')
            ->with('success', 'Review created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $review = Review::findOrFail($id);
        return view('dashboard.admin.reviews.edit', compact('review'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        $validated = $request->validate([
            'reviewer_name' => 'required|string|max:255',
            'reviewer_designation' => 'nullable|string|max:255',
            'review_text' => 'required|string',
            'reviewer_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'display_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Handle avatar upload
        if ($request->hasFile('reviewer_avatar')) {
            // Delete old avatar if exists
            if ($review->reviewer_avatar && file_exists(public_path($review->reviewer_avatar))) {
                unlink(public_path($review->reviewer_avatar));
            }

            $file = $request->file('reviewer_avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/reviews'), $filename);
            $validated['reviewer_avatar'] = 'images/reviews/' . $filename;
        }

        $validated['is_active'] = $request->has('is_active');

        $review->update($validated);

        return redirect()->route('cms.reviews.index')
            ->with('success', 'Review updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        // Delete avatar if exists
        if ($review->reviewer_avatar && file_exists(public_path($review->reviewer_avatar))) {
            unlink(public_path($review->reviewer_avatar));
        }

        $review->delete();

        return redirect()->route('cms.reviews.index')
            ->with('success', 'Review deleted successfully!');
    }
}
