<html>

<body style="font-family: Open Sans, sans-serif; font-size: 100%; font-weight: 400; line-height: 1.4; color: #000;">
  <table style="max-width: 670px; width: 100%; margin: 50px auto 10px; background-color: #fff; padding: 50px; border-radius: 3px; box-shadow: 0 1px 3px rgba(0, 0, 0, .12), 0 1px 2px rgba(0, 0, 0, .24);">
    <thead>
      <tr>
        <th style="text-align: left;">
          <a href="https://app.learncosy.com"> 
            <img src="{{ asset('assets/images/black-logo.png') }}" alt="Learncosy" class="img-fluid" style="max-width: 7rem;">
        </a>
        </th>
        <th style="text-align: right; font-weight: 400;">{{ date('d M Y') }}</th>
      </tr>
    </thead>
    <tbody>
      <tr style="min-width: 0; max-width: 670px;">
        <td style="height: 35px;"></td>
      </tr>
      <tr style="min-width: 0; max-width: 670px;">
        <td colspan="2" style="border: 1px solid #ddd; padding: 10px 20px;">
          <p style="font-size: 14px; margin: 0 0 6px 0;">
            <span style="font-weight: bold; display: inline-block; min-width: 150px;">Order status</span>
            <b style="color: green; font-weight: normal; margin: 0;">Success</b>
          </p>
          <p style="font-size: 14px; margin: 0 0 6px 0;">
            <span style="font-weight: bold; display: inline-block; min-width: 146px;">Transaction ID</span> {{ $subscription->stripe_plan }}
          </p>
          <p style="font-size: 14px; margin: 0 0 0 0;">
            <span style="font-weight: bold; display: inline-block; min-width: 146px;">Order amount</span> ৳ {{ $subscription->amount }}
          </p>
        </td>
      </tr>
      <tr style="min-width: 0; max-width: 670px;">
        <td style="height: 35px;"></td>
      </tr>
      <tr style="min-width: 0; max-width: 670px;">
        <td style="width: 50%; padding: 20px; vertical-align: top;">
          <p style="margin: 0 0 10px 0; padding: 0; font-size: 14px;">
            <span style="display: block; font-weight: bold; font-size: 13px;">Name</span> {{ auth()->user()->name }}
          </p>
          <p style="margin: 0 0 10px 0; padding: 0; font-size: 14px;">
            <span style="display: block; font-weight: bold; font-size: 13px;">Email</span> {{ auth()->user()->email }}
          </p>
          <p style="margin: 0 0 10px 0; padding: 0; font-size: 14px;">
            <span style="display: block; font-weight: bold; font-size: 13px;">Phone</span> {{ auth()->user()->phone }}
          </p> 
        </td>
        <td style="width: 50%; padding: 20px; vertical-align: top;">
          <!-- <p style="margin: 0 0 10px 0; padding: 0; font-size: 14px;">
            <span style="display: block; font-weight: bold; font-size: 13px;">Address</span>
              Khudiram Pally, Malbazar, West Bengal, India, 735221
          </p> -->
          <p style="margin: 0 0 10px 0; padding: 0; font-size: 14px;">
            <span style="display: block; font-weight: bold; font-size: 13px;">Package Name</span> {{ $data->name }}
          </p>
          <p style="margin: 0 0 10px 0; padding: 0; font-size: 14px;">
            <span style="display: block; font-weight: bold; font-size: 13px;">Start &amp; End Date</span>
            Start at {{ $subscription->start_at }} and end at {{ $subscription->end_at }}
          </p>
        </td>
      </tr>
    </tbody>
  </table>
</body>
</html>