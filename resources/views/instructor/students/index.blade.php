@extends('layouts.latest.instructor')

@section('title', 'Students Management')
@php
    use Illuminate\Support\Str;
@endphp
@section('style')
<style>
.student-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    overflow: hidden;
}

.student-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.student-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #e2e8f0;
}

.enrollment-badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 20px;
}

.grant-access-btn {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    color: white;
    border: none;
    border-radius: 25px;
    padding: 0.5rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.grant-access-btn:hover {
    background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(72, 187, 120, 0.4);
    color: white;
}

.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem 0;
    margin-bottom: 2rem;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

/* Bootstrap 5 Pagination Custom Styles */
.pagination {
    margin: 0;
}

.page-link {
    color: #667eea;
    border: 1px solid #e2e8f0;
    padding: 0.75rem 1rem;
    margin: 0 2px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.page-link:hover {
    color: #5a67d8;
    background-color: #f7fafc;
    border-color: #cbd5e0;
    transform: translateY(-1px);
}

.page-item.active .page-link {
    background-color: #667eea;
    border-color: #667eea;
    color: white;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.page-item.disabled .page-link {
    color: #a0aec0;
    background-color: #f7fafc;
    border-color: #e2e8f0;
}

.pagination-info {
    color: #718096;
    font-size: 0.875rem;
}

.pagination-wrapper {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid #e2e8f0;
}

.pagination-wrapper .gap-2 {
    gap: 0.5rem !important;
}

@media (max-width: 576px) {
    .pagination-info {
        font-size: 0.75rem;
    }
    
    .page-link {
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
    }
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1"><i class="fas fa-users me-2"></i> শিক্ষার্থী ব্যবস্থাপনা</h2>
                    <p class="mb-0 opacity-90">শিক্ষার্থীদের প্রোফাইল দেখুন এবং ফ্রি অ্যাক্সেস প্রদান করুন</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Search Form -->
                <div class="card student-card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('instructor.students') }}">
                            <div class="row align-items-end">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="search" class="form-label fw-semibold">শিক্ষার্থী খুঁজুন</label>
                                        <input type="text" name="search" id="search" class="form-control" 
                                               value="{{ request('search') }}" 
                                               placeholder="নাম বা ইমেইল দিয়ে খুঁজুন...">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search me-2"></i> খুঁজুন
                                        </button>
                                        @if(request('search'))
                                            <a href="{{ route('instructor.students') }}" class="btn btn-outline-secondary">
                                                <i class="fas fa-times me-2"></i> রিসেট
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @if($students->count() > 0)
                    <div class="row">
                        @foreach($students as $student)
                            <div class="col-12 col-md-6 col-lg-4 mb-4">
                                <div class="card student-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img src="{{ $student->avatar ? asset($student->avatar) : asset('assets/images/default-avatar.png') }}" 
                                                 alt="{{ $student->name }}" 
                                                 class="student-avatar me-3">
                                            <div class="flex-grow-1">
                                                <h5 class="mb-1">{{ $student->name }}</h5>
                                                <p class="text-muted mb-0">{{ $student->email }}</p>
                                            </div>
                                        </div>

                                        <!-- Enrollment Status -->
                                        <div class="mb-3">
                                            @if($student->enrollments->count() > 0)
                                                <p class="small fw-semibold text-success mb-2">
                                                    <i class="fas fa-check-circle me-1"></i> 
                                                    {{ $student->enrollments->count() }} টি কোর্সে এনরোল
                                                </p>
                                                <div class="d-flex flex-wrap gap-1">
                                                    @foreach($student->enrollments->take(2) as $enrollment)
                                                        <span class="enrollment-badge bg-success text-white">
                                                            {{ Str::limit($enrollment->course->title, 20) }}
                                                        </span>
                                                    @endforeach
                                                    @if($student->enrollments->count() > 2)
                                                        <span class="enrollment-badge bg-info text-white">
                                                            +{{ $student->enrollments->count() - 2 }} আরও
                                                        </span>
                                                    @endif
                                                </div>
                                            @else
                                                <p class="small text-muted mb-2">
                                                    <i class="fas fa-info-circle me-1"></i> 
                                                    এখনও কোনো কোর্সে এনরোল হননি
                                                </p>
                                            @endif
                                        </div>

                                        <!-- Actions -->
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('instructor.students.profile', $student->id) }}" 
                                               class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-eye me-1"></i> বিস্তারিত
                                            </a>
                                            <button class="btn grant-access-btn btn-sm" 
                                                    onclick="showGrantAccessModal({{ $student->id }}, '{{ $student->name }}')">
                                                <i class="fas fa-gift me-1"></i> ফ্রি অ্যাক্সেস
                                            </button>
                                        </div>

                                        <!-- Profile Info -->
                                        @if($student->created_at)
                                            <div class="mt-3 pt-3 border-top">
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar me-1"></i> 
                                                    যোগদান: {{ $student->created_at->format('M d, Y') }}
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="row">
                        <div class="col-12">
                            {{ $students->links() }}
                        </div>
                    </div>
                @else
                    <div class="card student-card">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-users fa-4x text-muted mb-3"></i>
                            <h4 class="text-dark mb-2">কোনো শিক্ষার্থী পাওয়া যায়নি</h4>
                            @if(request('search'))
                                <p class="text-muted">আপনার অনুসন্ধান "{{ request('search') }}" এর সাথে মিল নেই।</p>
                            @else
                                <p class="text-muted">এখনও কোনো শিক্ষার্থী সিস্টেমে নিবন্ধিত হয়নি।</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Grant Free Access Modal -->
<div class="modal fade" id="grantAccessModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0" style="border-radius: 15px;">
            <form id="grantAccessForm">
                @csrf
                <div class="modal-header border-0" style="background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title">
                        <i class="fas fa-gift me-2"></i> ফ্রি অ্যাক্সেস প্রদান
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong id="studentName"></strong> কে একটি কোর্সে ফ্রি অ্যাক্সেস দিতে চান?
                    </div>
                    
                    <input type="hidden" id="selectedStudentId" name="user_id">
                    
                    <div class="form-group mb-3">
                        <label for="courseSelect" class="form-label fw-semibold">কোর্স নির্বাচন করুন</label>
                        <select name="course_id" id="courseSelect" class="form-select" required>
                            <option value="">-- কোর্স নির্বাচন করুন --</option>
                            @foreach($instructorCourses as $course)
                                <option value="{{ $course->id }}">
                                    {{ $course->title }} 
                                    (৳{{ number_format($course->offer_price ?? $course->price, 2) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="adminNotes" class="form-label fw-semibold">নোট (ঐচ্ছিক)</label>
                        <textarea name="admin_notes" id="adminNotes" class="form-control" rows="3" 
                                  placeholder="ফ্রি অ্যাক্সেস প্রদানের কারণ উল্লেখ করুন..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        বাতিল
                    </button>
                    <button type="submit" class="btn grant-access-btn">
                        <i class="fas fa-gift me-2"></i> ফ্রি অ্যাক্সেস প্রদান
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showGrantAccessModal(studentId, studentName) {
    document.getElementById('selectedStudentId').value = studentId;
    document.getElementById('studentName').textContent = studentName;
    document.getElementById('courseSelect').value = '';
    document.getElementById('adminNotes').value = '';
    new bootstrap.Modal(document.getElementById('grantAccessModal')).show();
}

document.getElementById('grantAccessForm').addEventListener('submit', function(e) {
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
            bootstrap.Modal.getInstance(document.getElementById('grantAccessModal')).hide();
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