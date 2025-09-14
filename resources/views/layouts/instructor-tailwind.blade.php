<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ইনস্ট্রাক্টর ড্যাশবোর্ড - শিখুন প্ল্যাটফর্ম')</title>
    <meta name="description" content="ইনস্ট্রাক্টর ড্যাশবোর্ড - আপনার কোর্স ও শিক্ষার্থী ম্যানেজ করুন">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/css/tailwind.css', 'resources/js/app.js'])
    
    <!-- Custom Styles -->
    @yield('style')
    
    <style>
        /* Override any conflicting styles */
        * {
            box-sizing: border-box;
        }
        
        body {
            font-family: "Hind Siliguri", sans-serif !important;
            background-color: #091D3D !important;
            margin: 0;
            padding: 0;
        }
        
        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #0F2342;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #5AEAF4;
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #CBFB90;
        }
        
        /* Animation for sidebar toggle */
        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Ray hover effect */
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
    </style>
</head>

<body class="bg-body antialiased min-h-screen">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar-transition flex flex-col w-64 bg-primary shadow-xl fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-0">
            <!-- Sidebar Header -->
            <div class="flex items-center justify-center h-16 px-4 border-b border-white/20 flex-shrink-0">
                <div class="flex items-center gap-3 p-2">
                    <!-- Logo with dark/light mode -->
                    <img 
                        src="{{ url('assets/images/roufai-logo-dark.png') }}" 
                        alt="Logo" 
                        class="h-10 w-auto p-2 m-2 block dark:hidden"
                    >
                    <img 
                        src="{{ url('assets/images/roufai-logo-light.png') }}" 
                        alt="Logo" 
                        class="h-10 w-auto p-2 m-2 hidden dark:block"
                    >
                </div>
            </div>

            
            <!-- Sidebar Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="{{ route('instructor.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 text-secondary-100 rounded-lg anim hover:bg-card hover:text-blue ray-hover {{ request()->routeIs('instructor.dashboard') ? 'bg-card text-blue' : '' }}">
                    <i class="fas fa-tachometer-alt text-lg flex-shrink-0"></i>
                    <span class="font-medium">ড্যাশবোর্ড</span>
                </a>
                
                <a href="{{ route('instructor.courses') }}" 
                   class="flex items-center gap-3 px-4 py-3 text-secondary-100 rounded-lg anim hover:bg-card hover:text-blue ray-hover {{ request()->routeIs('instructor.courses*') ? 'bg-card text-blue' : '' }}">
                    <i class="fas fa-book text-lg flex-shrink-0"></i>
                    <span class="font-medium">কোর্স সমূহ</span>
                </a>
                
                <a href="{{ route('instructor.courses.create') }}" 
                   class="flex items-center gap-3 px-4 py-3 text-secondary-100 rounded-lg anim hover:bg-card hover:text-blue ray-hover {{ request()->routeIs('instructor.courses.create*') ? 'bg-card text-blue' : '' }}">
                    <i class="fas fa-plus-circle text-lg flex-shrink-0"></i>
                    <span class="font-medium">নতুন কোর্স</span>
                </a>
                
                <a href="{{ route('instructor.students') }}" 
                   class="flex items-center gap-3 px-4 py-3 text-secondary-100 rounded-lg anim hover:bg-card hover:text-blue ray-hover {{ request()->routeIs('instructor.students*') ? 'bg-card text-blue' : '' }}">
                    <i class="fas fa-users text-lg flex-shrink-0"></i>
                    <span class="font-medium">শিক্ষার্থীগণ</span>
                </a>
                
                <a href="{{ route('instructor.earnings') }}" 
                   class="flex items-center gap-3 px-4 py-3 text-secondary-100 rounded-lg anim hover:bg-card hover:text-blue ray-hover {{ request()->routeIs('instructor.earnings*') ? 'bg-card text-blue' : '' }}">
                    <i class="fas fa-dollar-sign text-lg flex-shrink-0"></i>
                    <span class="font-medium">আয় বিবরণী</span>
                </a>
                
                <a href="{{ route('instructor.enrollments') }}" 
                   class="flex items-center gap-3 px-4 py-3 text-secondary-100 rounded-lg anim hover:bg-card hover:text-blue ray-hover {{ request()->routeIs('instructor.enrollments*') ? 'bg-card text-blue' : '' }}">
                    <i class="fas fa-user-check text-lg flex-shrink-0"></i>
                    <span class="font-medium">ভর্তির অনুমোদন</span>
                </a>
                
                <a href="{{ route('instructor.certificates') }}" 
                   class="flex items-center gap-3 px-4 py-3 text-secondary-100 rounded-lg anim hover:bg-card hover:text-blue ray-hover {{ request()->routeIs('instructor.certificates*') ? 'bg-card text-blue' : '' }}">
                    <i class="fas fa-certificate text-lg flex-shrink-0"></i>
                    <span class="font-medium">সার্টিফিকেট</span>
                </a>
                
                <a href="{{ route('instructor.coupons') }}" 
                   class="flex items-center gap-3 px-4 py-3 text-secondary-100 rounded-lg anim hover:bg-card hover:text-blue ray-hover {{ request()->routeIs('instructor.coupons*') ? 'bg-card text-blue' : '' }}">
                    <i class="fas fa-tags text-lg flex-shrink-0"></i>
                    <span class="font-medium">কুপন কোড</span>
                </a>
                
                <a href="{{ route('instructor.profile') }}" 
                   class="flex items-center gap-3 px-4 py-3 text-secondary-100 rounded-lg anim hover:bg-card hover:text-blue ray-hover {{ request()->routeIs('instructor.profile*') ? 'bg-card text-blue' : '' }}">
                    <i class="fas fa-user-cog text-lg flex-shrink-0"></i>
                    <span class="font-medium">প্রোফাইল সেটিংস</span>
                </a>
                
            </nav>
            
            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-[#fff]/20 flex-shrink-0">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full cursor-pointer px-4 py-3 text-secondary-100 rounded-lg anim hover:bg-red-800 hover:text-white ray-hover">
                        <i class="fas fa-sign-out-alt text-lg flex-shrink-0"></i>
                        <span class="font-medium">লগআউট</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Sidebar overlay for mobile -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col overflow-hidden lg:ml-0">
            <!-- Top Header -->
            <header class="bg-card border-b border-[#fff]/20 px-4 py-4 lg:px-6 flex-shrink-0">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <button id="sidebar-toggle" class="lg:hidden p-2 text-secondary-100 hover:text-blue anim ray-hover">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        
                        <div>
                            <h1 class="text-white font-semibold text-xl">@yield('header-title', 'ড্যাশবোর্ড')</h1>
                            <p class="text-secondary-200 text-sm">@yield('header-subtitle', 'স্বাগতম, ' . auth()->user()->name)</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <!-- Theme Toggle -->
                        <div class="relative">
                            <button id="theme-toggle" class="p-2 text-secondary-100 hover:text-blue anim relative ray-hover">
                                <i id="theme-icon" class="fas fa-sun text-lg"></i>
                            </button>
                        </div>
                        
                        <!-- Notifications -->
                        <div class="relative">
                            <a href="{{ route('instructor.notifications') }}" class="p-2 text-secondary-100 hover:text-blue anim relative inline-block cursor-pointer ray-hover">
                                <i class="fas fa-bell text-lg"></i>
                                @if (Auth::check() && function_exists('instructorUnseenNotification') && instructorUnseenNotification() >= 1)
                                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-orange rounded-full text-primary text-xs flex items-center justify-center font-semibold">{{ instructorUnseenNotification() }}</span>
                                @endif
                            </a>
                        </div>
                        
                        <!-- User Profile -->
                        <div class="flex items-center gap-3">
                            <div class="text-right hidden sm:block">
                                <p class="text-white font-medium text-sm">{{ auth()->user()->name }}</p>
                                <p class="text-secondary-200 text-xs">ইনস্ট্রাক্টর</p>
                            </div>
                            
                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue to-lime flex items-center justify-center flex-shrink-0">
                                @if(auth()->user()->avatar)
                                    <img src="{{ asset(auth()->user()->avatar) }}" alt="Profile" class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <span class="text-primary font-semibold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-4 lg:p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Theme toggle functionality
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const root = document.documentElement;

        // Check for saved theme preference or default to dark
        const currentTheme = localStorage.getItem('theme') || 'dark';
        
        // Apply theme on page load
        if (currentTheme === 'light') {
            root.classList.add('light-theme');
            themeIcon.classList.remove('fa-sun');
            themeIcon.classList.add('fa-moon');
        } else {
            root.classList.remove('light-theme');
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
        }

        // Theme toggle event listener
        themeToggle.addEventListener('click', () => {
            root.classList.toggle('light-theme');
            
            if (root.classList.contains('light-theme')) {
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
                localStorage.setItem('theme', 'light');
            } else {
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
                localStorage.setItem('theme', 'dark');
            }
        });

        // Sidebar toggle functionality
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        }

        sidebarToggle.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', toggleSidebar);

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
                sidebarOverlay.classList.add('hidden');
            }
        });
    </script>
    
    @yield('script')
</body>
</html>