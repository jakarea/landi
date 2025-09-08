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
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.8s ease-in-out;
        }
        
        .ray-hover:hover::before {
            left: 100%;
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
    </style>
    
    @yield('style')
</head>

<body class="bg-gradient-to-br from-slate-50 to-blue-50 dark:from-dark-950 dark:to-dark-900 font-inter antialiased">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 glass-effect transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out lg:static lg:inset-0">
            <div class="flex flex-col h-full">
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
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 ray-hover {{ Request::is('student') || Request::is('student/') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg' : 'text-slate-700 dark:text-slate-300 hover:bg-white/10 dark:hover:bg-slate-800/50' }}">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        ড্যাশবোর্ড
                    </a>

                    <!-- My Courses -->
                    <a href="{{ route('student.courses') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 ray-hover {{ Request::is('student/courses*') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg' : 'text-slate-700 dark:text-slate-300 hover:bg-white/10 dark:hover:bg-slate-800/50' }}">
                        <i class="fas fa-book-open mr-3"></i>
                        আমার কোর্স
                    </a>

                    <!-- Progress -->
                    <a href="{{ route('student.activities') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 ray-hover {{ Request::is('student/activities*') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg' : 'text-slate-700 dark:text-slate-300 hover:bg-white/10 dark:hover:bg-slate-800/50' }}">
                        <i class="fas fa-chart-line mr-3"></i>
                        অগ্রগতি সারাংশ
                    </a>

                    <!-- Certificates -->
                    <a href="{{ route('student.certificates') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 ray-hover {{ Request::is('student/certificates*') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg' : 'text-slate-700 dark:text-slate-300 hover:bg-white/10 dark:hover:bg-slate-800/50' }}">
                        <i class="fas fa-certificate mr-3"></i>
                        অর্জিত সার্টিফিকেট
                    </a>

                    <hr class="border-white/10 my-4">

                    <!-- Profile -->
                    <a href="{{ route('student.profile') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 ray-hover {{ Request::is('student/profile') && !Request::is('student/profile/*') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg' : 'text-slate-700 dark:text-slate-300 hover:bg-white/10 dark:hover:bg-slate-800/50' }}">
                        <i class="fas fa-user mr-3"></i>
                        প্রোফাইল
                    </a>

                    <!-- Profile Settings (Edit Profile + Password) -->
                    <a href="{{ route('student.profile.edit') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 ray-hover {{ Request::is('student/profile/edit*') || Request::is('student/profile/password*') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg' : 'text-slate-700 dark:text-slate-300 hover:bg-white/10 dark:hover:bg-slate-800/50' }}">
                        <i class="fas fa-cog mr-3"></i>
                        প্রোফাইল সেটিংস
                    </a>
                </nav>

                <!-- Bottom Section -->
                <div class="p-4 border-t border-white/10">
                    <!-- Dark Mode Toggle -->
                    <button onclick="toggleDarkMode()" class="w-full flex items-center px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-300 rounded-xl hover:bg-white/10 dark:hover:bg-slate-800/50 transition-all duration-300">
                        <i class="fas fa-moon mr-3 dark:hidden"></i>
                        <i class="fas fa-sun mr-3 hidden dark:inline"></i>
                        <span class="dark:hidden">ডার্ক মোড</span>
                        <span class="hidden dark:inline">লাইট মোড</span>
                    </button>
                </div>
            </div>
        </aside>

        <!-- Mobile sidebar overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:ml-0">
            <!-- Header -->
            <header class="sticky top-0 z-30 glass-effect border-b border-white/10 h-16">
                <div class="flex items-center justify-between h-full px-6">
                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-btn" class="lg:hidden p-2 rounded-lg hover:bg-white/10 dark:hover:bg-slate-800/50 transition-colors">
                        <i class="fas fa-bars text-slate-700 dark:text-slate-300"></i>
                    </button>

                    <!-- Search Bar -->
                    <div class="hidden md:flex flex-1 max-w-md mx-4">
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-slate-400 text-sm"></i>
                            </div>
                            <input type="text" placeholder="কোর্স খুঁজুন..." 
                                   class="w-full pl-10 pr-4 py-2 bg-white/10 dark:bg-slate-800/50 border border-white/20 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 text-sm transition-all duration-300">
                        </div>
                    </div>

                    <!-- Right Side -->
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="relative p-2 rounded-lg hover:bg-white/10 dark:hover:bg-slate-800/50 transition-colors">
                            <i class="fas fa-bell text-slate-700 dark:text-slate-300"></i>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>

                        <!-- Profile Dropdown -->
                        <div class="relative">
                            <button id="profileDropdownBtn" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-white/10 dark:hover:bg-slate-800/50 transition-colors">
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
                                <i class="fas fa-chevron-down text-slate-400 text-xs"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="profileDropdown" class="hidden absolute right-0 top-full mt-2 w-48 glass-effect rounded-xl shadow-lg border border-white/20 dark:border-slate-700 py-2 z-50">
                                <a href="{{ route('student.profile') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-white/10 dark:hover:bg-slate-800/50 transition-colors">
                                    <i class="fas fa-user mr-3"></i>
                                    আমার প্রোফাইল
                                </a>
                                <a href="{{ route('student.profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-white/10 dark:hover:bg-slate-800/50 transition-colors">
                                    <i class="fas fa-cog mr-3"></i>
                                    প্রোফাইল সেটিংস
                                </a>
                                <hr class="border-white/10 my-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                        <i class="fas fa-sign-out-alt mr-3"></i>
                                        লগআউট
                                    </button>
                                </form>
                            </div>
                        </div>
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
        
        // Dark mode toggle functionality
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
        }
        
        // Initialize from localStorage or default to dark
        if (localStorage.getItem('darkMode') === null) {
            localStorage.setItem('darkMode', 'true');
        }
        
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        
        // Mobile sidebar functionality
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const sidebar = document.querySelector('aside');
        const overlay = document.getElementById('sidebar-overlay');
        
        mobileMenuBtn?.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });
        
        overlay?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
        
        // Profile dropdown functionality
        const profileDropdownBtn = document.getElementById('profileDropdownBtn');
        const profileDropdown = document.getElementById('profileDropdown');
        
        profileDropdownBtn?.addEventListener('click', () => {
            profileDropdown.classList.toggle('hidden');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!profileDropdownBtn?.contains(e.target) && !profileDropdown?.contains(e.target)) {
                profileDropdown?.classList.add('hidden');
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
            
            // Add smooth hover animations to all ray-hover elements
            const rayHoverElements = document.querySelectorAll('.ray-hover');
            rayHoverElements.forEach(element => {
                element.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px) scale(1.02)';
                });
                element.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
        });
    </script>
    
    @yield('script')
</body>
</html>