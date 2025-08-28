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
                        <h5>
                            @if ($payment->instructor && $payment->instructor->name)
                                {{$payment->instructor->name}}
                            @else 
                                This user has been removed.
                            @endif
                        </h5>
                    </div>
                    <div>
                        <h6>Payment Date</h6>
                        <h5>{{ date(' d M, Y',strtotime($payment->created_at)) }}</h5>
                    </div>
                    <div>
                        <h6>Start At</h6>
                        <h5>{{ date(' d M, Y',strtotime($payment->start_at)) }}</h5>
                    </div>
                    <div>
                        <h6>End At</h6>
                        <h5>{{ date(' d M, Y',strtotime($payment->end_at)) }}</h5>
                    </div>
                    <div>
                        <h6>Status</h6>
                       <span>{{ $payment->status == NULL ? 'Success' : $payment->status}}</span>
                    </div>
                </div>
                <div class="pay-details-box-invoice">
                    <table>
                        <tr>
                            <th>Package Name</th>
                            <th>Package Type</th>
                            <th>Amount</th>
                        </tr>
                        @if ($payment->subscriptionPakage) 
                        <tr>
                            <td>{{ $payment->subscriptionPakage->name }}</td> 
                            <td>{{ $payment->subscriptionPakage->type }}</td> 
                            <td>৳ {{ $payment->subscriptionPakage->regular_price }}</td> 
                        </tr> 
                        <tr>
                            <td colspan="2">Discount</td>
                            <td>৳ {{$payment->subscriptionPakage->regular_price - $payment->subscriptionPakage->sales_price}}</td>
                        </tr>
                        @else 
                        <tr>
                            <td colspan="3">
                                This subscription package has been removed.
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td colspan="2">Grand Total</td> 
                            <td>৳ {{$payment->amount}}</td>
                        </tr>
                    </table>
                    <div class="download-inv-box">
                        <a href="{{url('admin/payments/platform-fee')}}">Back</a>
                        <a href="{{ route('admin.invoice-mail',encrypt($payment->stripe_plan)) }}" class="ms-3 d-inline-flex align-items-center">
                            <img src="{{asset('assets/images/icons/email.svg')}}" alt="a" class="img-fluid me-2"> Mail Invoice</a>
                        <a href="{{route('admin.generate-pdf',encrypt($payment->stripe_plan))}}"><img src="{{asset('assets/images/icons/upload-3.svg')}}" alt="a" class="img-fluid"> Download Invoice</a>
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="paid-student-name">
                    <div class="avatar text-center">
                        @if($payment->instructor)
                            @if ($payment->instructor->avatar)
                                <img src="{{ asset($payment->instructor->avatar) }}" alt="User" class="img-fluid">
                            @else
                                <span class="avatar-big-box">{!! strtoupper($payment->instructor->name[0]) !!}</span>
                            @endif 
                        @endif 
                        
                    </div>
                    <div class="txt">
                        <h5>
                            <a href="#"> 
                                @if ($payment->instructor && $payment->instructor->name)
                                    {{$payment->instructor->name}}
                                @else 
                                    This user has been removed.
                                @endif 
                            </a>
                        </h5>
                        <h6> 
                            @if ($payment->instructor && $payment->instructor->user_role)
                                    {{ $payment->instructor->user_role}}
                                @else 
                                    This user has been removed.
                                @endif  
                            </h6> 
                        <hr>

                        @if ($payment->instructor) 
                        <ul>
                            <li><img src="{{asset('assets/images/icons/p-1.svg')}}" alt="a" class="img-fluid"> {{ $payment->instructor->email }}</li>
                            <li><img src="{{asset('assets/images/icons/p-2.svg')}}" alt="a" class="img-fluid"> {{ $payment->instructor->phone ? $payment->instructor->phone : 'No number found!' }}</li>
                        </ul> 
                        <a href="{{url('admin/instructor/profile/'.$payment->instructor->id)}}" class="common-bttn d-block w-100 mt-3">View profile</a>
                        @endif  
                    </div> 
                </div>
            </div>
         </div>
    </div>
</main>
{{-- ==== admin payment list page @E ==== --}}
@endsection
{{-- page content @E --}}