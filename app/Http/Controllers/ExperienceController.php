<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller
{
    /**
     * Store instructor experience
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'profession' => 'required|string|max:255',
                'company_name' => 'required|string|max:255',
                'job_type' => 'required|string|max:255',
                'experience' => 'required|string|max:255',
                'short_description' => 'nullable|string|max:1000',
            ]);

            $experience = new Experience();
            $experience->user_id = Auth::id();
            $experience->profession = $request->profession;
            $experience->company_name = $request->company_name;
            $experience->job_type = $request->job_type;
            $experience->experience = $request->experience;
            $experience->join_date = now(); // Set current date as default
            $experience->retire_date = null; // Set as null for now
            $experience->short_description = $request->short_description;
            $experience->save();

            // Check if this is an AJAX request
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'অভিজ্ঞতা সফলভাবে যোগ করা হয়েছে!',
                    'experience' => $experience
                ]);
            }

            return redirect()->back()->with('success', 'Experience added successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'কিছু ভুল হয়েছে, আবার চেষ্টা করুন।'
                ], 500);
            }
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Update instructor experience
     *
     * @param Request $request
     * @param int $experienceId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $experienceId)
    {
        try {
            $this->validate($request, [
                'profession' => 'required|string|max:255',
                'company_name' => 'required|string|max:255',
                'job_type' => 'required|string|max:255',
                'experience' => 'required|string|max:255',
                'short_description' => 'nullable|string|max:1000',
            ]);

            $experience = Experience::where('id', $experienceId)
                                    ->where('user_id', Auth::id())
                                    ->firstOrFail();
            
            $experience->profession = $request->profession;
            $experience->company_name = $request->company_name;
            $experience->job_type = $request->job_type;
            $experience->experience = $request->experience;
            $experience->short_description = $request->short_description;
            $experience->save();

            // Check if this is an AJAX request
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'অভিজ্ঞতা সফলভাবে আপডেট করা হয়েছে!',
                    'experience' => $experience
                ]);
            }

            return redirect()->back()->with('success', 'Experience updated successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'কিছু ভুল হয়েছে, আবার চেষ্টা করুন।'
                ], 500);
            }
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Show experience edit form
     *
     * @param int $experienceId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($experienceId)
    {
        $experience = Experience::where('id', $experienceId)
                                ->where('user_id', Auth::id())
                                ->firstOrFail();

        // Redirect back to profile with edit mode parameters
        return redirect()->route('instructor.profile')
                        ->with('edit_experience', $experience)
                        ->with('tab', 'experience');
    }

    /**
     * Delete instructor experience
     *
     * @param int $experienceId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($experienceId)
    {
        $experience = Experience::where('id', $experienceId)
                                ->where('user_id', Auth::id())
                                ->firstOrFail();

        $experience->delete();

        return redirect()->back()->with('success', 'Experience deleted successfully!');
    }
}