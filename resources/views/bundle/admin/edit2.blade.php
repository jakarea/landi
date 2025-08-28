@extends('layouts.latest.admin')
@section('title')
Bundle Course Update
@endsection

{{-- style section @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin-css/user.css') }}" rel="stylesheet" type="text/css" />

<style>

    .image-area{
        position: relative
    }
    #close-button{
        position: absolute;
        right: -10px;
        top: -10px;
        width: 2.2rem;
        height: 2.2rem;
        border-radius: 6px;
        background: #fe251b;
        display: none;
    }

    #close-button i{
        color: #fff
    }
</style>
@endsection
{{-- style section @E --}}

@section('content')

@php
 $adminBundleSelected = [];
 if (session()->has('adminBundleSelected')) {
    $adminBundleSelected = session('adminBundleSelected');

    $selectedCourses = count($adminBundleSelected);

 }
@endphp

<main class="courses-lists-pages">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-7">
                <div class="select-bundle-title mt-0">
                    <h1>Bundle course update</h1>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="select-bundle-title mt-0 text-end">
                    <a href="#" class="btn d-inline"><b class="counter"
                            style="font-weight: 400">{{ $selectedCourses }}</b> Course Added</a>
                </div>
            </div>
        </div>
        @if ($selectedCourses >= 1)
        <div class="row">
            <div class="col-12">
                <div class="selected-bundle-courses-wrap">
                    <div class="row">
                        @foreach ($adminBundleSelected as $course)
                        {{-- course single box start --}}
                        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xxl-3 mb-3">
                            <div class="course-single-item">
                                <div class="course-thumb-box bundle-course-thumb">
                                    <img src="{{ asset($course->thumbnail) }}" alt="Course Thumbanil" class="img-fluid">
                                    <div class="remove-bundle">
                                        <button type="button" class="btn btn-remove"
                                            data-course-id="{{ $course->id }}">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="course-txt-box">
                                    <a href="{{ url('admin/courses/' . $course->slug) }}">{{
                                        Str::limit($course->title, $limit = 45, $end = '..') }}</a>
                                    <p>{{ Str::limit($course->short_description, $limit = 30, $end = '...') }}
                                    </p>
                                    @php
                                    $review_sum = 0;
                                    $review_avg = 0;
                                    $total = 0;
                                    foreach ($course->reviews as $review) {
                                    $total++;
                                    $review_sum += $review->star;
                                    }
                                    if ($total) {
                                    $review_avg = $review_sum / $total;
                                    }
                                    @endphp

                                    <ul>
                                        <li><span>{{ $review_avg }}</span></li>
                                        @for ($i = 0; $i < $review_avg; $i++) <li><i class="fas fa-star"></i></li>
                                            @endfor
                                            <li><span>({{ $total }})</span></li>
                                    </ul>
                                    @if ($course->offer_price)
                                    <h5>৳ {{ $course->offer_price }} <span>৳ {{ $course->price }}</span></h5>
                                    @elseif(!$course->offer_price && !$course->price)
                                    <h5>Free</h5>

                                    @else
                                    <h5>৳ {{ $course->price }}</h5>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- course single box end --}}
                        @endforeach
                    </div>
                </div>
                <div class="bundle-create-form-wrap">
                    <form action="{{ route('admin.create.update.bundle.course',[$bundleCourse->id, 'subdomain' => config('app.subdomain')]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="basic-info-txt">
                                    <h5>Bundle Course Information</h5>
                                    <p>Quickly introduce your course info to students by filling in course information.
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="bundle-create-inputs">
                                    <div class="form-group form-error">
                                        <label for="title">Bundle Title</label>
                                        <input autocomplete="off" type="text" placeholder="Enter title" name="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            value="{{ $bundleCourse->title }}" id="title">
                                        <span class="invalid-feedback">@error('title'){{ $message }} @enderror</span>
                                    </div>

                                    @php
                                    if (is_array($adminBundleSelected)) {
                                        $bundledCourseIds = array_map(function($item) {
                                            return $item['id'];
                                        }, $adminBundleSelected);

                                        $serializedCourseIds = implode(',', $bundledCourseIds);

                                    } else {
                                        $bundledCourseIds = $adminBundleSelected->pluck('id')->toArray();
                                        $serializedCourseIds = implode(',', $bundledCourseIds);
                                    }
                                    @endphp

                                    <input type="hidden" value="{{ $serializedCourseIds }}" name="selected_course" id="selectedCourseId">

                                    <div class="form-group form-error">
                                        <label for="sub_title">Bundle Subtitle</label>
                                        <input autocomplete="off" type="text" placeholder="Enter subtitle" name="sub_title"
                                            class="form-control @error('sub_title') is-invalid @enderror"
                                            value="{{ $bundleCourse->sub_title }}" id="sub_title">
                                        <span class="invalid-feedback">@error('sub_title'){{ $message }}
                                            @enderror</span>
                                    </div>
                                    <div class="form-group form-error">
                                        <label for="description">Bundle Description</label>
                                        <textarea placeholder="Enter description" name="description"
                                            class="form-control @error('description') is-invalid @enderror" id="description">{{ $bundleCourse->description }}</textarea>
                                        <span class="invalid-feedback">@error('description'){{ $message }}
                                            @enderror</span>
                                    </div>
                                    <div class="form-group form-error">
                                        <label for="thumbnail">Bundle Thumbnail</label>
                                        <input type="file" name="thumbnail"
                                            class="form-control @error('thumbnail') is-invalid @enderror"
                                            id="thumbnail">
                                        <span class="invalid-feedback">@error('thumbnail'){{ $message }}
                                            @enderror</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="thumbnail">Thumbnail Preview</label>
                                        <label for="thumbnail" class="image-area">
                                            <img src="" alt="" class="img-fluid rounded" id="thumbnailImage">
                                            <button class="btn" type="button" id="close-button"><i class="fas fa-close"></i></button>
                                        </label>

                                        @if (isset($bundleCourse->thumbnail))
                                            <label for="thumbnail" class="logo-upload-box old-thumb">
                                                <img src="{{ asset($bundleCourse->thumbnail) }}" alt="Uploaded" class="img-fluid rounded">
                                            </label>
                                        @endif

                                    </div>
                                    <div class="input-group">
                                        <label for="regular_price">Regular Price</label>
                                        <span class="input-group-text" id="regular_price">৳</span>
                                        <input autocomplete="off" type="text" placeholder="0" name="regular_price"
                                            class="form-control @error('regular_price') is-invalid @enderror"
                                            value="{{ $bundleCourse->regular_price }}" id="regular_price"
                                            aria-label="regular_price" aria-describedby="regular_price">
                                    </div>
                                    <div class="input-group">
                                        <label for="sales_price">Sales Price</label>
                                        <span class="input-group-text" id="sales_price">৳</span>
                                        <input autocomplete="off" type="text" placeholder="0" name="sales_price"
                                            class="form-control @error('sales_price') is-invalid @enderror"
                                            value="{{ $bundleCourse->sales_price }}" id="sales_price" aria-label="sales_price"
                                            aria-describedby="sales_price">
                                    </div>
                                    <div class="form-submit-bttns">
                                        <button type="button" onclick="history.go(-1)" class="btn btn-cancel">Cancel</button>
                                        <button type="submit" class="btn btn-submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-12">
                @include('partials/no-data')
            </div>
        </div>
        @endif
    </div>
</main>
@endsection

{{-- page script @S --}}
@section('script')

{{-- thumbnail image preview --}}
<script>
    const lpBgImageInput = document.getElementById('thumbnail');
    const lpLogoPreview = document.getElementById('thumbnailImage');
    const lpCloseButton = document.getElementById('close-button');
    const oldThumb = document.querySelector('.old-thumb');

    lpBgImageInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                lpLogoPreview.src = e.target.result;
                lpCloseButton.style.display = 'block';
                oldThumb.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    });

    lpCloseButton.addEventListener('click', function () {
        lpBgImageInput.value = '';
        lpLogoPreview.src = '';
        lpCloseButton.style.display = 'none';
        oldThumb.style.display = 'block';
    });
</script>

{{-- remove bundle ajax request with featch --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

        let currentURL = window.location.href;
        const baseUrl = currentURL.split('/').slice(0, 3).join('/');
        const removeBundle = document.querySelectorAll('.btn-remove');
        let selectedCourseId;
        let courseIdArray;
        let selectPage;

        removeBundle.forEach(item => {
            item.addEventListener('click', function() {
                let grandparent = item.parentNode.parentNode.parentNode.parentNode;
                grandparent.style.display = 'none';

                let courseId = item.getAttribute('data-course-id');

                    if (courseId) {
                        fetch(`${baseUrl}/admin/bundle/courses/remove-new/${courseId}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                },
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.message === 'DONE') {
                                    // top counter increase
                                    const countDisplay = document.querySelector('.counter');
                                    const currentCount = parseInt(countDisplay.textContent);
                                    countDisplay.textContent = currentCount - 1;

                                    // redirecet to select page
                                    if (countDisplay.textContent < 1) {
                                        var slug = @json($bundleCourse->slug);
                                        var routeUrl = '{{ route('select.again.bundle.course', ['slug' => ':slug', 'subdomain' => config('app.subdomain')]) }}';
                                        routeUrl = routeUrl.replace(':slug', slug);
                                        window.location.href = routeUrl;
                                    }

                                    // item display hide
                                    grandparent.style.display = 'none';

                                    // remove id from hidden field
                                    selectedCourseId = document.querySelector('#selectedCourseId');
                                    courseIdArray = selectedCourseId.value.split(',');
                                    courseIdArray = courseIdArray.filter(cId => cId != courseId);
                                    selectedCourseId.value = courseIdArray.join(',');

                                } else {
                                     grandparent.style.display = 'block';
                                }
                            })
                            .catch(error => {
                                    grandparent.style.display = 'block';
                            });
                    }
                });


            });
        });

</script>

@endsection
{{-- page script @E --}}
