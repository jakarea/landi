<!DOCTYPE html>
<html>

<head>
    <title>Certificate of Completion</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&family=Rakkas&display=swap" rel="stylesheet">

    <style>
        
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
            width: 845px; 
            position: absolute;
            left: 0;
            top: 24%;
            z-index: 9999;
            padding: 2.5rem;
            text-align: center;
            padding-top: 6rem; 
        } 

        .certficate-content h6 {
            color: var(--neutral-color-neutral-70, #2F3A4C);
            font-size: 1.125rem;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
            margin-top: 3rem;
        }

        .name-box h1 {
            color: #4F8AC0;
            font-size: 2rem;
            font-style: normal;
            font-weight: 400;
            line-height: normal; 
            text-transform: uppercase;  
        } 

        .details {
            width: 70%;
            margin: 0 auto;
            text-align: center; 
            margin-top: 16px;
            min-height: 6rem
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
            right: 1rem;
            bottom: -3rem; 
            text-align: center; 
            width: 30%;
        } 
        .signature {
            position: absolute;
            left: 4rem;
            bottom: -3rem; 
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
            padding-top: 10px;
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
            padding-top: 10px;
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
            left: 6rem;
            top: 6rem;
            z-index: 999;
        }
        .logo-area img{
            max-width: 9rem;
            max-height: 2.6875rem; 
            object-fit: contain;
        }
        .asset-area{
            position: absolute;
            right: 2rem;
            top: 6rem;
            z-index: 999;
        } 
       
        @page { size: 980px 650px }

    </style>
</head>
<body> 

    <div class="main-wrapper">
        <div class="container">
            <div class="main-bg">
                <img src="{{ asset('assets/images/certificate/three/three.png') }}" alt="Certificate-bg"
                    class="img-fluid main-certificate">
            </div>
            <div class="logo-area">
                @if (!empty($logo))
                    <img src="{{ asset($logo) }}" alt="Logo" class="img-fluid">   
                @else 
                    <img src="{{ asset('assets/images/certificate/three/logo.png') }}" alt="Logo" class="img-fluid">
                @endif 
            </div>
            <div class="asset-area">
                <img src="{{ asset('assets/images/certificate/three/checkmark.png') }}" alt="CHK" class="img-fluid">
            </div>
            <div class="certficate-content">
                
                <h6>This is certify that</h6> 

                <div class="name-box">
                    <h1>{{ Auth::user()->name }}</h1>
                </div>

                <div class="details">
                    <p>has successfully completed the {{$course->title}} Course on {{ date('d M Y', strtotime($courseDate)) }} through
                        Learncosy.</p>
                </div>
 
                <div class="signature">
                    @if (!empty($signature))
                    <img src="{{ asset($signature) }}" alt="Logo" class="img-fluid">   
                    @else 
                        <img src="{{ asset('assets/images/certificate/three/signature.png') }}" alt="Logo" class="img-fluid">
                    @endif

                    <p>INSTRUCTOR SIGNATURE</p>
                </div>

                <div class="course-date">
                    <h5>{{ date('d M Y') }}</h5>
                    <p>DATE</p>
                </div>

            </div>

        </div>
    </div>

</body>

</html>