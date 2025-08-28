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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'profession' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'job_type' => 'required|string|max:255',
            'experience' => 'required|string|max:255',
            'join_date' => 'required|date',
            'retire_date' => 'nullable|date|after:join_date',
            'short_description' => 'nullable|string|max:1000',
        ]);

        $experience = new Experience();
        $experience->user_id = Auth::id();
        $experience->profession = $request->profession;
        $experience->company_name = $request->company_name;
        $experience->job_type = $request->job_type;
        $experience->experience = $request->experience;
        $experience->join_date = $request->join_date;
        $experience->retire_date = $request->retire_date;
        $experience->short_description = $request->short_description;
        $experience->save();

        return redirect()->back()->with('success', 'Experience added successfully!');
    }

    /**
     * Update instructor experience
     *
     * @param Request $request
     * @param Experience $experience
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $experienceId)
    {
        $this->validate($request, [
            'profession' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'job_type' => 'required|string|max:255',
            'experience' => 'required|string|max:255',
            'join_date' => 'required|date',
            'retire_date' => 'nullable|date|after:join_date',
            'short_description' => 'nullable|string|max:1000',
        ]);

        $experience = Experience::where('id', $experienceId)
                                ->where('user_id', Auth::id())
                                ->firstOrFail();
        
        $experience->profession = $request->profession;
        $experience->company_name = $request->company_name;
        $experience->job_type = $request->job_type;
        $experience->experience = $request->experience;
        $experience->join_date = $request->join_date;
        $experience->retire_date = $request->retire_date;
        $experience->short_description = $request->short_description;
        $experience->save();

        return redirect()->back()->with('success', 'Experience updated successfully!');
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