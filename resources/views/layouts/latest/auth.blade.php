<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <title>AI for Advertising Bootcamp '25 | @yield('title')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta content="Future-Proof Your Career. Master AI for Ads." name="description" />
  <meta content="AI for Advertising Bootcamp '25" name="author" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="The only bootcamp that teaches you practical AI skills for every aspect of advertising.">
  <meta property="og:title" content="AI for Advertising Bootcamp '25">
  <meta property="og:type" content="website">
  <meta property="og:url" content="">
  <meta property="og:image" content="">
  <meta name="theme-color" content="#0F172A">

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- App favicon -->
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  @yield('style')
  
  <style>
    /* AI for Advertising Bootcamp '25 Auth Styles */
    :root {
        --primary-navy: #0F172A;
        --primary-text: #FFFFFF;
        --accent-cyan: #00D4FF;
        --accent-teal: #2DD4BF;
        --secondary-bg: #F1F5F9;
        --gradient-primary: linear-gradient(90deg, #00D4FF, #2DD4BF);
        --glass-bg: rgba(255, 255, 255, 0.15);
        --glass-border: rgba(255, 255, 255, 0.2);
    }

    * {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    }

    body {
        background: var(--primary-navy);
        color: var(--primary-text);
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }

    .auth-header {
        background: var(--primary-navy);
        border-bottom: 1px solid rgba(0, 212, 255, 0.2);
        padding: 1rem 0;
    }

    .auth-brand {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-text);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .ai-logo {
        background: var(--gradient-primary);
        color: var(--primary-navy);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
    }

    .auth-container {
        min-height: calc(100vh - 80px);
        display: flex;
        align-items: center;
        padding: 2rem 0;
    }

    .auth-card {
        background: var(--secondary-bg);
        border-radius: 16px;
        padding: 3rem;
        box-shadow: 0 20px 60px rgba(0, 212, 255, 0.1);
        border: 1px solid rgba(0, 212, 255, 0.1);
        max-width: 450px;
        width: 100%;
        margin: 0 auto;
    }

    .auth-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-navy);
        margin-bottom: 0.5rem;
        text-align: center;
    }

    .auth-subtitle {
        color: var(--primary-navy);
        opacity: 0.8;
        text-align: center;
        margin-bottom: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        font-weight: 600;
        color: var(--primary-navy);
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control {
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 1rem;
        color: var(--primary-navy);
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--accent-cyan);
        box-shadow: 0 0 0 3px rgba(0, 212, 255, 0.1);
        background: white;
        color: var(--primary-navy);
    }

    .form-control::placeholder {
        color: #94a3b8;
    }

    .btn-submit {
        background: var(--accent-cyan);
        border: none;
        color: var(--primary-navy);
        padding: 14px 28px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        width: 100%;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 212, 255, 0.4);
        color: var(--primary-navy);
    }

    .auth-links {
        text-align: center;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #e2e8f0;
    }

    .auth-links a {
        color: var(--accent-cyan);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .auth-links a:hover {
        color: var(--accent-teal);
    }

    .form-check-label {
        color: var(--primary-navy);
        opacity: 0.8;
    }

    .form-check-input:checked {
        background-color: var(--accent-cyan);
        border-color: var(--accent-cyan);
    }

    .forgot-password {
        color: var(--accent-cyan);
        text-decoration: none;
        font-size: 0.9rem;
        transition: color 0.3s ease;
    }

    .forgot-password:hover {
        color: var(--accent-teal);
    }

    .alert {
        border-radius: 8px;
        border: none;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background: rgba(34, 197, 94, 0.1);
        color: #059669;
    }

    .alert-danger {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
    }

    .password-field-wrapper {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #94a3b8;
        transition: color 0.3s ease;
    }

    .password-toggle:hover {
        color: var(--primary-navy);
    }

    .social-login {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e2e8f0;
        text-align: center;
    }

    .social-login a {
        color: var(--accent-teal);
        text-decoration: none;
        margin: 0 0.5rem;
        font-weight: 500;
    }

    .social-login a:hover {
        color: var(--accent-cyan);
    }

    @media (max-width: 768px) {
        .auth-card {
            padding: 2rem;
            margin: 1rem;
        }
        
        .auth-title {
            font-size: 1.75rem;
        }
    }
  </style>

</head>

<body>

  {{-- header start --}}
  <header class="auth-header">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-12">
          <a href="{{url('/')}}" class="auth-brand">
            <div class="ai-logo">AI</div>
            AI for Advertising Bootcamp '25
          </a>
        </div>
      </div>
    </div>
  </header>
  {{-- header end --}}

  {{-- auth content --}}
  <div class="auth-container">
    <div class="container">
      @yield('content')
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  @yield('script')

</body>

</html>
