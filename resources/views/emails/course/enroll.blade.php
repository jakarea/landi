<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Course Enrollemnt</title>
    <style>
        /* Reset styles */
        body, body * {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        /* Container */
        .main-table {
            max-width: 800px;
            width: 100%;
            margin: 0 auto;
            text-align: left;
        }
          .main-table tr .header-table {
            text-align: center;
            padding: 1rem;
            width: 100%;
            background-color: #5a4b4b;
          }
          .main-table tr th h1{
            font-size: 2rem;
            font-weight: 700;
            padding-left: 1rem;
            padding-right: 1rem;
            color: #fff
          }

          .main-table tr th a{
            display: block;
            margin-top: .3rem;
          }
          .main-table tr th img{
            width: 8rem;
            display: block;
          }
          .main-table tr th p{
            font-size: 0.9rem;
            font-weight: 400;
            color: #fff;
          }
          .body-table{
            width: 100%;
            padding: 2rem;
            background-color: #fff;
          }

          .body-table h4{
            margin-bottom: 1rem;
            font-size: 1.2rem;
          }
          .body-table h5{
            margin-top: 1rem;
            font-size: .9rem;
          }

          .body-table h5 span{
            font-weight: 500;
            color: green;
          }

          .body-table h4 span{
            font-size: 1.1rem;
            font-weight: 400;
          }
          .project-ftr{
            background-color: #ddd;
            padding: 1rem;
            text-align: center;
          }
          .project-ftr p{
            font-size: .9rem;
          }

          @media (min-width: 320px) and (max-width: 767px) {
            .main-table tr th h1{
                font-size: 1.2rem;
            }
          }

          @media (min-width: 768px) and (max-width: 991px) {
            .main-table tr th h1{
                font-size: 1.8rem;
            }
          }
    </style>
</head>
<body>

    <table cellpadding="0" cellspacing="0" border="0" class="main-table">
        <tr>
            <th>
                <table cellpadding="0" cellspacing="0" border="0" class="header-table">
                    <tr>
                        <th>
                            <a href="https://app.learncosy.com">
                                <img src="https://app.learncosy.com/assets/images/learncosy-logo.png" alt="learncosy">
                            </a>
                        </th>
                        <th>
                            <h1>New Course Enrollment!</h1>
                        </th>
                    </tr>
                </table>
            </th>
        </tr>
        <tr>
            <td>
                <table cellpadding="0" cellspacing="0" border="0" class="body-table">
                    <tr>
                        <td>
                            <h4><span>Thank you for purchasing a new course at Learncosy. We're excited to have you as a new student.Here are some important details and instructions for getting started to your course:</span></h4>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h3>Course Information:</h3>
                            <ul>
                                <li><strong>Name:</strong> {{ $course->title }}</li>
                                <li><strong>Price:</strong> {{ $course->price }}</li>
                                <li><strong>Short Description:</strong> {{ $course->short_description }}</li>
                                <li><strong>Total Module:</strong> {{ $course->number_of_module }}</li>
                                <li><strong>Total Lesson:</strong> {{ $course->number_of_lesson }}</li>
                                <li><strong>Course Duration:</strong> {{ $course->duration }}</li>
                                <li><strong>Has Certificate:</strong> {{ $course->hascertificate }}</li>
                                <li><strong>Course URL:</strong> <a href="{{ url('/student/courses/'.$course->slug) }}">{{ url('/student/courses/'.$course->slug) }} </a></li>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="margin-top: 1rem">Thank you again for choosing Learncosy. We hope you have a great experience!</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="project-ftr">
                <p>This is an automated email, please do not reply.</p>
            </td>
        </tr>
    </table>
</body>
</html>


<html>

<body style="font-family: Open Sans, sans-serif; font-size: 100%; font-weight: 400; line-height: 1.4; color: #000;">
  <table style="max-width: 670px; width: 100%; margin: 50px auto 10px; background-color: #fff; padding: 50px; border-radius: 3px; box-shadow: 0 1px 3px rgba(0, 0, 0, .12), 0 1px 2px rgba(0, 0, 0, .24);">
    <thead>
      <tr>
        <th style="text-align: left;">
          <a href="https://app.learncosy.com">
            <img src="{{ asset('assets/images/black-logo.png') }}" alt="Learncosy" class="img-fluid" width="140px">
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
