@extends('layouts.latest.instructor')

@section('title', 'Coupon Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Coupon Details</h4>
                    <div>
                        <a href="{{ route('instructor.coupons.edit', $coupon) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('instructor.coupons.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Coupon Code:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <span class="badge badge-primary fs-6 p-2">{{ $coupon->code }}</span>
                                    <button class="btn btn-sm btn-outline-secondary copy-code ms-2" 
                                            data-code="{{ $coupon->code }}" title="Copy to clipboard">
                                        <i class="fas fa-copy"></i> Copy
                                    </button>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Name:</strong>
                                </div>
                                <div class="col-sm-9">
                                    {{ $coupon->name }}
                                </div>
                            </div>

                            @if($coupon->description)
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Description:</strong>
                                </div>
                                <div class="col-sm-9">
                                    {{ $coupon->description }}
                                </div>
                            </div>
                            @endif

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Discount:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <span class="badge badge-{{ $coupon->type === 'percentage' ? 'info' : 'warning' }} fs-6 p-2">
                                        @if($coupon->type === 'percentage')
                                            {{ $coupon->value }}% OFF
                                        @else
                                            ${{ number_format($coupon->value, 2) }} OFF
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Usage:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <div class="d-flex align-items-center">
                                        <span class="me-3">{{ $coupon->used_count }} / {{ $coupon->usage_limit }} used</span>
                                        <div class="progress flex-grow-1" style="height: 10px;">
                                            <div class="progress-bar" 
                                                 style="width: {{ ($coupon->used_count / $coupon->usage_limit) * 100 }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Valid Period:</strong>
                                </div>
                                <div class="col-sm-9">
                                    {{ $coupon->valid_from->format('M d, Y g:i A') }} - 
                                    {{ $coupon->valid_until->format('M d, Y g:i A') }}
                                    
                                    @if(now() < $coupon->valid_from)
                                        <span class="badge badge-warning ms-2">Not Started</span>
                                    @elseif(now() > $coupon->valid_until)
                                        <span class="badge badge-danger ms-2">Expired</span>
                                    @else
                                        <span class="badge badge-success ms-2">Active</span>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Status:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <button class="btn btn-sm toggle-status 
                                           {{ $coupon->is_active ? 'btn-success' : 'btn-secondary' }}"
                                            data-id="{{ $coupon->id }}">
                                        {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Applicable Courses:</strong>
                                </div>
                                <div class="col-sm-9">
                                    @if(empty($coupon->applicable_courses))
                                        <span class="text-muted">All your courses</span>
                                    @else
                                        @foreach($coupon->applicable_courses as $courseId)
                                            @php
                                                $course = $coupon->instructor->courses->find($courseId);
                                            @endphp
                                            @if($course)
                                                <span class="badge badge-light me-1">{{ $course->title }}</span>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Created:</strong>
                                </div>
                                <div class="col-sm-9">
                                    {{ $coupon->created_at->format('M d, Y g:i A') }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h5 class="mb-0">Share Coupon</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Shareable Link:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" 
                                                   id="shareableLink" 
                                                   value="{{ url('/') }}?coupon={{ $coupon->code }}" readonly>
                                            <button class="btn btn-outline-secondary copy-link" title="Copy link">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-outline-primary share-social" data-platform="facebook">
                                            <i class="fab fa-facebook"></i> Share on Facebook
                                        </button>
                                        <button class="btn btn-outline-info share-social" data-platform="twitter">
                                            <i class="fab fa-twitter"></i> Share on Twitter
                                        </button>
                                        <button class="btn btn-outline-success share-social" data-platform="whatsapp">
                                            <i class="fab fa-whatsapp"></i> Share on WhatsApp
                                        </button>
                                        <button class="btn btn-outline-secondary share-email">
                                            <i class="fas fa-envelope"></i> Share via Email
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            @if($coupon->isValid())
                            <div class="alert alert-success mt-3">
                                <i class="fas fa-check-circle"></i> This coupon is currently valid and can be used.
                            </div>
                            @else
                            <div class="alert alert-warning mt-3">
                                <i class="fas fa-exclamation-triangle"></i> 
                                This coupon is currently not valid
                                @if(!$coupon->is_active)
                                    (inactive)
                                @elseif(now() < $coupon->valid_from)
                                    (not started yet)
                                @elseif(now() > $coupon->valid_until)
                                    (expired)
                                @elseif($coupon->used_count >= $coupon->usage_limit)
                                    (usage limit reached)
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Copy code to clipboard
    $('.copy-code').click(function() {
        const code = $(this).data('code');
        navigator.clipboard.writeText(code).then(function() {
            toastr.success('Coupon code copied to clipboard!');
        });
    });

    // Copy link to clipboard
    $('.copy-link').click(function() {
        const link = $('#shareableLink').val();
        navigator.clipboard.writeText(link).then(function() {
            toastr.success('Link copied to clipboard!');
        });
    });

    // Toggle status
    $('.toggle-status').click(function() {
        const button = $(this);
        const couponId = button.data('id');
        
        $.ajax({
            url: `/instructor/coupons/${couponId}/toggle-status`,
            type: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    if (response.is_active) {
                        button.removeClass('btn-secondary').addClass('btn-success').text('Active');
                    } else {
                        button.removeClass('btn-success').addClass('btn-secondary').text('Inactive');
                    }
                    toastr.success('Coupon status updated successfully!');
                    setTimeout(() => location.reload(), 1000);
                }
            },
            error: function() {
                toastr.error('Error updating coupon status.');
            }
        });
    });

    // Social sharing
    $('.share-social').click(function() {
        const platform = $(this).data('platform');
        const link = $('#shareableLink').val();
        const text = `Check out this discount coupon: {{ $coupon->code }}`;
        let shareUrl = '';

        switch(platform) {
            case 'facebook':
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(link)}`;
                break;
            case 'twitter':
                shareUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(link)}`;
                break;
            case 'whatsapp':
                shareUrl = `https://wa.me/?text=${encodeURIComponent(text + ' ' + link)}`;
                break;
        }

        if (shareUrl) {
            window.open(shareUrl, '_blank', 'width=600,height=400');
        }
    });

    // Email sharing
    $('.share-email').click(function() {
        const link = $('#shareableLink').val();
        const subject = 'Discount Coupon: {{ $coupon->code }}';
        const body = `I wanted to share this discount coupon with you:\n\nCoupon Code: {{ $coupon->code }}\nLink: ${link}`;
        
        window.location.href = `mailto:?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
    });
});
</script>
@endsection