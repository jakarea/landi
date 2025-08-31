@extends('layouts.latest.instructor')

@section('title', 'Edit Coupon')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Edit Coupon</h4>
                    <div>
                        <a href="{{ route('instructor.coupons.show', $coupon) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('instructor.coupons') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('instructor.coupons.update', $coupon) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Coupon Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $coupon->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code" class="form-label">Coupon Code</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="{{ $coupon->code }}" readonly>
                                        <button type="button" class="btn btn-outline-secondary copy-code" 
                                                data-code="{{ $coupon->code }}" title="Copy to clipboard">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted">Coupon code cannot be changed after creation</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $coupon->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type" class="form-label">Discount Type *</label>
                                    <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                        <option value="">Select Type</option>
                                        <option value="percentage" {{ old('type', $coupon->type) === 'percentage' ? 'selected' : '' }}>
                                            Percentage (%)
                                        </option>
                                        <option value="fixed" {{ old('type', $coupon->type) === 'fixed' ? 'selected' : '' }}>
                                            Fixed Amount ($)
                                        </option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="value" class="form-label">Discount Value *</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="valuePrefix">
                                            {{ $coupon->type === 'percentage' ? '%' : '$' }}
                                        </span>
                                        <input type="number" class="form-control @error('value') is-invalid @enderror" 
                                               id="value" name="value" value="{{ old('value', $coupon->value) }}" 
                                               min="0" step="0.01" required
                                               {{ $coupon->type === 'percentage' ? 'max=100' : '' }}>
                                    </div>
                                    @error('value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="applicable_courses" class="form-label">Applicable Courses</label>
                            <select class="form-select @error('applicable_courses') is-invalid @enderror" 
                                    id="applicable_courses" name="applicable_courses[]" multiple>
                                <option value="">Select courses (leave empty for all courses)</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" 
                                            {{ in_array($course->id, old('applicable_courses', $coupon->applicable_courses ?? [])) ? 'selected' : '' }}>
                                        {{ $course->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('applicable_courses')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Leave empty to apply to all your courses</small>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="usage_limit" class="form-label">Usage Limit *</label>
                                    <input type="number" class="form-control @error('usage_limit') is-invalid @enderror" 
                                           id="usage_limit" name="usage_limit" 
                                           value="{{ old('usage_limit', $coupon->usage_limit) }}" 
                                           min="{{ $coupon->used_count }}" required>
                                    @error('usage_limit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">
                                        Already used: {{ $coupon->used_count }} times. 
                                        Minimum limit: {{ $coupon->used_count }}
                                    </small>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="valid_from" class="form-label">Valid From *</label>
                                    <input type="datetime-local" class="form-control @error('valid_from') is-invalid @enderror" 
                                           id="valid_from" name="valid_from" 
                                           value="{{ old('valid_from', $coupon->valid_from->format('Y-m-d\TH:i')) }}" required>
                                    @error('valid_from')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="valid_until" class="form-label">Valid Until *</label>
                                    <input type="datetime-local" class="form-control @error('valid_until') is-invalid @enderror" 
                                           id="valid_until" name="valid_until" 
                                           value="{{ old('valid_until', $coupon->valid_until->format('Y-m-d\TH:i')) }}" required>
                                    @error('valid_until')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                       {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Keep coupon active
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash"></i> Delete Coupon
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Coupon
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this coupon?</p>
                <p><strong>Coupon Code:</strong> {{ $coupon->code }}</p>
                <p><strong>Used Count:</strong> {{ $coupon->used_count }} times</p>
                <p class="text-danger">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('instructor.coupons.destroy', $coupon) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
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

    // Update prefix based on discount type
    $('#type').change(function() {
        const prefix = $('#valuePrefix');
        if ($(this).val() === 'percentage') {
            prefix.text('%');
            $('#value').attr('max', '100');
        } else {
            prefix.text('$');
            $('#value').removeAttr('max');
        }
    });

    // Initialize Select2 for courses
    $('#applicable_courses').select2({
        placeholder: 'Select courses (leave empty for all courses)',
        allowClear: true
    });
});
</script>
@endsection