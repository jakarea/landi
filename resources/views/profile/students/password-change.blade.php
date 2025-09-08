@extends('layouts/student-modern')
@section('title', 'পাসওয়ার্ড পরিবর্তন')

@push('styles')
<style>
    .form-floating {
        position: relative;
    }
    .form-floating input {
        background: rgba(30, 41, 59, 0.5);
        border: 1px solid rgba(148, 163, 184, 0.2);
        color: white;
    }
    .form-floating input:focus {
        background: rgba(30, 41, 59, 0.7);
        border-color: rgba(99, 102, 241, 0.4);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }
    .form-floating label {
        color: rgba(148, 163, 184, 0.8);
    }
    .form-floating input:focus ~ label {
        color: rgba(99, 102, 241, 1);
    }
    .form-floating input:disabled {
        background: rgba(15, 23, 42, 0.3);
        color: rgba(148, 163, 184, 0.8);
    }
    .ray-hover {
        position: relative;
        overflow: hidden;
    }
    .ray-hover::before {
        content: '';
        position: absolute;
        top: -100%;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transform: translateX(-100%) translateY(-100%);
        transition: transform 0.8s ease-in-out;
    }
    .ray-hover:hover::before {
        transform: translateX(200%) translateY(200%);
    }
</style>
@endpush

@section('content')
<div class="p-6 space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white mb-2">পাসওয়ার্ড পরিবর্তন</h1>
            <p class="text-gray-400">আপনার অ্যাকাউন্টের নিরাপত্তার জন্য পাসওয়ার্ড পরিবর্তন করুন</p>
        </div>
        <a href="{{ route('student.profile') }}" 
           class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors flex items-center space-x-2">
            <i class="fas fa-arrow-left"></i>
            <span>ফিরে যান</span>
        </a>
    </div>

    <div class="glass-effect rounded-2xl overflow-hidden">
        <div class="border-b border-gray-600 px-6 py-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-lock text-white"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-white">নিরাপত্তা সেটিংস</h2>
                    <p class="text-sm text-gray-400">আপনার পাসওয়ার্ড পরিবর্তন করুন</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('student.profile.password.update') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div>
                        <div class="form-floating">
                            <input type="email" class="form-control w-full px-4 py-3 rounded-lg" 
                                   id="current-email" value="{{ $user->email }}" disabled>
                            <label for="current-email">বর্তমান ইমেইল</label>
                        </div>
                    </div>
                    
                    <div>
                        <div class="form-floating relative">
                            <input type="password" class="form-control w-full px-4 py-3 rounded-lg pr-12 @error('password') border-red-500 @enderror" 
                                   id="password" name="password" placeholder="নতুন পাসওয়ার্ড" required>
                            <label for="password">নতুন পাসওয়ার্ড</label>
                            <button type="button" onclick="togglePassword('password', 'eye-click')" 
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white">
                                <i class="fas fa-eye" id="eye-click"></i>
                            </button>
                            @error('password')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div>
                        <div class="form-floating relative">
                            <input type="password" class="form-control w-full px-4 py-3 rounded-lg pr-12 @error('password_confirmation') border-red-500 @enderror" 
                                   id="password_confirmation" name="password_confirmation" placeholder="পাসওয়ার্ড নিশ্চিত করুন" required>
                            <label for="password_confirmation">পাসওয়ার্ড নিশ্চিত করুন</label>
                            <button type="button" onclick="togglePassword('password_confirmation', 'eye-click2')" 
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white">
                                <i class="fas fa-eye" id="eye-click2"></i>
                            </button>
                            @error('password_confirmation')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-800 bg-opacity-50 rounded-lg p-4">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400 mt-0.5"></i>
                        </div>
                        <div class="text-sm">
                            <h4 class="text-white font-medium mb-1">পাসওয়ার্ড নিরাপত্তা টিপস:</h4>
                            <ul class="text-gray-300 space-y-1">
                                <li>• কমপক্ষে ৮ অক্ষরের পাসওয়ার্ড ব্যবহার করুন</li>
                                <li>• বড় হাতের ও ছোট হাতের অক্ষর, সংখ্যা এবং বিশেষ চিহ্ন ব্যবহার করুন</li>
                                <li>• সহজ বা অনুমানযোগ্য পাসওয়ার্ড এড়িয়ে চলুন</li>
                                <li>• নিয়মিত পাসওয়ার্ড পরিবর্তন করুন</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4 pt-4">
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-300 ray-hover">
                        <i class="fas fa-save mr-2"></i>
                        পাসওয়ার্ড পরিবর্তন করুন
                    </button>
                    <a href="{{ route('student.profile') }}" 
                       class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        বাতিল
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Password visibility toggle
function togglePassword(fieldId, iconId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(iconId);
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Password strength indicator (optional enhancement)
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            // You can add password strength indicator here if needed
        });
    }
    
    if (confirmPasswordInput) {
        confirmPasswordInput.addEventListener('input', function() {
            const password = passwordInput.value;
            const confirmPassword = this.value;
            
            if (password !== confirmPassword && confirmPassword.length > 0) {
                this.classList.add('border-red-500');
            } else {
                this.classList.remove('border-red-500');
            }
        });
    }
});
</script>
@endpush