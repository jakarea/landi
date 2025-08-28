<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Updated</title>
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
            font-size: 1.4rem;
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
                            <h1>Password has been updated</h1>
                        </th>
                        <th>
                            <p>{{$user->updated_at->diffForHumans()}}</p>
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
                            <h4><span>Your Password has been updated successfuly!</span></h4>
                        </td>
                    </tr> 
                    <tr>
                        <td>
                            <h3>Account Information:</h3> 
                            <ul>
                                <li><strong>Your Email:</strong> {{ $user->email }}</li>  
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="margin-top: 1rem">Thank you again for staying Learncosy. We hope you are having a great experience!</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center">
                            <h5>Password Updated at: {{$user->updated_at}}</h5>
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