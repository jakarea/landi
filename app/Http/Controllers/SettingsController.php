<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Update Vimeo settings for instructor
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function vimeoUpdate(Request $request)
    {
        // TODO: Implement Vimeo settings update logic
        return redirect()->back()->with('success', 'Vimeo settings updated successfully');
    }
}