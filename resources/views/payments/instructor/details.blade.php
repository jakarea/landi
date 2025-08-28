@extends('layouts.latest.instructor')
@section('title') Payment From Student @endsection

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
            <div class="col-12">
                <div class="payment-details-title">
                    <h1>Payment Details</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9">
                <div class="payment-name-box">
                    <div>
                        <h6>Payment by</h6>
                        <h5>{{ $payment->user->name}}</h5>
                    </div>
                    <div>
                        <h6>Subscription Date</h6>
                        <h5>{{ date(' d M, Y',strtotime($payment->created_at)) }}</h5>
                    </div>
                    <div>
                        <h6>Payment Date</h6>
                        <h5>{{ date(' d M, Y',strtotime($payment->created_at)) }}</h5>
                    </div>
                    <div>
                        <h6>Payment type</h6>
                        <h5>{{ $payment->payment_method }}</h5>
                    </div>
                    <div>
                        <h6>Status</h6>
                       <span>{{ $payment->status }}</span>
                    </div>
                </div>
                <div class="pay-details-box-invoice">
                    <table>
                        <tr>
                            <th>Details</th>
                            <th>Course Type</th>
                            <th>Amount</th>
                        </tr>
                        <tr>
                            <td>{{ optional($payment->course)->title }}</td>
                            <td>
                            {{ optional($payment->course)->categories }}
                            </td>
                            <td>৳{{ optional($payment->course)->price }}</td>
                        </tr>
                        <tr>
                            <td colspan="2"> discount</td>
                            <td>৳{{ optional($payment->course)->price - optional($payment->course)->offer_price }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">Grand Total</td>
                            <td>৳{{ optional($payment->course)->offer_price }}</td>
                        </tr>
                    </table>
                    <div class="download-inv-box">
                        <a href="{{url('instructor/payments')}}">Back</a>
                        <a href="{{ route('invoice-mail', ['id' => encrypt($payment->payment_id), 'subdomain' => config('app.subdomain') ]) }}" class="ms-3 d-inline-flex align-items-center"><img src="{{asset('assets/images/icons/email.svg')}}" alt="a" class="img-fluid me-2"> Mail Invoice</a>
                        <a href="{{route('generate-pdf', ['id' => encrypt($payment->payment_id), 'subdomain' => config('app.subdomain') ])}}"><img src="{{asset('assets/images/icons/upload-3.svg')}}" alt="a" class="img-fluid"> Download Invoice</a>

                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="paid-student-name">
                    <div class="avatar text-center">
                        @if($payment->user)
                            @if ($payment->user->avatar)
                                <img src="{{ asset($payment->user->avatar) }}" alt="User" class="img-fluid">
                            @else
                                <span class="avatar-big-box">{!! strtoupper($payment->user->name[0]) !!}</span>
                            @endif 
                        @endif 
                    </div>
                    <div class="txt">
                        <h5><a href="{{url('instructor/students/profile/'.$payment->user->id)}}">{{ $payment->user->name}}</a></h5>
                        <h6>{{ $payment->user->user_role}}</h6>

                        <hr>

                        <ul>
                            <li><img src="{{asset('assets/images/icons/p-1.svg')}}" alt="a" class="img-fluid"> {{ $payment->user->email }}</li>
                            <li><img src="{{asset('assets/images/icons/p-2.svg')}}" alt="a" class="img-fluid"> {{ $payment->user->phone }}</li>
                            @php
                            $social_links = explode(",", $payment->user->social_links);
                            use Illuminate\Support\Str;
                            @endphp

                            @foreach ($social_links as $social_link)
                            @php
                            $url = $social_link;
                            $host = parse_url($url, PHP_URL_HOST);
                            $domain = Str::after($host, 'www.');
                            $domain = Str::before($domain, '.');
                            @endphp

                            <li>
                                @if ($domain == 'instagram')
                                <a href="{{ $social_link ? $social_link : '#' }}" target="_blank" style="word-break: break-all">
                                    <img src="{{asset('assets/images/icons/p-3.svg')}}" alt="a" class="img-fluid">{{ $social_link ? $social_link : '' }}</a>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                        <a href="{{url('instructor/students/profile/'.$payment->user->id)}}" class="common-bttn d-block w-100">View profile</a>
                    </div>

                </div>
            </div>
         </div>
    </div>
</main>
{{-- ==== admin payment list page @E ==== --}}
@endsection
{{-- page content @E --}}
