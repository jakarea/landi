<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageSection;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CMSManageController extends Controller
{
    public function index()
    {
        $pageSections = PageSection::all();
        return view('dashboard.admin.cms.index', compact('pageSections'));
    }

    public function edit($id)
    {
        $pageSection = PageSection::findOrFail($id);
        return view('dashboard.admin.cms.edit', compact('pageSection'));
    }

    public function update(Request $request, $id)
    {
        $pageSection = PageSection::findOrFail($id);

        $pageSection->pageName = $request->input('pageName');
        $pageSection->sectionName = $request->input('sectionName');
        
        // Get the content array
        $content = $request->input('content', []);
        
        // Handle image uploads for hero_slider section
        if ($pageSection->sectionName === 'hero_slider' && isset($content['slides'])) {
            foreach ($content['slides'] as $index => $slide) {
                // Check if there's a new image upload for this slide
                if ($request->hasFile("slide_image_{$index}")) {
                    $image = $request->file("slide_image_{$index}");
                    
                    // Validate image
                    $request->validate([
                        "slide_image_{$index}" => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120' // 5MB max
                    ]);
                    
                    // Create directory if it doesn't exist
                    $uploadPath = public_path('images/hero-slider');
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0755, true);
                    }
                    
                    // Delete old image if exists
                    if (isset($slide['bg_image']) && file_exists(public_path($slide['bg_image']))) {
                        // Only delete if it's in the hero-slider directory
                        if (strpos($slide['bg_image'], 'images/hero-slider/') !== false) {
                            unlink(public_path($slide['bg_image']));
                        }
                    }
                    
                    // Generate unique filename
                    $filename = 'hero-' . time() . '-' . $index . '.' . $image->getClientOriginalExtension();
                    
                    // Move the file
                    $image->move($uploadPath, $filename);
                    
                    // Update the bg_image path in content
                    $content['slides'][$index]['bg_image'] = 'images/hero-slider/' . $filename;
                }
            }
        }
        
        $pageSection->content = $content;
        $pageSection->save();

        return redirect()->route('cms.list')->with('success', 'Section updated successfully.');
    }
}
