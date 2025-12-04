<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>পাসওয়ার্ড সেটআপ - AI Bootcamp</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">

    <!-- Fonts -->
     <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@100..900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { 
            font-family: "Noto Sans Bengali", sans-serif;
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .setup-card {
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 2rem;
            max-width: 500px;
            width: 100%;
            backdrop-filter: blur(10px);
        }

        .btn-primary {
            background: linear-gradient(90deg, #00D4FF, #2DD4BF);
            border: none;
            padding: 12px 32px;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #0EA5E9, #14B8A6);
            transform: translateY(-1px);
        }

        .form-control {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: white;
            padding: 12px 16px;
        }

        .form-control:focus {
            background: rgba(0, 0, 0, 0.4);
            border-color: #00D4FF;
            box-shadow: 0 0 0 0.2rem rgba(0, 212, 255, 0.25);
            color: white;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .text-primary {
            color: #00D4FF !important;
        }

        .alert {
            border: none;
            border-radius: 8px;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.2);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #22C55E;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #EF4444;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="setup-card">
                    <div class="text-center mb-4">
                        <i class="fas fa-lock text-primary mb-3" style="font-size: 3rem;"></i>
                        <h2 class="text-white mb-2">পাসওয়ার্ড সেটআপ</h2>
                        <p class="text-white-50">আপনার অ্যাকাউন্টের জন্য একটি নিরাপদ পাসওয়ার্ড তৈরি করুন</p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            @foreach($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('student.setup-password.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label text-white">আপনার নাম</label>
                            <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label text-white">ইমেইল</label>
                            <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label text-white">নতুন পাসওয়ার্ড</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="কমপক্ষে ৬ অক্ষরের পাসওয়ার্ড" required>
                            <div class="form-text text-white-50">
                                <i class="fas fa-info-circle me-1"></i>
                                পাসওয়ার্ড অবশ্যই কমপক্ষে ৬ অক্ষরের হতে হবে
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label text-white">পাসওয়ার্ড নিশ্চিত করুন</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="পাসওয়ার্ড পুনরায় লিখুন" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                পাসওয়ার্ড সেট করুন
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <small class="text-white-50">
                                পাসওয়ার্ড সেট করার পর আপনি আপনার কোর্সে অ্যাক্সেস পাবেন
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>