@php use Illuminate\Support\Facades\Request; @endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <title>'শিখুন' | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Student Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                            950: '#172554',
                        },
                        dark: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                            950: '#020617',
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <style>
        .font-inter { font-family: 'Inter', sans-serif; }
        
        .ray-hover {
            position: relative;
            overflow: hidden;
        }
        
        .ray-hover::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.8s ease-in-out;
            z-index: 1;
            pointer-events: none;
        }
        
        .ray-hover:hover::before {
            left: 100%;
        }
        
        .ray-hover > * {
            position: relative;
            z-index: 2;
        }
        
        /* Global ray-hover effect for body content */
        main a, main button, main .cursor-pointer,
        main .bg-card, main .bg-white, main .bg-primary, main .bg-secondary,
        main .rounded, main .rounded-lg, main .rounded-xl, main .rounded-md,
        main .shadow, main .card, main .btn, main .button {
            position: relative;
            overflow: hidden;
        }
        
        main a::before, main button::before, main .cursor-pointer::before,
        main .bg-card::before, main .bg-white::before, main .bg-primary::before, main .bg-secondary::before,
        main .rounded::before, main .rounded-lg::before, main .rounded-xl::before, main .rounded-md::before,
        main .shadow::before, main .card::before, main .btn::before, main .button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.8s ease-in-out;
            z-index: 1;
            pointer-events: none;
        }
        
        main a:hover::before, main button:hover::before, main .cursor-pointer:hover::before,
        main .bg-card:hover::before, main .bg-white:hover::before, main .bg-primary:hover::before, main .bg-secondary:hover::before,
        main .rounded:hover::before, main .rounded-lg:hover::before, main .rounded-xl:hover::before, main .rounded-md:hover::before,
        main .shadow:hover::before, main .card:hover::before, main .btn:hover::before, main .button:hover::before {
            left: 100%;
        }
        
        main a > *, main button > *, main .cursor-pointer > *,
        main .bg-card > *, main .bg-white > *, main .bg-primary > *, main .bg-secondary > *,
        main .rounded > *, main .rounded-lg > *, main .rounded-xl > *, main .rounded-md > *,
        main .shadow > *, main .card > *, main .btn > *, main .button > * {
            position: relative;
            z-index: 2;
        }
        
        .glow-card {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.15);
            transition: all 0.3s ease;
        }
        
        .glow-card:hover {
            box-shadow: 0 0 30px rgba(59, 130, 246, 0.25);
            transform: translateY(-2px);
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .dark .glass-effect {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        
        .sidebar-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .sidebar-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
        }
        
        .sidebar-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        
        /* Animation for sidebar toggle */
        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Animation class for hover effects */
        .anim {
            transition: all 0.3s ease;
        }
    </style>
    
    @yield('style')
    @stack('styles')
</head>

<body class="bg-gradient-to-br from-slate-50 to-blue-50 dark:from-dark-950 dark:to-dark-900 font-inter antialiased min-h-screen">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar-transition flex flex-col w-64 glass-effect shadow-xl fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-0">
                <!-- Logo -->
                <div class="flex items-center justify-center h-16 px-6 border-b border-white/10">
                    <a href="{{ route('student.dashboard') }}" class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-white text-sm"></i>
                        </div>
                        <div>
                            <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">শিখুন</span>
                            <div class="text-xs text-slate-500 dark:text-slate-400 -mt-1">শিক্ষার্থী</div>
                        </div>
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto sidebar-scrollbar">
                    <!-- Dashboard -->
                    <a href="{{ route('student.dashboard') }}" 
                       class="flex items-center gap-3 px-4 py-3 text-slate-700 dark:text-slate-300 rounded-lg anim hover:bg-white/10 dark:hover:bg-slate-800/50 hover:text-blue-500 ray-hover {{ Request::is('student') || Request::is('student/') ? 'bg-white/10 dark:bg-slate-800/50 text-blue-500' : '' }}">
                        <i class="fas fa-tachometer-alt text-lg flex-shrink-0"></i>
                        <span class="font-medium">ড্যাশবোর্ড</span>
                    </a>

                    <!-- My Courses -->
                    <a href="{{ route('student.courses') }}" 
                       class="flex items-center gap-3 px-4 py-3 text-slate-700 dark:text-slate-300 rounded-lg anim hover:bg-white/10 dark:hover:bg-slate-800/50 hover:text-blue-500 ray-hover {{ Request::is('student/courses*') ? 'bg-white/10 dark:bg-slate-800/50 text-blue-500' : '' }}">
                        <i class="fas fa-book-open text-lg flex-shrink-0"></i>
                        <span class="font-medium">আমার কোর্স</span>
                    </a>


                    <!-- Certificates -->
                    <a href="{{ route('student.certificates') }}" 
                       class="flex items-center gap-3 px-4 py-3 text-slate-700 dark:text-slate-300 rounded-lg anim hover:bg-white/10 dark:hover:bg-slate-800/50 hover:text-blue-500 ray-hover {{ Request::is('student/certificates*') ? 'bg-white/10 dark:bg-slate-800/50 text-blue-500' : '' }}">
                        <i class="fas fa-certificate text-lg flex-shrink-0"></i>
                        <span class="font-medium">অর্জিত সার্টিফিকেট</span>
                    </a>

                    <hr class="border-white/10 my-4">
 <!-- Device Management -->
                    <a href="{{ route('devices.index') }}" 
                       class="flex items-center gap-3 px-4 py-3 text-slate-700 dark:text-slate-300 rounded-lg anim hover:bg-white/10 dark:hover:bg-slate-800/50 hover:text-blue-500 ray-hover {{ Request::is('devices*') ? 'bg-white/10 dark:bg-slate-800/50 text-blue-500' : '' }}">
                        <i class="fas fa-mobile-alt text-lg flex-shrink-0"></i>
                        <span class="font-medium">ডিভাইস ম্যানেজমেন্ট</span>
                    </a>
                    <!-- Profile -->
                    <a href="{{ route('student.profile') }}" 
                       class="flex items-center gap-3 px-4 py-3 text-slate-700 dark:text-slate-300 rounded-lg anim hover:bg-white/10 dark:hover:bg-slate-800/50 hover:text-blue-500 ray-hover {{ Request::is('student/profile') && !Request::is('student/profile/*') ? 'bg-white/10 dark:bg-slate-800/50 text-blue-500' : '' }}">
                        <i class="fas fa-user text-lg flex-shrink-0"></i>
                        <span class="font-medium">প্রোফাইল</span>
                    </a>

                   

                </nav>

                <!-- Sidebar Footer -->
                <div class="p-4 border-t border-white/10">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 w-full cursor-pointer px-4 py-3 text-slate-700 dark:text-slate-300 rounded-xl hover:bg-red-800 hover:text-white transition-all duration-300 ray-hover">
                            <i class="fas fa-sign-out-alt text-lg flex-shrink-0"></i>
                            <span class="font-medium">লগআউট</span>
                        </button>
                    </form>
                </div>
        </div>

        <!-- Mobile sidebar overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:ml-0">
            <!-- Header -->
            <header class="sticky top-0 z-30 glass-effect border-b border-white/10 h-16">
                <div class="flex items-center justify-between h-full px-6">
                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-btn" class="lg:hidden p-2 rounded-lg hover:bg-white/10 dark:hover:bg-slate-800/50 transition-colors ray-hover">
                        <i class="fas fa-bars text-slate-700 dark:text-slate-300"></i>
                    </button>

                    <!-- Search Bar -->
                    <div class="hidden md:flex flex-1 max-w-md mx-4">
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-slate-400 text-sm"></i>
                            </div>
                            <input type="text" placeholder="কোর্স খুঁজুন..." 
                                   class="w-full pl-10 pr-4 py-2 bg-white/10 dark:bg-slate-800/50 border border-white/20 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 text-sm transition-all duration-300 ray-hover">
                        </div>
                    </div>

                    <!-- Right Side -->
                    <div class="flex items-center space-x-4">
                        <!-- Theme Toggle -->
                        <div class="relative">
                            <button id="theme-toggle" class="p-2 rounded-lg hover:bg-white/10 dark:hover:bg-slate-800/50 transition-colors ray-hover">
                                <i id="theme-icon" class="fas fa-sun text-slate-700 dark:text-slate-300"></i>
                            </button>
                        </div>
                        
                        <!-- Notifications -->
                        <a href="{{ route('student.notifications') }}" class="relative p-2 rounded-lg hover:bg-white/10 dark:hover:bg-slate-800/50 transition-colors ray-hover">
                            <i class="fas fa-bell text-slate-700 dark:text-slate-300"></i>
                            @if (Auth::check() && function_exists('unseenNotification') && unseenNotification() >= 1)
                                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            @endif
                        </a>

                        <!-- Profile Link -->
                        <a href="{{ route('student.profile') }}" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-white/10 dark:hover:bg-slate-800/50 transition-colors ray-hover">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset(auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" 
                                     class="w-8 h-8 rounded-full object-cover border-2 border-blue-500">
                            @else
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="hidden md:block text-left">
                                <div class="text-sm font-medium text-slate-900 dark:text-white">{{ auth()->user()->name }}</div>
                                <div class="text-xs text-slate-500 dark:text-slate-400">শিক্ষার্থী</div>
                            </div>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Initialize dark mode - default is dark mode as per instructions
        document.documentElement.classList.add('dark');
        
        // Theme toggle functionality
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const root = document.documentElement;

        // Check for saved theme preference or default to dark
        const currentTheme = localStorage.getItem('theme') || 'dark';
        
        // Apply theme on page load
        if (currentTheme === 'light') {
            root.classList.remove('dark');
            themeIcon.classList.remove('fa-sun');
            themeIcon.classList.add('fa-moon');
        } else {
            root.classList.add('dark');
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
        }

        // Theme toggle event listener
        themeToggle.addEventListener('click', () => {
            root.classList.toggle('dark');
            
            if (root.classList.contains('dark')) {
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
                localStorage.setItem('theme', 'dark');
            } else {
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
                localStorage.setItem('theme', 'light');
            }
        });
        
        // Sidebar toggle functionality
        const sidebar = document.getElementById('sidebar');
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const overlay = document.getElementById('sidebar-overlay');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
        
        mobileMenuBtn?.addEventListener('click', toggleSidebar);
        overlay?.addEventListener('click', toggleSidebar);

        // Close sidebar when clicking on links (mobile)
        const sidebarLinks = sidebar.querySelectorAll('nav a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    toggleSidebar();
                }
            });
        });

        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
            }
        });
        
        
        // Confirmation prompts for delete buttons
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('button[type="submit"]');
            deleteButtons.forEach(button => {
                const buttonText = button.textContent.trim();
                if (buttonText.includes('অপছন্দ') || buttonText.includes('Delete') || buttonText.includes('delete') || buttonText.includes('মুছুন')) {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        if (confirm('আপনি কি নিশ্চিত যে এই কার্যক্রমটি সম্পাদন করতে চান?')) {
                            this.closest('form').submit();
                        }
                    });
                }
            });
            
        });
    </script>
    
    @yield('script')
    @stack('scripts')
</body>
</html>