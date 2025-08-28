@extends('layouts.latest.instructor')
@section('title')
    Course Create - Step 7
@endsection
{{-- page style @S --}}
@section('style')
    <link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
    <main class="course-create-step-page-wrap">
        <div class="container-fluid">
            <div class="row justify-content-center position-relative">
                <div class="col-12 col-md-10 col-lg-8 col-xl-7">
                    {{-- course step --}}
                    <div class="course-create-step-wrap">
                        
                        <div class="step-box active">
                            <span class="circle">
                                <img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                                    class="img-fluid">
                            </span>
                            <p><a
                                    href="{{ url('instructor/courses/create', optional(request())->route('id')) . '/facts' }}">Facts</a>
                            </p>
                        </div>
                        <div class="step-box active">
                            <span class="circle"><img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                                    class="img-fluid"></span>
                            <p><a
                                    href="{{ url('instructor/courses/create', optional(request())->route('id')) . '/objects' }}">Objects</a>
                            </p>
                        </div>
                        <div class="step-box current">
                            <span class="circle"></span>
                            <p><a
                                    href="{{ url('instructor/courses/create', optional(request())->route('id')) . '/price' }}">Price</a>
                            </p>
                        </div>
                        <div class="step-box">
                            <span class="circle"></span>
                            <p><a
                                    href="{{ url('instructor/courses/create', optional(request())->route('id')) . '/design' }}">Design</a>
                            </p>
                        </div>
                        <div class="step-box">
                            <span class="circle">
                                <img src="{{ asset('assets/images/icons/check-mark.svg') }}" alt="icon"
                                    class="img-fluid">
                            </span>
                            <p><a
                                    href="{{ url('instructor/courses/create', optional(request())->route('id')).'/content' }}">Contents</a>
                            </p>
                        </div>
                        
                        <div class="step-box">
                            <span class="circle"></span>
                            <p><a
                                    href="{{ url('instructor/courses/create', optional(request())->route('id')) . '/certificate' }}">Certificate</a>
                            </p>
                        </div>
                        <div class="step-box">
                            <span class="circle"></span>
                            <p><a
                                    href="{{ url('instructor/courses/create', optional(request())->route('id')) . '/visibility' }}">Visibility</a>
                            </p>
                        </div>
                        <div class="step-box">
                            <span class="circle"></span>
                            <p><a
                                    href="{{ url('instructor/courses/create', optional(request())->route('id')) . '/share' }}">Share</a>
                            </p>
                        </div>
                    </div>
                    {{-- course step --}}

                    @if ( session()->has('course_id') )
                        @include('e-learning.course.instructor.create.save-finish')
                    @endif
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8 col-xl-7">
                    <form action="" method="POST">
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
                        {{-- error message --}}
                        <div class="content-settings-form-wrap">
                            <h4>Select Price</h4>
                            <div class="form-group d-flex align-items-center justify-content-between">
                                <h6>Make this course free</h6>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_free" role="switch"
                                        id="freeCourseSwitch" {{ (old('is_free') || $course->price == 0) ? 'checked' : '' }}>
                                </div>
                            </div>
                            <div class="form-group" id="priceGroup">
                                <input id="price" class="form-control" name="price"
                                    value="{{ $course->price ? $course->price : old('price') }}" type="text">
                                <label for="price">Regular Price</label>
                                <span class="euro">৳</span>
                                <span class="invalid-feedback d-block">
                                    @error('price')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group" id="offerPriceGroup">
                                <input id="offer_price" class="form-control" name="offer_price"
                                    value="{{ $course->offer_price ? $course->offer_price : old('offer_price') }}"
                                    type="text">
                                <label for="offer_price">Sales Price</label>
                                <span class="euro">৳</span>
                                <span class="invalid-feedback d-block">
                                    @error('offer_price')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>

                        {{-- step next bttns --}}
                        <div class="back-next-bttns">
                            <a href="{{ url('instructor/courses/create/' . request()->route('id') . '/objects') }}">Back</a>
                            <button class="btn btn-primary" type="submit">Next</button>
                        </div>
                        {{-- step next bttns --}}
                    </form>
                </div>
            </div>
    </main>
@endsection
{{-- page content @E --}}

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const freeCourseSwitch = document.getElementById('freeCourseSwitch');
    const priceGroup = document.getElementById('priceGroup');
    const offerPriceGroup = document.getElementById('offerPriceGroup');
    const priceInput = document.getElementById('price');
    const offerPriceInput = document.getElementById('offer_price');

    function togglePriceFields() {
        if (freeCourseSwitch.checked) {
            priceGroup.style.display = 'none';
            offerPriceGroup.style.display = 'none';
            priceInput.value = '0';
            offerPriceInput.value = '';
        } else {
            priceGroup.style.display = 'block';
            offerPriceGroup.style.display = 'block';
            if (priceInput.value === '0') {
                priceInput.value = '';
            }
        }
    }

    // Initialize on page load
    togglePriceFields();

    freeCourseSwitch.addEventListener('change', togglePriceFields);
});
</script>
@endsection
