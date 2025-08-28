<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AI for Advertising Bootcamp \'25 - Future-Proof Your Career')</title>
    <meta name="description" content="Master AI for advertising. The only bootcamp teaching practical AI skills for every aspect of advertising.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    @yield('style')
    
    <style>
        /* AI for Advertising Bootcamp '25 Brand Navigation */
        .modern-navbar {
            background: #0F172A;
            border-bottom: 1px solid rgba(0, 212, 255, 0.2);
            padding: 1rem 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .modern-navbar.scrolled {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
            box-shadow: 0 4px 30px rgba(0, 212, 255, 0.2);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: #FFFFFF !important;
            text-decoration: none !important;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .ai-logo {
            background: linear-gradient(90deg, #00D4FF, #2DD4BF);
            color: #0F172A;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
        }

        .navbar-nav .nav-link {
            color: #FFFFFF !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            margin: 0 0.25rem;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            background: #00D4FF;
            color: #0F172A !important;
            transform: translateY(-1px);
        }

        .auth-buttons {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn-login {
            background: transparent;
            border: 2px solid #2DD4BF;
            color: #2DD4BF;
            padding: 10px 24px;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: #2DD4BF;
            color: #0F172A;
            transform: translateY(-1px);
        }

        .btn-register {
            background: #00D4FF;
            border: none;
            color: #0F172A;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 212, 255, 0.4);
            color: #0F172A;
        }

        .dashboard-link {
            background: linear-gradient(90deg, #00D4FF, #2DD4BF);
            border: none;
            color: #0F172A;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .dashboard-link:hover {
            transform: translateY(-1px);
            color: #0F172A;
            box-shadow: 0 6px 20px rgba(0, 212, 255, 0.3);
        }

        /* Main content padding to account for fixed navbar */
        body {
            padding-top: 80px;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        /* Footer */
        .modern-footer {
            background: #0F172A;
            color: #FFFFFF;
            padding: 4rem 0 2rem;
            margin-top: 5rem;
            border-top: 1px solid rgba(0, 212, 255, 0.1);
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-section h5 {
            color: #FFFFFF;
            margin-bottom: 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .footer-section p,
        .footer-section a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            line-height: 1.6;
            transition: color 0.3s ease;
        }

        .footer-section a:hover {
            color: #00D4FF;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 2rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(0, 212, 255, 0.1);
            border-radius: 8px;
            color: #00D4FF;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: #00D4FF;
            color: #0F172A;
            transform: translateY(-2px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.3rem;
            }
            
            .auth-buttons {
                flex-direction: column;
                gap: 0.5rem;
                width: 100%;
            }
            
            .btn-login,
            .btn-register,
            .dashboard-link {
                width: 100%;
                text-align: center;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <!-- Modern Navigation -->
    <nav class="navbar navbar-expand-lg modern-navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <div class="ai-logo">AI</div>
                AI for Advertising Bootcamp '25
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-bars" style="color: #FFFFFF;"></i>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-4">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">
                            Features
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">
                            About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">
                            Contact
                        </a>
                    </li>
                </ul>
                
                <div class="auth-buttons">
                    @auth
                        @if(auth()->user()->user_role === 'student')
                            <a href="{{ route('students.dashboard') }}" class="dashboard-link">
                                <i class="fas fa-tachometer-alt"></i>
                                Dashboard
                            </a>
                        @elseif(auth()->user()->user_role === 'instructor')
                            <a href="{{ route('instructor.dashboard') }}" class="dashboard-link">
                                <i class="fas fa-chalkboard-teacher"></i>
                                Instructor Panel
                            </a>
                        @endif
                        
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                           class="btn-login">
                            <i class="fas fa-sign-out-alt me-1"></i>
                            Logout
                        </a>
                        
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn-login">
                            Add your email
                        </a>
                        <a href="{{ route('register') }}" class="btn-register">
                            Join Now
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="modern-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h5>
                        <div class="ai-logo me-2" style="width: 30px; height: 30px; font-size: 0.8rem; display: inline-flex;">AI</div>
                        AI for Advertising Bootcamp '25
                    </h5>
                    <p>
                        Future-Proof Your Career. Master AI for Ads. 
                        The only bootcamp that teaches you practical AI skills for every aspect of advertising.
                    </p>
                </div>
                
                <div class="footer-section">
                    <h5>Quick Links</h5>
                    <div class="d-flex flex-column gap-2">
                        <a href="#about">About</a>
                        <a href="#courses">Courses</a>
                        <a href="#instructors">Instructors</a>
                        <a href="#contact">Contact</a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h5>Learning</h5>
                    <div class="d-flex flex-column gap-2">
                        <a href="#practical-projects">Practical Projects</a>
                        <a href="#actionable-skills">Actionable Skills</a>
                        <a href="#real-world">Real-World Applications</a>
                        <a href="#certification">Certification</a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h5>Connect</h5>
                    <div class="d-flex flex-column gap-2">
                        <p><i class="fas fa-envelope me-2"></i> info@aibootcamp.com</p>
                        <p><i class="fas fa-globe me-2"></i> www.aibootcamp.com</p>
                        <div class="social-links mt-3">
                            <a href="#" class="me-2"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="me-2"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="me-2"><i class="fab fa-facebook"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} AI for Advertising Bootcamp '25. All rights reserved. Built with cutting-edge technology.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Scripts -->
    <script>
        // Add scrolled class to navbar on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.modern-navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
    
    @yield('script')
</body>
</html>