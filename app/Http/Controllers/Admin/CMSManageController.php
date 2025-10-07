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
        $pageSection->content = $request->input('content');

        $pageSection->save();

        return redirect()->route('cms.list')->with('success', 'Section updated successfully.');
    }
}
