@php use Illuminate\Support\Facades\Request; @endphp
<nav class="navbar navbar-expand-xl header-area">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">
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
                        <a href="{{ url('/') }}" class="{{ Request::is('/') ? ' active' : '' }} nav-link">
                            <i class="fas fa-home me-1"></i>
                            হোম
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('student/dashboard/enrolled') }}" class="{{ Request::is('student/dashboard/enrolled*') ? ' active' : '' }} nav-link">
                            <i class="fas fa-book-open me-1"></i>
                            আমার কোর্স
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('student/achievements') }}" class="{{ Request::is('student/achievements*') ? ' active' : '' }} nav-link">
                            <i class="fas fa-trophy me-1"></i>
                            অর্জনসমূহ
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i>
                            প্রোফাইল
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ Request::is('student/profile/myprofile*') ? ' active' : '' }}" 
                                   href="{{ url('student/profile/myprofile') }}">
                                   <i class="fas fa-user-circle me-2"></i>
                                   আমার প্রোফাইল
                               </a></li>
                            <li><a class="dropdown-item {{ Request::is('student/profile/edit*') ? ' active' : '' }}" 
                                   href="{{ url('student/profile/edit') }}">
                                   <i class="fas fa-cog me-2"></i>
                                   একাউন্ট সেটিং
                               </a></li>
                            <li><a class="dropdown-item {{ Request::is('student/courses-certificate*') ? ' active' : '' }}" 
                                   href="{{ url('student/courses-certificate') }}">
                                   <i class="fas fa-certificate me-2"></i>
                                   সার্টিফিকেট
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
                <a href="{{ url('student/dashboard') }}" class="bttn" title="ড্যাশবোর্ড">
                    <i class="fas fa-tachometer-alt"></i>
                </a>
                <a href="{{ url('student/notification-details') }}"
                   class="bttn {{ Request::is('student/notification-details*') ? ' active' : '' }}" 
                   title="নোটিফিকেশন">
                    <i class="fas fa-bell"></i>
                    @if (Auth::user() && function_exists('unseenNotification') && unseenNotification() >= 1)
                        <span>{{ unseenNotification() }}</span>
                    @endif
                </a>
                <div class="dropdown">
                    <button class="btn avatar" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @if (Auth::user() && auth()->user()->avatar)
                            <img src="{{ asset(auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="img-fluid">
                        @else
                            <span class="avatar-user">{!! Auth::user() && strtoupper(auth()->user()->name[0]) !!}</span>
                        @endif
                    </button>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">
                            <strong>{{ auth()->user() && auth()->user()->name }}</strong><br>
                            <small class="text-muted">শিক্ষার্থী</small>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ url('student/dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            ড্যাশবোর্ড
                        </a></li>
                        <li><a class="dropdown-item" href="{{ url('student/profile/myprofile') }}">
                            <i class="fas fa-user-circle me-2"></i>
                            আমার প্রোফাইল
                        </a></li>
                        <li><a class="dropdown-item" href="{{ url('student/achievements') }}">
                            <i class="fas fa-trophy me-2"></i>
                            অর্জনসমূহ
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
            </div>
        </div>
    </div>
</nav>