<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="images/favicon.png" rel="icon" />
    <title>Payment From Instructor - Learncosy</title>

    <style>
        * {
            padding: 0;
            margin: 0;
            outline: none;
            list-style-type: none;
            text-decoration: none;
            box-sizing: border-box;
        }

        ol,
        ul,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        a,
        p,
        i,
        button,
        strong,
        u,
        sub,
        sup,
        span,
        textarea,
        table tr td,
        select,
        input {
            padding: 0;
            margin: 0;
        }

        select:focus-within,
        textarea:focus-within,
        input:focus-within,
        .form-control:focus-within,
        button:focus-within {
            box-shadow: none !important;
        }

        a,
        a:hover {
            color: #000;
            text-decoration: none;
        }

        ol,
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        table tr th {
            padding: .8rem 0;
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
        }

        table tr th h1 {
            font-size: 1.875rem;
            color: #0c2f54;
        }

        table tr th p {
            font-size: .875rem;
            color: #535b61;
        }


        .border-0 {
            border: 0 !important;
        }

        address {
            font-size: .875rem;
            color: #535b61;
            font-weight: 400;
            font-style: normal;
            line-height: 24px;
        }

        .billed-table {
            width: 100%;
            margin-top: 1rem;
        }

        .billed-table .card-header td {
            font-size: .875rem;
            font-weight: 600;
            color: #000;
            padding: 0.75rem;
            border: 1px solid #ccc;
        }

        .billed-table tbody td {
            font-size: .875rem;
            font-weight: 400;
            color: #000;
            padding: 0.75rem;
            border: 1px solid #ccc;
        }

        .bl-0 {
            border-left: 0 !important;
        }

        .br-0 {
            border-right: 0 !important;
        }
    </style>
</head>

<body>
    <table border="0" cellspacing="0" cellpadding="0" style="width: 70%; margin: 0 auto;">
        <tr>
            <th class="border-0" style="text-align: left;">
                <a href="#"> 
                    <img src="{{ public_path('assets/images/black-logo.png') }}" alt="Logo" class="img-fluid" style="width: 7rem">
                </a>
            </th>
            <th class=" border-0" style="text-align: right;">
                <h1>Invoice</h1>
            </th>
        </tr>
        <tr>
            <th colspan="2" class="" style="text-align: right;">
                <p>Date: {{ now()->format('d-M-Y') }}</p>
            </th>
        </tr>
        <tr>
            <td style="padding-top: 1rem;">
                <address>
                    <strong>Payment By: </strong> <br>
                    Name: {{ isset($payment->instructor->name) ? $payment->instructor->name : "Instructor has been removed"; }} <br />
                    Subscription Date: {{ date(' d M, Y',strtotime($payment->created_at)) }} <br>
                    Start Date : {{ date(' d M, Y',strtotime($payment->start_at)) }} <br>
                    End Date : {{ date(' d M, Y',strtotime($payment->end_at)) }} <br> 
                    Payment Status : {{ ucfirst( $payment->payment_status) }}

                </address>
            </td>
            <td style="padding-top: 1rem; text-align: right;" class="" valign="top">
                <address>
                    <strong>Billed To: </strong> <br>
                    Name: {{ Auth::user()->name }}<br />
                    @if (Auth::user()->company_name)
                    Company Name: {{ Auth::user()->company_name }} <br />
                    @endif

                    Email: {{ Auth::user()->email }}
                </address>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table border="0" cellspacing="0" cellpadding="0" class="billed-table">
                    <thead class="card-header">
                        <tr>
                            <td class="br-0" width="50%"><strong>Package Name</strong></td>
                            <td class="bl-0 br-0" width="15%"><strong>Package Type</strong></td>
                            <td class="bl-0 " width="15%" style="text-align: right;"><strong>Amount</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="br-0">{{ isset($package->name) ? $package->name : "Package has been removed"; }}</td>
                            <td class="bl-0 br-0">{{ isset($package->type) ? $package->type : "Package has been removed"; }}  </td>
                            <td class="bl-0 " style="text-align: right;">৳{{ $package->regular_price }}  </td>
                        </tr>
                        <tr class="" style="text-align: right;">
                            <td colspan="2" class="br-0">
                                <strong>Discount:</strong>
                            </td>
                            <td class="bl-0">
                                ৳ {{ $package->regular_price - $package->sales_price }}
                            </td>
                        </tr> 
                        <tr class="" style="text-align: right;">
                            <td colspan="2" class="br-0">
                                <strong>Grand Total:</strong>
                            </td>
                            <td class="bl-0">
                                ৳ {{ $package->sales_price }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center; padding-top: 2rem;">
                <p style="font-size: 12px; color: #535b61;">This invoice is computer generated, Powred by Learcosy</p>
            </td>
        </tr>
    </table>
</body>

</html>