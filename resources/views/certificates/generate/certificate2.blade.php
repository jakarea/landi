<!DOCTYPE html>
<html>

<head>
    <title>Certificate of Completion</title>

    <style>
        @font-face {
            font-family: Poppins;
            src: url({{ storage_path('fonts/Poppins-Medium.ttf') }}) format("truetype");
            font-weight: 500;
            font-style: normal;
        }

        @font-face {
            font-family: Rakkas;
            src: url({{ storage_path('fonts/Rakkas-Regular.ttf')}}) format("truetype");
            font-weight: 400;
            font-style: normal;
        }

        * {
            padding: 0;
            margin: 0;
            outline: none;
            list-style-type: none;
            text-decoration: none;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-family: Rakkas;
        }

        .main-wrapper {
            width: 100%;
            height: 100vh;
        }

        .container {
            width: 845px;
            height: 590px;
            margin: 0 auto;
            position: relative; 
        } 

        .main-bg{
            width: 845px;
            height: 590px;
            position: absolute; 
        }

        .certficate-content {
            width: 65%;
            height: 590px;
            position: absolute;
            left: 0;
            top: 0;
            z-index: 9999;
            padding: 2.5rem;
            text-align: center;
            padding-top: 3rem; 
            text-align: right;
        }

        .certficate-content h2 {
            color: #047580;
            font-size: 2.75rem;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
            letter-spacing: 0.1375rem;
        }

        .certficate-content h5.badge {
            color: #1E7878;
            font-size: 1.5rem;
            font-style: normal;
            font-weight: 500;
            line-height: normal;
            letter-spacing: 0.05rem;
            font-family: Poppins;  
        }

        .certficate-content h6 {
            color: var(--neutral-color-neutral-70, #2F3A4C);
            font-size: 1.125rem;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
            margin-top: 2rem;
        }

        .name-box h1 {
            color: #047580;
            font-size: 2rem;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
            letter-spacing: 0.29rem;
            text-transform: uppercase;   
        } 

        .details { 
            text-align: right; 
            margin-top: 16px;
            min-height: 6rem;
            width: 90%;
            margin-left: auto;
        }

        .details p {
            color: var(--neutral-color-neutral-70, #2F3A4C);
            font-size: 1.125rem;
            font-style: normal;
            line-height: 100%;
            font-weight: 400;
        }

        .course-date{ 
            position: absolute;
            right: -8rem;
            bottom: 9.2rem; 
            text-align: center; 
            width: 30%;
        } 
        .signature {
            position: absolute;
            left: 5rem;
            bottom: 9.4rem; 
            text-align: center; 
            width: 30%; 
        }

        .course-date p{
            color: var(--neutral-color-neutral-70, #2F3A4C);
            font-size: 14px;
            font-style: normal;
            font-weight: 500;
            line-height: 120%;
            font-family: Poppins;
            display: inline-block;
            border-top: 1px solid #314E85; 
            padding-left: 1rem;
            padding-right: 1rem;
            min-width: 10rem;
        }
        .signature p {
            color: var(--neutral-color-neutral-70, #2F3A4C);
            font-size: 14px;
            font-style: normal;
            font-weight: 500;
            line-height: 120%;
            font-family: Poppins;
            display: inline-block;
            border-top: 1px solid #314E85; 
            padding-left: 1rem;
            padding-right: 1rem;
            min-width: 12.25rem;
        }

        .course-date h5{
            color: var(--neutral-color-neutral-70, #2F3A4C);
            font-size: 1rem;
            font-style: normal;
            font-weight: 500;
            line-height: 150%;
            font-family: Poppins;
            padding-bottom: 0.5rem;
        }

        .signature img {
            mix-blend-mode: darken;
            max-width: 6.375rem;
            max-height: 4.875rem;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        .logo-area{
            position: absolute;
            left: 5rem;
            top: 5rem;
            z-index: 999;
        }
        .logo-area img{
            max-width: 9rem;
            max-height: 2.6875rem; 
            object-fit: contain;
        }
        .asset-area{
            position: absolute;
            right: 5rem;
            top: 0rem;
            z-index: 999;
        }
        .clr{
            clear: both;
        }
       
        @page { size: 842px 590px }

    </style>
</head>
<body> 

    <div class="main-wrapper">
        <div class="container">
            <div class="main-bg">
                <img src="{{ public_path('assets/images/certificate/two/two.png') }}" alt="Certificate-bg" class="img-fluid main-certificate">
            </div>
            <div class="logo-area">
                @if (!empty($logo))
                    <img src="{{ public_path($logo) }}" alt="Logo" class="img-fluid">   
                @else 
                    <img src="{{ public_path('assets/images/certificate/two/logo.png') }}" alt="Logo" class="img-fluid">
                @endif 
            </div>
            <div class="asset-area">
                <img src="{{ public_path('assets/images/certificate/two/checkmark.png') }}" alt="CHK" class="img-fluid">
            </div>
            <div class="certficate-content">
                <h2>CERTIFICATE</h2>
                <h5 class="badge">OF ACHIEVEMENT</h5>
                <h6>This is certify that</h6> 
                <div class="name-box">
                    <h1>{{ $fullName }}</h1>
                </div>
                <div class="details">
                    <p>has successfully completed the {{$course->title}} Course on {{ date('d M Y', strtotime($courseCompletionDate)) }} through
                        Learncosy.</p>
                </div>
                <div class="signature">
                    @if (!empty($signature))
                    <img src="{{ public_path($signature) }}" alt="Logo" class="img-fluid">   
                    @else 
                        <img src="{{ public_path('assets/images/certificate/two/signature.png') }}" alt="Logo" class="img-fluid">
                    @endif

                    <p>INSTRUCTOR SIGNATURE</p>
                </div>

                <div class="course-date">
                    <h5>{{ date('d M Y', strtotime($courseIssueDate)) }}</h5>
                    <p>DATE</p>

                </div>
                
            </div>

        </div>
    </div>

</body>

</html>