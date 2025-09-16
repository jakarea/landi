@extends('layouts.latest.instructor')
@section('title','Payment From Student')

{{-- page style @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/subscription.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
{{-- ==== admin payment list page @S ==== --}}
<main class="admin-payment-list-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                <div class="top-card-box">
                    <img src="{{asset('assets/images/icons/ear-01.svg')}}" alt="ear-01" class="img-fluid light-ele">
                    <img src="{{asset('assets/images/icons/ear-01-d.svg')}}" alt="ear-01" class="img-fluid dark-ele">
                    <h5>Total Earnings</h5>

                    <span class="{{ $formattedPercentageChangeOfEarningByMonth < 0 ? 'red' : '' }}">
                        @if ($formattedPercentageChangeOfEarningByMonth < 0 )
                        <img src="{{asset('assets/images/icons/down-red.svg')}}" alt="icon" class="img-fluid">
                        @else
                        <img src="{{asset('assets/images/icons/upgrade.svg')}}" alt="icon" class="img-fluid">
                        @endif
                        {{ number_format(floatval($formattedPercentageChangeOfEarningByMonth), 0, '.', '') }}%
                    </span>

                    <h4>৳{{$totalEnrollmentSell}}</h4>
                </div>
            </div>
            <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                <div class="top-card-box">
                    <img src="{{asset('assets/images/icons/ear-02.svg')}}" alt="ear-01" class="img-fluid light-ele">
                    <img src="{{asset('assets/images/icons/ear-02-d.svg')}}" alt="ear-01" class="img-fluid dark-ele">
                    <h5>Earnings Today</h5>


                    <span class="{{ $formattedPercentageChangeOfEarningByDay < 0 ? 'red' : '' }}">
                        @if ($formattedPercentageChangeOfEarningByDay < 0 )
                        <img src="{{asset('assets/images/icons/down-red.svg')}}" alt="icon" class="img-fluid">
                        @else
                        <img src="{{asset('assets/images/icons/upgrade.svg')}}" alt="icon" class="img-fluid">
                        @endif
                        {{ number_format(floatval($formattedPercentageChangeOfEarningByDay), 0, '.', '') }}%
                    </span>

                    <h4>৳{{$todaysTotalEnrollmentSell}}</h4>
                </div>
            </div>
            <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                <div class="top-card-box">
                    <img src="{{asset('assets/images/icons/ear-03.svg')}}" alt="ear-01" class="img-fluid light-ele">
                    <img src="{{asset('assets/images/icons/ear-03-d.svg')}}" alt="ear-01" class="img-fluid dark-ele">

                    <span class="{{ $formatedPercentageChangeOfStudentEnrollByMonth < 0 ? 'red' : '' }}">
                        @if ($formatedPercentageChangeOfStudentEnrollByMonth < 0 )
                        <img src="{{asset('assets/images/icons/down-red.svg')}}" alt="icon" class="img-fluid">
                        @else
                        <img src="{{asset('assets/images/icons/upgrade.svg')}}" alt="icon" class="img-fluid">
                        @endif
                        {{ number_format(floatval($formatedPercentageChangeOfStudentEnrollByMonth), 0, '.', '') }}%
                    </span>

                    <h5>Total Enrollments</h5>
                    <h4>{{$totalEnrollment}} Students</h4>
                </div>
            </div>
            <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                <div class="top-card-box">
                    <img src="{{asset('assets/images/icons/ear-03.svg')}}" alt="ear-01" class="img-fluid light-ele">
                    <img src="{{asset('assets/images/icons/ear-03-d.svg')}}" alt="ear-01" class="img-fluid dark-ele">

                    <span class="{{ $formatedPercentageChangeOfStudentEnrollByDay < 0 ? 'red' : '' }}">
                        @if ($formatedPercentageChangeOfStudentEnrollByDay < 0 )
                        <img src="{{asset('assets/images/icons/down-red.svg')}}" alt="icon" class="img-fluid">
                        @else
                        <img src="{{asset('assets/images/icons/upgrade.svg')}}" alt="icon" class="img-fluid">
                        @endif
                        {{ number_format(floatval($formatedPercentageChangeOfStudentEnrollByDay), 0, '.', '') }}%
                    </span>

                    <h5>Enrolled Today</h5>
                    <h4>{{$todaysEnrollment}} Students</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="pay-title">
                    <h4>Payment from student</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-3">
                <div class="package-list-header" style="grid-template-columns: 100%; border-radius: 10px 10px 0 0">
                    <h5>Payment Information:</h5>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="subscription-table-wrap payment-table-admin">
                    @if (count($enrolments) > 0)
                    {{-- filter form --}}
                    <form action="" method="GET" id="myForm">
                        <input type="hidden" name="status" id="inputField">
                    </form>
                    {{-- filter form --}}
                    <table>
                        <tr>
                            <th width="3%">No</th>
                            <th class="d-flex justify-content-between">
                                <span>Course Name</span>
                                <div class="filter-sort-box">
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false" id="dropdownBttn">
                                            <img src="{{ asset('assets/images/icons/sort-icon.svg') }}" alt="a"
                                                class="img-fluid">
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item filterItem" href="#" data-value="asc">In order
                                                    A-Z</a></li>
                                            <li><a class="dropdown-item filterItem" href="#" data-value="desc">In order
                                                    Z-A</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </th>
                            <th width="12%">Student Name</th>
                            <th width="12%">Payment Date</th>
                            <th width="12%">Payment Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th width="15%">Action</th>
                        </tr>
                        @foreach ($enrolments as $key => $payment)
                        <tr>
                            <td>
                                {{ $key + 1 }}
                            </td>
                            <td>
                                @if ($payment->course)
                                    <h5><a href="{{ url('instructor/courses/overview/'.$payment->course->slug) }}">{{ (strlen($payment->course->title ) > 50) ? substr($payment->course->title, 0, 47) . "..." : $payment->course->title }}</a></h5>
                                @else
                                <h5 class="mishty-clr">Course has been removed</h5>
                                @endif
                            </td>
                            <td>
                                <p><a href="{{ url('instructor/students/profile/'.$payment->user->id) }}">{{$payment->user->name}}</a></p>
                            </td>
                            <td>
                                <p>{{ $payment->created_at->format('d M Y') }}</p>
                            </td>
                            <td>
                                <p>{{$payment->payment_method}}</p>
                            </td>
                            <td>
                                <p>৳{{$payment->amount}}</p>

                            </td>
                            <td>
                                @if ($payment->status == 'completed')
                                <p style="color: #2A920B;" class="text-capitalize">{{ $payment->status }}</p>
                                @else
                                <p style="color: #ED5763;" class="text-capitalize">{{ $payment->status }}</p>
                                @endif
                            </td>
                            <td>

                            <a href="{{ route('instructor-export', ['id' => encrypt($payment->payment_id), 'subdomain' => config('app.subdomain') ]) }}" class="btn-view btn-export">Export </a>

                            <a href="{{ route('viewPayment', ['payment_id' => encrypt($payment->payment_id), 'subdomain' => config('app.subdomain')]) }}
                                " class="btn-view">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    @else
                    @include('partials/no-data')
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            {{-- pagginate --}}
            <div class="paggination-wrap mt-4">
                {{ $enrolments->links('pagination::bootstrap-5') }}
            </div>
            {{-- pagginate --}}
        </div>
    </div>
</main>
{{-- ==== admin payment list page @E ==== --}}
@endsection
{{-- page content @E --}}


{{-- page script @S --}}
@section('script')
<script>
    document.addEventListener("DOMContentLoaded", function() {
            let inputField = document.getElementById("inputField");
            let form = document.getElementById("myForm");
            let dropdownItems = document.querySelectorAll(".filterItem");

            dropdownItems.forEach(item => {
                item.addEventListener("click", function(e) {
                    e.preventDefault();
                    inputField.value = this.getAttribute("data-value");
                    form.submit();
                });
            });
        });
</script>
@endsection
{{-- page script @E --}}
