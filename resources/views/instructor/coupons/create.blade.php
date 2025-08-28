@extends('layouts.latest.instructor')

@section('title')
Create Coupon
@endsection

{{-- page style @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
@endsection
{{-- page style @E --}}

{{-- page content @S --}}
@section('content')
<main class="course-create-step-page-wrap">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-7">
                <form action="{{ route('instructor.coupons.store') }}" method="POST">
                    @csrf
                    {{-- error message --}}
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    <div class="content-settings-form-wrap">
                        <h4>Create New Coupon</h4>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input id="name" name="name" class="form-control" type="text"
                                        value="{{ old('name') }}" required>
                                    <label for="name">Coupon Name</label>
                                    <span class="invalid-feedback">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input id="code" name="code" class="form-control" type="text"
                                            value="{{ old('code') }}" style="text-transform: uppercase;">
                                        <button type="button" class="btn btn-outline-secondary" id="generateCode">
                                            Generate
                                        </button>
                                    </div>
                                    <label for="code">Coupon Code (auto-generated if empty)</label>
                                    <span class="invalid-feedback">
                                        @error('code')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <textarea id="description" name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                            <label for="description">Description (optional)</label>
                            <span class="invalid-feedback">
                                @error('description')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select id="type" name="type" class="form-control" required>
                                        <option value="">Select Discount Type</option>
                                        <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>
                                            Percentage (%)
                                        </option>
                                        <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>
                                            Fixed Amount ($)
                                        </option>
                                    </select>
                                    <label for="type">Discount Type</label>
                                    <span class="invalid-feedback">
                                        @error('type')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-text" id="valuePrefix">$</span>
                                        <input id="value" name="value" class="form-control" type="number"
                                            value="{{ old('value') }}" min="0" step="0.01" required>
                                    </div>
                                    <label for="value">Discount Value</label>
                                    <span class="invalid-feedback">
                                        @error('value')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <select id="applicable_courses" name="applicable_courses[]" class="form-control" multiple>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" 
                                            {{ in_array($course->id, old('applicable_courses', [])) ? 'selected' : '' }}>
                                        {{ $course->title }} - ${{ number_format($course->offer_price ?? $course->price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="applicable_courses">Applicable Courses (leave empty for all)</label>
                            <span class="invalid-feedback">
                                @error('applicable_courses')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input id="usage_limit" name="usage_limit" class="form-control" type="number"
                                        value="{{ old('usage_limit', 1) }}" min="1" required>
                                    <label for="usage_limit">Usage Limit</label>
                                    <span class="invalid-feedback">
                                        @error('usage_limit')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input id="valid_from" name="valid_from" class="form-control" type="datetime-local"
                                        value="{{ old('valid_from') }}" required>
                                    <label for="valid_from">Valid From</label>
                                    <span class="invalid-feedback">
                                        @error('valid_from')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input id="valid_until" name="valid_until" class="form-control" type="datetime-local"
                                        value="{{ old('valid_until') }}" required>
                                    <label for="valid_until">Valid Until</label>
                                    <span class="invalid-feedback">
                                        @error('valid_until')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Activate coupon immediately
                            </label>
                        </div>

                        <div class="form-footer">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('instructor.coupons.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Create Coupon
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
{{-- page content @E --}}

{{-- page script @S --}}
@section('script')
<script>
$(document).ready(function() {
    // Generate random code
    $('#generateCode').click(function() {
        const code = Math.random().toString(36).substring(2, 10).toUpperCase();
        $('#code').val(code);
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

    // Set default dates
    const now = new Date();
    const nextWeek = new Date(now.getTime() + 7 * 24 * 60 * 60 * 1000);
    
    if (!$('#valid_from').val()) {
        $('#valid_from').val(now.toISOString().slice(0, 16));
    }
    if (!$('#valid_until').val()) {
        $('#valid_until').val(nextWeek.toISOString().slice(0, 16));
    }

    // Form validation
    $('form').on('submit', function(e) {
        const startDate = new Date($('#valid_from').val());
        const endDate = new Date($('#valid_until').val());
        
        if (endDate <= startDate) {
            alert('End date must be after start date');
            e.preventDefault();
            return false;
        }
        
        if ($('#type').val() === 'percentage') {
            const percentage = parseFloat($('#value').val());
            if (percentage > 100) {
                alert('Percentage discount cannot exceed 100%');
                e.preventDefault();
                return false;
            }
        }
    });
});
</script>
@endsection
{{-- page script @E --}}