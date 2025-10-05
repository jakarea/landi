<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CMSManageController extends Controller
{
    //

    public function index()
    {
         $analytics_title = 'Yearly Analytics';
         $coupons = Coupon::where('instructor_id', Auth::id())
            ->with('instructor')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('dashboard.admin.cms.index', compact('analytics_title','coupons'));
    }
}
