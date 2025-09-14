@extends('layouts.student-modern')

@section('title', 'ডিভাইস ম্যানেজমেন্ট')

@section('content')
<div class="p-6 space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">ডিভাইস ম্যানেজমেন্ট</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">আপনার লগইন ডিভাইস ও লোকেশন দেখুন</p>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 p-4 rounded-xl">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 p-4 rounded-xl">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Current Device -->
    @if($currentSession)
    <div class="glass-effect rounded-xl p-6 border border-white/20">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-slate-900 dark:text-white flex items-center">
                <i class="fas fa-mobile-alt text-blue-500 mr-3"></i>
                বর্তমান ডিভাইস
            </h2>
            <span class="bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 px-3 py-1 rounded-full text-sm font-medium">
                <i class="fas fa-circle text-xs mr-1"></i>
                সক্রিয়
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="space-y-2">
                <div class="text-slate-500 dark:text-slate-400 text-sm">ডিভাইস তথ্য</div>
                <div class="text-slate-900 dark:text-white font-medium">{{ $currentSession->device_info }}</div>
            </div>
            
            <div class="space-y-2">
                <div class="text-slate-500 dark:text-slate-400 text-sm">অবস্থান</div>
                <div class="text-slate-900 dark:text-white font-medium flex items-center">
                    <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>
                    {{ $currentSession->location }}
                </div>
            </div>
            
            <div class="space-y-2">
                <div class="text-slate-500 dark:text-slate-400 text-sm">IP ঠিকানা</div>
                <div class="text-slate-900 dark:text-white font-medium">{{ $currentSession->ip_address }}</div>
            </div>
            
            <div class="space-y-2">
                <div class="text-slate-500 dark:text-slate-400 text-sm">শেষ কার্যকলাপ</div>
                <div class="text-slate-900 dark:text-white font-medium">{{ $currentSession->last_activity_human }}</div>
            </div>
            
            <div class="space-y-2">
                <div class="text-slate-500 dark:text-slate-400 text-sm">ডিভাইস ধরন</div>
                <div class="text-slate-900 dark:text-white font-medium">
                    @if($currentSession->device_type === 'mobile')
                        <i class="fas fa-mobile-alt text-blue-500 mr-2"></i>মোবাইল
                    @elseif($currentSession->device_type === 'tablet')
                        <i class="fas fa-tablet-alt text-blue-500 mr-2"></i>ট্যাবলেট
                    @else
                        <i class="fas fa-desktop text-blue-500 mr-2"></i>ডেস্কটপ
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Other Devices -->
    <div class="glass-effect rounded-xl p-6 border border-white/20">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-slate-900 dark:text-white flex items-center">
                <i class="fas fa-devices text-blue-500 mr-3"></i>
                অন্যান্য ডিভাইস
            </h2>
            
            @if($otherSessions->count() > 0)
            <form method="POST" action="{{ route('devices.revoke.all') }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        onclick="return confirm('আপনি কি নিশ্চিত যে সকল ডিভাইস থেকে লগআউট করতে চান?')"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition-all duration-300 ray-hover">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    সকল ডিভাইস থেকে লগআউট
                </button>
            </form>
            @endif
        </div>

        @if($otherSessions->count() > 0)
            <div class="space-y-4">
                @foreach($otherSessions as $session)
                <div class="bg-white/5 dark:bg-slate-800/30 rounded-xl p-4 border border-white/10 dark:border-slate-700/50">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="space-y-1">
                                <div class="text-slate-500 dark:text-slate-400 text-sm">ডিভাইস</div>
                                <div class="text-slate-900 dark:text-white font-medium text-sm">{{ $session->device_info }}</div>
                            </div>
                            
                            <div class="space-y-1">
                                <div class="text-slate-500 dark:text-slate-400 text-sm">অবস্থান</div>
                                <div class="text-slate-900 dark:text-white font-medium text-sm flex items-center">
                                    <i class="fas fa-map-marker-alt text-blue-500 mr-1 text-xs"></i>
                                    {{ $session->location }}
                                </div>
                            </div>
                            
                            <div class="space-y-1">
                                <div class="text-slate-500 dark:text-slate-400 text-sm">শেষ কার্যকলাপ</div>
                                <div class="text-slate-900 dark:text-white font-medium text-sm">{{ $session->last_activity_human }}</div>
                            </div>
                            
                            <div class="space-y-1">
                                <div class="text-slate-500 dark:text-slate-400 text-sm">স্ট্যাটাস</div>
                                <div class="font-medium text-sm">
                                    @if($session->is_active)
                                        <span class="text-green-500 dark:text-green-400">
                                            <i class="fas fa-circle text-xs mr-1"></i>
                                            সক্রিয়
                                        </span>
                                    @else
                                        <span class="text-slate-400">
                                            <i class="fas fa-circle text-xs mr-1"></i>
                                            নিষ্ক্রিয়
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="ml-4">
                            <form method="POST" action="{{ route('devices.revoke', $session->session_id) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('আপনি কি এই ডিভাইস থেকে লগআউট করতে চান?')"
                                        class="bg-red-100 dark:bg-red-900/20 hover:bg-red-500 text-red-600 dark:text-red-400 hover:text-white px-3 py-2 rounded-xl text-sm font-medium transition-all duration-300 ray-hover border border-red-200 dark:border-red-800">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <div class="text-slate-400 mb-2">
                    <i class="fas fa-devices text-4xl mb-4 opacity-50"></i>
                </div>
                <p class="text-slate-500 dark:text-slate-400">কোন অতিরিক্ত ডিভাইস পাওয়া যায়নি।</p>
                <p class="text-slate-400 text-sm mt-1">আপনি শুধুমাত্র এই ডিভাইস থেকে লগইন আছেন।</p>
            </div>
        @endif
    </div>

    <!-- Security Notice -->
    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4">
        <div class="flex items-start">
            <i class="fas fa-shield-alt text-yellow-600 dark:text-yellow-400 mr-3 mt-1"></i>
            <div>
                <h3 class="text-yellow-800 dark:text-yellow-400 font-medium mb-1">নিরাপত্তা তথ্য</h3>
                <p class="text-yellow-700 dark:text-yellow-200 text-sm leading-relaxed">
                    যদি আপনি কোন অপরিচিত ডিভাইস বা লোকেশন দেখতে পান, তাহলে অবিলম্বে সেই ডিভাইস থেকে লগআউট করুন এবং আপনার পাসওয়ার্ড পরিবর্তন করুন।
                    আমরা আপনার নিরাপত্তার জন্য সর্বোচ্চ গুরুত্ব দিয়ে থাকি।
                </p>
            </div>
        </div>
    </div>
</div>
@endsection