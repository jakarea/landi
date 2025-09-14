<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserSession;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $currentSessionId = session()->getId();
        
        $sessions = UserSession::where('user_id', $user->id)
            ->orderBy('last_activity', 'desc')
            ->get();

        $currentSession = $sessions->where('session_id', $currentSessionId)->first();
        $otherSessions = $sessions->where('session_id', '!=', $currentSessionId);

        return view('student.devices', compact('currentSession', 'otherSessions'));
    }

    public function revoke(Request $request, $sessionId)
    {
        $user = Auth::user();
        $currentSessionId = session()->getId();

        // Don't allow revoking current session
        if ($sessionId === $currentSessionId) {
            return back()->with('error', 'আপনি বর্তমান সেশন বন্ধ করতে পারবেন না।');
        }

        $session = UserSession::where('user_id', $user->id)
            ->where('session_id', $sessionId)
            ->first();

        if (!$session) {
            return back()->with('error', 'সেশন খুঁজে পাওয়া যায়নি।');
        }

        $session->delete();

        return back()->with('success', 'ডিভাইস সফলভাবে বন্ধ করা হয়েছে।');
    }

    public function revokeAll(Request $request)
    {
        $user = Auth::user();
        $currentSessionId = session()->getId();

        // Delete all sessions except current
        UserSession::where('user_id', $user->id)
            ->where('session_id', '!=', $currentSessionId)
            ->delete();

        return back()->with('success', 'অন্য সকল ডিভাইস থেকে লগআউট করা হয়েছে।');
    }
}
