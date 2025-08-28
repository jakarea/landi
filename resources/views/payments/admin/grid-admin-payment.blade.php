@extends('layouts.latest.admin')
@section('title') Payment From Instructor @endsection

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
                    <img src="{{asset('assets/images/icons/ear-01.svg')}}" alt="ear-01"
                        class="img-fluid light-ele">
                    <img src="{{asset('assets/images/icons/ear-01-d.svg')}}" alt="ear-01"
                        class="img-fluid dark-ele">
                    <h5>Total Earnings</h5>

                    @php
                        $percenTageAlltimeEarnings = 0;

                        $earningsLastTwoYears = ($earningsLastTwoYears == 0) ? 1 : $earningsLastTwoYears;
                        $lastOneyear = ($lastOneyear == 0) ? 1 : $lastOneyear;

                        if ($earningsLastTwoYears != 0 && $lastOneyear != 0) {
                            $percenTageAlltimeEarnings = (($lastOneyear - $earningsLastTwoYears) / $earningsLastTwoYears) * 100;
                        }
                    @endphp

                    <span class="{{ $percenTageAlltimeEarnings < 0 ? 'red' : '' }}">
                        @if ($percenTageAlltimeEarnings < 0 )
                        <img src="{{asset('assets/images/icons/down-red.svg')}}" alt="icon" class="img-fluid">
                        @else
                        <img src="{{asset('assets/images/icons/upgrade.svg')}}" alt="icon" class="img-fluid">
                        @endif
                        {{ number_format($percenTageAlltimeEarnings,0) }}%
                    </span>

                    <h4>৳ {{ $totalEarningsUntilToday }}</h4>
                </div>
            </div>
            <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                <div class="top-card-box">
                    <img src="{{asset('assets/images/icons/ear-02.svg')}}" alt="ear-01"
                        class="img-fluid light-ele">
                    <img src="{{asset('assets/images/icons/ear-02-d.svg')}}" alt="ear-01"
                        class="img-fluid dark-ele">
                    <h5>Earnings Today</h5>

                    @php
                        $percentageChangeTodayEarnongs = 0;
                        if ($earningsYesterday !=0 ) {
                            $percentageChangeTodayEarnongs = (($earningsToday - $earningsYesterday) / $earningsYesterday) * 100;
                        }
                    @endphp

                    <span class="{{ $percentageChangeTodayEarnongs < 0 ? 'red' : '' }}">
                        @if ($percentageChangeTodayEarnongs < 0 )
                        <img src="{{asset('assets/images/icons/down-red.svg')}}" alt="icon" class="img-fluid">
                        @else
                        <img src="{{asset('assets/images/icons/upgrade.svg')}}" alt="icon" class="img-fluid">
                        @endif
                        {{ $percentageChangeTodayEarnongs }}%
                    </span>

                    <h4>৳ {{ $earningsToday }}</h4>
                </div>
            </div>
            <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                <div class="top-card-box">
                    <img src="{{asset('assets/images/icons/ear-03.svg')}}" alt="ear-01"
                        class="img-fluid light-ele">
                    <img src="{{asset('assets/images/icons/ear-03-d.svg')}}" alt="ear-01"
                        class="img-fluid dark-ele">

                    <span class="green">
                        <img src="{{asset('assets/images/icons/upgrade.svg')}}" alt="icon" class="img-fluid"> {{ $percentageEnrollments }}%
                    </span>

                    <h5>Total Enrollments</h5>
                    <h4> {{ $totalEnrollments }}</h4>
                </div>
            </div>
            <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                <div class="top-card-box">
                    <img src="{{asset('assets/images/icons/ear-03.svg')}}" alt="ear-01"
                        class="img-fluid light-ele">
                    <img src="{{asset('assets/images/icons/ear-03-d.svg')}}" alt="ear-01"
                        class="img-fluid dark-ele">

                    <span class="green">
                        <img src="{{asset('assets/images/icons/upgrade.svg')}}" alt="icon" class="img-fluid"> {{ ($totalEnrollments > 0) ? ($enrollesToday / $totalEnrollments) * 100 : 0 }}%
                    </span>

                    <h5>Enrolled Today</h5>
                    <h4>{{$enrollesToday}}</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="pay-title">
                    <h4>Payment from Instructor</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-3">
                <div class="package-list-header" style="grid-template-columns: 100%">
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
                                <span>Package Name</span>
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
                            <th width="16%">Instructor Name</th>
                            <th width="12%">Start at</th>
                            <th width="12%">End at</th>
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
                                <p>{{$payment->name}}</p>
                            </td>
                            <td>

                                <h5>
                                    @if ($payment->instructor && $payment->instructor->name)
                                        <a href="{{url('admin/instructor/profile/'.$payment->instructor->id)}}">
                                            {{$payment->instructor->name}}
                                        </a>
                                    @else
                                        <u class="text-danger">This user has been removed.</u>
                                    @endif
                                </h5>
                            </td>
                            <td>
                                <p>{{ $payment->start_at->format('d M Y') }}</p>
                            </td>
                            <td>
                                <p>{{ $payment->end_at->format('d M Y') }}</p>
                            </td>
                            <td>
                                <p>৳{{$payment->amount}}</p>
                            </td>
                            <td>
                                @if ($payment->status == 'cancel')
                                <p style="color: #ED5763;" class="text-capitalize">Cancled</p>
                                @else
                                 <p style="color: #2A920B;" class="text-capitalize">Active</p>
                                @endif
                            </td>
                            <td>
                                <ul>
                                    <a href="{{ route('admin-export',encrypt($payment->stripe_plan)) }}" class="btn-view btn-export">Export</a>
                                    <a href="{{ url('admin/payments/platform-fee', encrypt($payment->stripe_plan)) }}" class="btn-view">View</a>
                                </ul>
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
