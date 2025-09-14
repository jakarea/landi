<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class UserSession extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'device_name',
        'device_type',
        'browser',
        'os',
        'ip_address',
        'country',
        'city',
        'latitude',
        'longitude',
        'user_agent',
        'last_activity',
        'is_current'
    ];

    protected $casts = [
        'last_activity' => 'datetime',
        'is_current' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getLocationAttribute(): string
    {
        if ($this->city && $this->country) {
            return $this->city . ', ' . $this->country;
        }
        return $this->country ?: 'Unknown Location';
    }

    public function getDeviceInfoAttribute(): string
    {
        $parts = array_filter([
            $this->device_name,
            $this->browser,
            $this->os
        ]);
        return implode(' - ', $parts) ?: 'Unknown Device';
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->last_activity->gt(Carbon::now()->subMinutes(5));
    }

    public function getLastActivityHumanAttribute(): string
    {
        return $this->last_activity->diffForHumans();
    }

    public static function createOrUpdateSession($user, $request)
    {
        $sessionId = session()->getId();
        $userAgent = $request->userAgent();
        $ipAddress = $request->ip();
        
        // Parse user agent
        $parser = self::parseUserAgent($userAgent);
        
        // Get location data (you can integrate with IP geolocation service)
        $location = self::getLocationFromIp($ipAddress);
        
        // Create device fingerprint for better duplicate detection
        $deviceFingerprint = md5($userAgent . $parser['browser'] . $parser['os'] . $parser['device_type']);
        
        // First, try to find existing session for this user with same session_id
        $existingSession = self::where('user_id', $user->id)
            ->where('session_id', $sessionId)
            ->first();
            
        if ($existingSession) {
            // Update existing session
            $existingSession->update([
                'device_name' => $parser['device'],
                'device_type' => $parser['device_type'],
                'browser' => $parser['browser'],
                'os' => $parser['os'],
                'ip_address' => $ipAddress,
                'country' => $location['country'] ?? null,
                'city' => $location['city'] ?? null,
                'latitude' => $location['latitude'] ?? null,
                'longitude' => $location['longitude'] ?? null,
                'user_agent' => $userAgent,
                'last_activity' => now(),
                'is_current' => true
            ]);
            return $existingSession;
        }
        
        // Check if there's already a session with same device fingerprint and IP
        $duplicateSession = self::where('user_id', $user->id)
            ->where('user_agent', $userAgent)
            ->where('ip_address', $ipAddress)
            ->where('browser', $parser['browser'])
            ->where('os', $parser['os'])
            ->where('device_type', $parser['device_type'])
            ->first();
            
        if ($duplicateSession) {
            // Update the existing duplicate session with new session_id
            $duplicateSession->update([
                'session_id' => $sessionId,
                'device_name' => $parser['device'],
                'country' => $location['country'] ?? null,
                'city' => $location['city'] ?? null,
                'latitude' => $location['latitude'] ?? null,
                'longitude' => $location['longitude'] ?? null,
                'last_activity' => now(),
                'is_current' => true
            ]);
            return $duplicateSession;
        }
        
        // Create new session if no duplicates found
        return self::create([
            'user_id' => $user->id,
            'session_id' => $sessionId,
            'device_name' => $parser['device'],
            'device_type' => $parser['device_type'],
            'browser' => $parser['browser'],
            'os' => $parser['os'],
            'ip_address' => $ipAddress,
            'country' => $location['country'] ?? null,
            'city' => $location['city'] ?? null,
            'latitude' => $location['latitude'] ?? null,
            'longitude' => $location['longitude'] ?? null,
            'user_agent' => $userAgent,
            'last_activity' => now(),
            'is_current' => true
        ]);
    }

    private static function parseUserAgent($userAgent)
    {
        // Simple user agent parsing (you can use a more sophisticated library)
        $browser = 'Unknown Browser';
        $os = 'Unknown OS';
        $device = 'Unknown Device';
        $deviceType = 'desktop';

        // Detect browser
        if (preg_match('/Chrome/', $userAgent)) {
            $browser = 'Google Chrome';
        } elseif (preg_match('/Firefox/', $userAgent)) {
            $browser = 'Mozilla Firefox';
        } elseif (preg_match('/Safari/', $userAgent) && !preg_match('/Chrome/', $userAgent)) {
            $browser = 'Safari';
        } elseif (preg_match('/Edge/', $userAgent)) {
            $browser = 'Microsoft Edge';
        }

        // Detect OS
        if (preg_match('/Windows NT/', $userAgent)) {
            $os = 'Windows';
        } elseif (preg_match('/Mac OS X/', $userAgent)) {
            $os = 'macOS';
        } elseif (preg_match('/Linux/', $userAgent)) {
            $os = 'Linux';
        } elseif (preg_match('/Android/', $userAgent)) {
            $os = 'Android';
            $deviceType = 'mobile';
        } elseif (preg_match('/iOS|iPhone|iPad/', $userAgent)) {
            $os = 'iOS';
            $deviceType = preg_match('/iPad/', $userAgent) ? 'tablet' : 'mobile';
        }

        // Detect device type
        if (preg_match('/Mobile|Android|iPhone/', $userAgent)) {
            $deviceType = 'mobile';
            $device = 'Mobile Device';
        } elseif (preg_match('/iPad|Tablet/', $userAgent)) {
            $deviceType = 'tablet';
            $device = 'Tablet';
        } else {
            $device = 'Desktop Computer';
        }

        return [
            'browser' => $browser,
            'os' => $os,
            'device' => $device,
            'device_type' => $deviceType
        ];
    }

    private static function getLocationFromIp($ip)
    {
        // For development, return Bangladesh as default
        // In production, you would integrate with a service like ipapi.com or similar
        if ($ip === '127.0.0.1' || $ip === '::1') {
            return [
                'country' => 'Bangladesh',
                'city' => 'Dhaka',
                'latitude' => 23.8103,
                'longitude' => 90.4125
            ];
        }

        // You can integrate with services like:
        // - ipapi.com
        // - ipinfo.io
        // - maxmind.com
        
        return [
            'country' => null,
            'city' => null,
            'latitude' => null,
            'longitude' => null
        ];
    }
}
