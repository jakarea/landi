@php use Illuminate\Support\Facades\Request; @endphp
<nav class="navbar navbar-expand-xl header-area">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('student.dashboard') }}">
            <i class="fas fa-graduation-cap me-2"></i>
            <span style="font-weight: 700; color: #667eea;">শিখুন</span>
            <small class="text-muted ms-2" style="font-size: 0.75rem;">শিক্ষার্থী</small>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @can('student')
                <ul class="navbar-nav m-auto">
                    <li class="nav-item">
                        <a href="{{ route('student.dashboard') }}" class="{{ Request::is('student') || Request::is('student/') ? ' active' : '' }} nav-link">
                            <i class="fas fa-tachometer-alt me-1"></i>
                            ড্যাশবোর্ড
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle {{ Request::is('student/courses*') ? ' active' : '' }}" data-bs-toggle="dropdown">
                            <i class="fas fa-graduation-cap me-1"></i>
                            কোর্স পরিচালনা
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item {{ Request::is('student/courses') || Request::is('student/courses/') ? ' active' : '' }}" 
                                   href="{{ route('student.courses') }}">
                                   <i class="fas fa-book-open me-2"></i>
                                   আমার কোর্স
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" 
                                   href="{{ route('courses') }}">
                                   <i class="fas fa-search me-2"></i>
                                   নতুন কোর্স খুঁজুন
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item {{ Request::is('student/activities*') ? ' active' : '' }}" 
                                   href="{{ route('student.activities') }}">
                                   <i class="fas fa-chart-line me-2"></i>
                                   কার্যকলাপ ও অগ্রগতি
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('student.certificates') }}" class="{{ Request::is('student/certificates*') ? ' active' : '' }} nav-link">
                            <i class="fas fa-certificate me-1"></i>
                            সার্টিফিকেট
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i>
                            প্রোফাইল
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ Request::is('student/profile') || Request::is('student/profile/') ? ' active' : '' }}" 
                                   href="{{ route('student.profile') }}">
                                   <i class="fas fa-user-circle me-2"></i>
                                   আমার প্রোফাইল
                               </a></li>
                            <li><a class="dropdown-item {{ Request::is('student/profile/edit*') ? ' active' : '' }}" 
                                   href="{{ route('student.profile.edit') }}">
                                   <i class="fas fa-cog me-2"></i>
                                   একাউন্ট সেটিং
                               </a></li>
                            <li><a class="dropdown-item {{ Request::is('student/profile/password*') ? ' active' : '' }}" 
                                   href="{{ route('student.profile.password') }}">
                                   <i class="fas fa-key me-2"></i>
                                   পাসওয়ার্ড পরিবর্তন
                               </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>
                                    লগআউট
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            @endcan
            <div class="d-flex">
                <a href="{{ route('courses') }}" class="bttn" title="কোর্স খুঁজুন">
                    <i class="fas fa-search"></i>
                </a>
                <a href="{{ route('student.notifications') }}"
                   class="bttn {{ Request::is('student/notifications*') ? ' active' : '' }}" 
                   title="নোটিফিকেশন"
                   style="cursor: pointer; text-decoration: none;">
                    <i class="fas fa-bell"></i>
                    @if (Auth::check() && function_exists('unseenNotification') && unseenNotification() >= 1)
                        <span>{{ unseenNotification() }}</span>
                    @endif
                </a>
                @auth
                <div class="dropdown">
                    <button class="btn avatar" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @if (auth()->user() && auth()->user()->avatar)
                            <img src="{{ asset(auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="img-fluid">
                        @elseif (auth()->user())
                            <span class="avatar-user">{!! strtoupper(auth()->user()->name[0]) !!}</span>
                        @else
                            <span class="avatar-user">?</span>
                        @endif
                    </button>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">
                            <strong>{{ auth()->user() ? auth()->user()->name : 'অতিথি' }}</strong><br>
                            <small class="text-muted">শিক্ষার্থী</small>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('student.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            ড্যাশবোর্ড
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('student.courses') }}">
                            <i class="fas fa-book-open me-2"></i>
                            আমার কোর্স
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('student.profile') }}">
                            <i class="fas fa-user-circle me-2"></i>
                            আমার প্রোফাইল
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('student.certificates') }}">
                            <i class="fas fa-certificate me-2"></i>
                            সার্টিফিকেট
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('student.activities') }}">
                            <i class="fas fa-trophy me-2"></i>
                            কার্যকলাপ
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form-2').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                লগআউট
                            </a>
                            <form id="logout-form-2" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
                @else
                <!-- Show login/register buttons for guest users -->
                <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">
                    <i class="fas fa-sign-in-alt me-1"></i>
                    লগইন
                </a>
                <a href="{{ route('register') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus me-1"></i>
                    রেজিস্টার
                </a>
                @endauth
            </div>
        </div>
    </div>
</nav>