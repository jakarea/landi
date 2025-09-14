<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserSession;
use Illuminate\Support\Facades\Auth;

class TrackUserSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track authenticated users
        if (Auth::check()) {
            $user = Auth::user();
            $currentSessionId = session()->getId();
            
            // Mark all other sessions as not current
            UserSession::where('user_id', $user->id)
                ->where('session_id', '!=', $currentSessionId)
                ->update(['is_current' => false]);
            
            // Create or update current session (this now includes duplicate prevention)
            UserSession::createOrUpdateSession($user, $request);
            
            // Clean up old inactive sessions (optional - keep only last 10 sessions per user)
            $this->cleanupOldSessions($user->id, $currentSessionId);
        }

        return $response;
    }
    
    /**
     * Clean up old inactive sessions to prevent database bloat
     */
    private function cleanupOldSessions($userId, $currentSessionId)
    {
        // Keep only the 10 most recent sessions per user
        $keepSessionIds = UserSession::where('user_id', $userId)
            ->orderBy('last_activity', 'desc')
            ->limit(10)
            ->pluck('session_id')
            ->toArray();
            
        // Delete sessions older than the last 10, excluding current session
        UserSession::where('user_id', $userId)
            ->where('session_id', '!=', $currentSessionId)
            ->whereNotIn('session_id', $keepSessionIds)
            ->delete();
    }
}
