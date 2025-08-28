@extends('layouts.latest.instructor')

@section('title', $student->name . ' - Student Profile')

@section('style')
<style>
.profile-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem 0;
    margin-bottom: 2rem;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 5px solid rgba(255,255,255,0.2);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.info-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.info-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.12);
}

.course-card {
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    transition: all 0.3s ease;
    overflow: hidden;
}

.course-card:hover {
    border-color: #667eea;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.1);
}

.course-thumbnail {
    width: 80px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
}

.status-badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-weight: 500;
}

.grant-btn {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    color: white;
    border: none;
    border-radius: 25px;
    padding: 0.5rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.grant-btn:hover {
    background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(72, 187, 120, 0.4);
    color: white;
}

.stats-item {
    text-align: center;
    padding: 1rem;
    border-radius: 10px;
    background: rgba(102, 126, 234, 0.1);
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Profile Header -->
    <div class="profile-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-auto">
                    <img src="{{ $student->avatar ? asset($student->avatar) : asset('assets/images/default-avatar.png') }}" 
                         alt="{{ $student->name }}" 
                         class="profile-avatar">
                </div>
                <div class="col">
                    <h1 class="mb-1">{{ $student->name }}</h1>
                    <p class="mb-2 opacity-90">
                        <i class="fas fa-envelope me-2"></i>{{ $student->email }}
                    </p>
                    <p class="mb-0 opacity-75">
                        <i class="fas fa-calendar me-2"></i>
                        যোগদান: {{ $student->created_at->format('F d, Y') }}
                    </p>
                </div>
                <div class="col-auto">
                    <a href="{{ route('instructor.students') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left me-2"></i> শিক্ষার্থী তালিকায় ফিরুন
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="row">
            <!-- Statistics Cards -->
            <div class="col-12 mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="info-card">
                            <div class="card-body stats-item">
                                <h3 class="text-primary mb-1">{{ $student->enrollments->count() }}</h3>
                                <p class="mb-0 text-muted">আমার কোর্সে এনরোলড</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-card">
                            <div class="card-body stats-item">
                                <h3 class="text-success mb-1">{{ $student->enrollments->where('status', 'approved')->count() }}</h3>
                                <p class="mb-0 text-muted">অনুমোদিত কোর্স</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-card">
                            <div class="card-body stats-item">
                                <h3 class="text-info mb-1">{{ $availableCourses->count() }}</h3>
                                <p class="mb-0 text-muted">উপলব্ধ কোর্স</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enrolled Courses -->
            <div class="col-lg-6 mb-4">
                <div class="card info-card">
                    <div class="card-header bg-transparent border-0 py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-graduation-cap me-2 text-primary"></i>
                            এনরোলড কোর্স ({{ $student->enrollments->count() }})
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($student->enrollments->count() > 0)
                            <div class="row g-3">
                                @foreach($student->enrollments as $enrollment)
                                    <div class="col-12">
                                        <div class="course-card p-3">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset($enrollment->course->thumbnail) }}" 
                                                     alt="{{ $enrollment->course->title }}" 
                                                     class="course-thumbnail me-3">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">{{ $enrollment->course->title }}</h6>
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        @if($enrollment->status == 'approved')
                                                            <span class="status-badge bg-success text-white">
                                                                <i class="fas fa-check me-1"></i>অনুমোদিত
                                                            </span>
                                                        @elseif($enrollment->status == 'pending')
                                                            <span class="status-badge bg-warning text-dark">
                                                                <i class="fas fa-clock me-1"></i>অপেক্ষমাণ
                                                            </span>
                                                        @elseif($enrollment->status == 'rejected')
                                                            <span class="status-badge bg-danger text-white">
                                                                <i class="fas fa-times me-1"></i>প্রত্যাখ্যাত
                                                            </span>
                                                        @endif
                                                        
                                                        @if($enrollment->amount == 0)
                                                            <span class="status-badge bg-info text-white">
                                                                <i class="fas fa-gift me-1"></i>ফ্রি
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <small class="text-muted">
                                                        এনরোল: {{ $enrollment->created_at->format('M d, Y') }}
                                                        @if($enrollment->amount > 0)
                                                            | পেমেন্ট: ৳{{ number_format($enrollment->amount, 2) }}
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                            
                                            @if($enrollment->admin_notes)
                                                <div class="mt-2 pt-2 border-top">
                                                    <small class="text-muted">
                                                        <i class="fas fa-sticky-note me-1"></i>
                                                        {{ $enrollment->admin_notes }}
                                                    </small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                                <p class="text-muted">এখনও আপনার কোনো কোর্সে এনরোল হননি</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Available Courses (Grant Access) -->
            <div class="col-lg-6 mb-4">
                <div class="card info-card">
                    <div class="card-header bg-transparent border-0 py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-gift me-2 text-success"></i>
                            ফ্রি অ্যাক্সেস দিন ({{ $availableCourses->count() }})
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($availableCourses->count() > 0)
                            <div class="row g-3">
                                @foreach($availableCourses as $course)
                                    <div class="col-12">
                                        <div class="course-card p-3">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset($course->thumbnail) }}" 
                                                     alt="{{ $course->title }}" 
                                                     class="course-thumbnail me-3">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">{{ $course->title }}</h6>
                                                    <p class="text-success mb-2 fw-semibold">
                                                        ৳{{ number_format($course->offer_price ?? $course->price, 2) }}
                                                    </p>
                                                    <button class="btn grant-btn btn-sm" 
                                                            onclick="grantCourseAccess({{ $course->id }}, '{{ $course->title }}')">
                                                        <i class="fas fa-gift me-1"></i>
                                                        ফ্রি অ্যাক্সেস দিন
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                <p class="text-muted">এই শিক্ষার্থী আপনার সকল কোর্সে এনরোল করেছেন!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Grant Course Access Modal -->
<div class="modal fade" id="grantCourseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0" style="border-radius: 15px;">
            <form id="grantCourseForm">
                @csrf
                <div class="modal-header border-0" style="background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title">
                        <i class="fas fa-gift me-2"></i> কোর্স ফ্রি অ্যাক্সেস প্রদান
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-success">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>{{ $student->name }}</strong> কে 
                        <strong id="selectedCourseName"></strong> 
                        কোর্সে ফ্রি অ্যাক্সেস দিতে চান?
                    </div>
                    
                    <input type="hidden" name="user_id" value="{{ $student->id }}">
                    <input type="hidden" name="course_id" id="selectedCourseId">
                    
                    <div class="form-group">
                        <label for="courseAdminNotes" class="form-label fw-semibold">নোট (ঐচ্ছিক)</label>
                        <textarea name="admin_notes" id="courseAdminNotes" class="form-control" rows="3" 
                                  placeholder="ফ্রি অ্যাক্সেস প্রদানের কারণ উল্লেখ করুন..."></textarea>
                        <small class="form-text text-muted">
                            উদাহরণ: "ভাল পারফরমেন্সের জন্য পুরস্কার", "বৃত্তি প্রাপক", ইত্যাদি
                        </small>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        বাতিল
                    </button>
                    <button type="submit" class="btn grant-btn">
                        <i class="fas fa-gift me-2"></i> ফ্রি অ্যাক্সেস প্রদান
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function grantCourseAccess(courseId, courseTitle) {
    document.getElementById('selectedCourseId').value = courseId;
    document.getElementById('selectedCourseName').textContent = courseTitle;
    document.getElementById('courseAdminNotes').value = '';
    new bootstrap.Modal(document.getElementById('grantCourseModal')).show();
}

document.getElementById('grantCourseForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> প্রক্রিয়াকরণ...';
    submitBtn.disabled = true;
    
    fetch('{{ route("instructor.grant-free-access") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            const alert = document.createElement('div');
            alert.className = 'alert alert-success alert-dismissible fade show';
            alert.innerHTML = `
                <i class="fas fa-check-circle me-2"></i>
                ${data.message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.querySelector('.container-fluid').prepend(alert);
            
            // Close modal and reload page
            bootstrap.Modal.getInstance(document.getElementById('grantCourseModal')).hide();
            setTimeout(() => location.reload(), 1500);
        } else {
            throw new Error(data.error || 'Unknown error occurred');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ ' + (error.message || 'ফ্রি অ্যাক্সেস প্রদানে সমস্যা হয়েছে। আবার চেষ্টা করুন।'));
    })
    .finally(() => {
        // Reset button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});
</script>
@endsection