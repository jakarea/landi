@extends('layouts.student-modern')
@section('title', 'আমার নোটিফিকেশন')

@section('style')
<style>
/* Modern notification styles */
.notification-card {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0.02) 100%);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    backdrop-filter: blur(20px);
    transition: all 0.3s ease;
}

.notification-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    border-color: rgba(59, 130, 246, 0.3);
}

.notification-unread {
    border-left: 4px solid #3B82F6;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%);
}

.notification-read {
    opacity: 0.7;
}

.notification-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.notification-icon.success {
    background: linear-gradient(135deg, #10B981, #059669);
    color: white;
}

.notification-icon.warning {
    background: linear-gradient(135deg, #F59E0B, #D97706);
    color: white;
}

.notification-icon.danger {
    background: linear-gradient(135deg, #EF4444, #DC2626);
    color: white;
}

.notification-icon.info {
    background: linear-gradient(135deg, #3B82F6, #2563EB);
    color: white;
}

.empty-state {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(16, 185, 129, 0.1) 100%);
    border: 2px dashed rgba(59, 130, 246, 0.3);
    border-radius: 16px;
    padding: 3rem;
    text-align: center;
}

.btn-mark-read {
    background: linear-gradient(135deg, #6366F1, #4F46E5);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.btn-mark-read:hover {
    background: linear-gradient(135deg, #4F46E5, #4338CA);
    transform: translateY(-1px);
}

.filter-buttons .btn {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #94A3B8;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.filter-buttons .btn.active {
    background: linear-gradient(135deg, #3B82F6, #2563EB);
    color: white;
    border-color: #3B82F6;
}

.filter-buttons .btn:hover {
    background: rgba(255, 255, 255, 0.15);
    color: white;
}
</style>
@endsection

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 text-white">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold mb-2">নোটিফিকেশন</h1>
                    <p class="text-slate-400">আপনার সকল আপডেট এবং বার্তা</p>
                </div>

                @if($notifications->count() > 0)
                <div class="flex gap-3">
                    <button onclick="markAllAsRead()" class="btn-mark-read">
                        <i class="fas fa-check-double mr-2"></i>
                        সব পড়া হয়েছে বলে চিহ্নিত করুন
                    </button>
                </div>
                @endif
            </div>

            <!-- Filter Buttons -->
            <div class="flex gap-3 mt-6 filter-buttons">
                <button class="btn active" onclick="filterNotifications('all')">
                    <i class="fas fa-list mr-2"></i>সকল
                </button>
                <button class="btn" onclick="filterNotifications('unread')">
                    <i class="fas fa-envelope mr-2"></i>অপঠিত
                </button>
                <button class="btn" onclick="filterNotifications('enrollment')">
                    <i class="fas fa-graduation-cap mr-2"></i>এনরোলমেন্ট
                </button>
            </div>
        </div>

        @if($notifications->count() > 0)
            <!-- Notifications List -->
            <div class="space-y-4">
                @foreach($notifications as $notification)
                    <div class="notification-card p-6 {{ $notification->status == 'unseen' ? 'notification-unread' : 'notification-read' }}"
                         data-status="{{ $notification->status }}"
                         data-type="{{ $notification->type }}">
                        <div class="flex items-start gap-4">
                            <!-- Notification Icon -->
                            <div class="notification-icon {{ $notification->type == 'enrollment_approved' ? 'success' : ($notification->type == 'enrollment_declined' ? 'danger' : 'info') }}">
                                @if($notification->type == 'enrollment_approved')
                                    <i class="fas fa-check-circle"></i>
                                @elseif($notification->type == 'enrollment_declined')
                                    <i class="fas fa-times-circle"></i>
                                @else
                                    <i class="fas fa-bell"></i>
                                @endif
                            </div>

                            <!-- Notification Content -->
                            <div class="flex-1">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h3 class="font-semibold text-lg mb-2">
                                            @if($notification->type == 'enrollment_approved')
                                                <span class="text-green-400">এনরোলমেন্ট অনুমোদিত</span>
                                            @elseif($notification->type == 'enrollment_declined')
                                                <span class="text-red-400">এনরোলমেন্ট প্রত্যাখ্যান</span>
                                            @else
                                                <span class="text-blue-400">নতুন আপডেট</span>
                                            @endif
                                        </h3>

                                        <p class="text-slate-300 mb-3">{{ $notification->message }}</p>

                                        <div class="flex items-center gap-4 text-sm text-slate-400">
                                            <span>
                                                <i class="fas fa-clock mr-1"></i>
                                                {{ $notification->created_at->diffForHumans() }}
                                            </span>
                                            @if($notification->course_id)
                                                @php
                                                    $course = App\Models\Course::find($notification->course_id);
                                                @endphp
                                                @if($course)
                                                    <span>
                                                        <i class="fas fa-book mr-1"></i>
                                                        {{ $course->title }}
                                                    </span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex gap-2">
                                        @if($notification->status == 'unseen')
                                            <button onclick="markAsRead({{ $notification->id }})"
                                                    class="text-blue-400 hover:text-blue-300 p-2 rounded-lg hover:bg-blue-400/10 transition-all duration-300"
                                                    title="পড়া হয়েছে বলে চিহ্নিত করুন">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif

                                        @if($notification->type == 'enrollment_approved' && $notification->course_id)
                                            @php
                                                $course = App\Models\Course::find($notification->course_id);
                                            @endphp
                                            @if($course)
                                                <a href="{{ route('student.courses.learn', $course->slug) }}"
                                                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-300 flex items-center gap-2">
                                                    <i class="fas fa-play"></i>
                                                    কোর্স শুরু করুন
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($notifications->hasPages())
                <div class="mt-8">
                    {{ $notifications->links('pagination::tailwind') }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gradient-to-r from-blue-500 to-green-500 flex items-center justify-center">
                    <i class="fas fa-bell-slash text-3xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">কোনো নোটিফিকেশন নেই</h3>
                <p class="text-slate-400 mb-6">আপনার কোনো নতুন আপডেট বা বার্তা নেই।</p>
                <a href="{{ route('student.courses') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-all duration-300">
                    <i class="fas fa-graduation-cap"></i>
                    কোর্স দেখুন
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@section('script')
<script>
// Filter notifications
function filterNotifications(type) {
    const notifications = document.querySelectorAll('.notification-card');
    const buttons = document.querySelectorAll('.filter-buttons .btn');

    // Update button states
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');

    // Filter notifications
    notifications.forEach(notification => {
        if (type === 'all') {
            notification.style.display = 'block';
        } else if (type === 'unread') {
            notification.style.display = notification.dataset.status === 'unseen' ? 'block' : 'none';
        } else if (type === 'enrollment') {
            notification.style.display = notification.dataset.type.includes('enrollment') ? 'block' : 'none';
        }
    });
}

// Mark single notification as read
function markAsRead(notificationId) {
    fetch(`/student/notifications/${notificationId}/mark-read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const notification = document.querySelector(`[data-id="${notificationId}"]`);
            if (notification) {
                notification.classList.remove('notification-unread');
                notification.classList.add('notification-read');
                notification.dataset.status = 'seen';

                // Remove mark as read button
                const markReadBtn = notification.querySelector('button[onclick*="markAsRead"]');
                if (markReadBtn) {
                    markReadBtn.remove();
                }
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Mark all notifications as read
function markAllAsRead() {
    fetch('/student/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update all notifications to read state
            const notifications = document.querySelectorAll('.notification-unread');
            notifications.forEach(notification => {
                notification.classList.remove('notification-unread');
                notification.classList.add('notification-read');
                notification.dataset.status = 'seen';
            });

            // Remove all mark as read buttons
            const markReadBtns = document.querySelectorAll('button[onclick*="markAsRead"]');
            markReadBtns.forEach(btn => btn.remove());

            // Hide the mark all as read button
            const markAllBtn = document.querySelector('button[onclick="markAllAsRead()"]');
            if (markAllBtn) {
                markAllBtn.style.display = 'none';
            }

            // Show success message
            showToast('সকল নোটিফিকেশন পড়া হয়েছে বলে চিহ্নিত করা হয়েছে।', 'success');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('কিছু ভুল হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।', 'error');
    });
}

// Simple toast notification
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg text-white font-semibold ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
    toast.textContent = message;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>
@endsection