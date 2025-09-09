@php use Illuminate\Support\Facades\Request; @endphp
<nav class="navbar navbar-expand-xl header-area">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('instructor.dashboard') }}">
            <i class="fas fa-chalkboard-teacher me-2"></i>
            <span style="font-weight: 700; color: #667eea;">শিখুন</span>
            <small class="text-muted ms-2" style="font-size: 0.75rem;">প্রশিক্ষক</small>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @can('instructor')
                <ul class="navbar-nav m-auto">
                    <li class="nav-item">
                        <a href="{{ route('instructor.dashboard') }}" class="{{ Request::is('instructor') || Request::is('instructor/') ? ' active' : '' }} nav-link">
                            <i class="fas fa-tachometer-alt me-1"></i>
                            ড্যাশবোর্ড
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle {{ Request::is('instructor/courses*') ? ' active' : '' }}" data-bs-toggle="dropdown">
                            <i class="fas fa-graduation-cap me-1"></i>
                            কোর্স পরিচালনা
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item {{ Request::is('instructor/courses') || Request::is('instructor/courses/') ? ' active' : '' }}" 
                                   href="{{ route('instructor.courses') }}">
                                   <i class="fas fa-list me-2"></i>
                                   আমার কোর্স
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ Request::is('instructor/courses/create*') ? ' active' : '' }}" 
                                   href="{{ route('instructor.courses.create') }}">
                                   <i class="fas fa-plus-circle me-2"></i>
                                   নতুন কোর্স
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" 
                                   href="{{ route('instructor.courses.logs') }}">
                                   <i class="fas fa-chart-line me-2"></i>
                                   কোর্স লগ
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('instructor.students') }}" class="{{ Request::is('instructor/students*') ? ' active' : '' }} nav-link">
                            <i class="fas fa-users me-1"></i>
                            শিক্ষার্থী
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle {{ Request::is('instructor/earnings*') || Request::is('instructor/coupons*') ? ' active' : '' }}" data-bs-toggle="dropdown">
                            <i class="fas fa-chart-bar me-1"></i>
                            বিজনেস
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item {{ Request::is('instructor/earnings*') ? ' active' : '' }}" 
                                   href="{{ route('instructor.earnings') }}">
                                   <i class="fas fa-wallet me-2"></i>
                                   আয়
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ Request::is('instructor/coupons*') ? ' active' : '' }}" 
                                   href="{{ route('instructor.coupons') }}">
                                   <i class="fas fa-tags me-2"></i>
                                   কুপন
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ Request::is('instructor/certificates*') ? ' active' : '' }}" 
                                   href="{{ route('instructor.certificates') }}">
                                   <i class="fas fa-certificate me-2"></i>
                                   সার্টিফিকেট
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle {{ Request::is('instructor/enrollments*') ? ' active' : '' }}" data-bs-toggle="dropdown">
                            <i class="fas fa-user-plus me-1"></i>
                            ভর্তি আবেদন
                            @php
                                $pendingCount = \App\Models\CourseEnrollment::where('instructor_id', auth()->id())
                                    ->where('status', 'pending')->count();
                            @endphp
                            @if($pendingCount > 0)
                                <span class="badge bg-warning ms-1">{{ $pendingCount }}</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item {{ Request::is('instructor/enrollments/pending*') ? ' active' : '' }}" 
                                   href="{{ route('instructor.enrollments.pending') }}">
                                   <i class="fas fa-check-circle me-2 text-success"></i>
                                   অনুমোদনের অপেক্ষায়
                                   @if($pendingCount > 0)
                                       <span class="badge bg-success ms-1">{{ $pendingCount }}</span>
                                   @endif
                               </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ Request::is('instructor/enrollments/payment-pending*') ? ' active' : '' }}" 
                                   href="{{ route('instructor.enrollments.payment-pending') }}">
                                   <i class="fas fa-credit-card me-2 text-warning"></i>
                                   পেমেন্ট অপেক্ষায়
                               </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ Request::is('instructor/enrollments') || Request::is('instructor/enrollments/') ? ' active' : '' }}" 
                                   href="{{ route('instructor.enrollments') }}">
                                   <i class="fas fa-list me-2"></i>
                                   সব আবেদন
                               </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i>
                            প্রোফাইল
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ Request::is('instructor/profile') || Request::is('instructor/profile/') ? ' active' : '' }}" 
                                   href="{{ route('instructor.profile') }}">
                                   <i class="fas fa-user-circle me-2"></i>
                                   আমার প্রোফাইল
                               </a></li>
                            <li><a class="dropdown-item {{ Request::is('instructor/profile/settings*') ? ' active' : '' }}" 
                                   href="{{ route('instructor.profile.settings') }}">
                                   <i class="fas fa-cog me-2"></i>
                                   একাউন্ট সেটিং
                               </a></li>
                            <li><a class="dropdown-item {{ Request::is('instructor/courses*') ? ' active' : '' }}" 
                                   href="{{ route('instructor.courses') }}">
                                   <i class="fas fa-book-open me-2"></i>
                                   সকল কোর্স
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
                <a href="{{ route('instructor.builder') }}" class="bttn" title="ল্যান্ডিং পেজ বিল্ডার">
                    <i class="fas fa-paint-brush"></i>
                </a>
                <a href="{{ route('instructor.notifications') }}" 
                   class="bttn {{ Request::is('instructor/notifications') ? ' active' : '' }}" 
                   title="নোটিফিকেশন"
                   style="cursor: pointer; text-decoration: none; position: relative; z-index: 1000;"
                   onclick="console.log('Notification bell clicked!'); return true;">
                    <i class="fas fa-bell"></i>
                    @if (Auth::check() && function_exists('instructorUnseenNotification') && instructorUnseenNotification() >= 1)
                        <span>{{ instructorUnseenNotification() }}</span>
                    @endif
                </a>
                <div class="dropdown">
                    <button class="btn avatar" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @if (auth()->user()->avatar)
                            <img src="{{ asset(auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="img-fluid">
                        @else
                            <span class="avatar-user">{!! strtoupper(auth()->user()->name[0]) !!}</span>
                        @endif
                    </button>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">
                            <strong>{{ auth()->user()->name }}</strong><br>
                            <small class="text-muted">প্রশিক্ষক</small>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('instructor.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            ড্যাশবোর্ড
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('instructor.profile') }}">
                            <i class="fas fa-user-circle me-2"></i>
                            আমার প্রোফাইল
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('instructor.courses') }}">
                            <i class="fas fa-book-open me-2"></i>
                            আমার কোর্স
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('instructor.students') }}">
                            <i class="fas fa-users me-2"></i>
                            শিক্ষার্থী
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('instructor.earnings') }}">
                            <i class="fas fa-wallet me-2"></i>
                            আয় ও পেমেন্ট
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('instructor.builder') }}">
                            <i class="fas fa-paint-brush me-2"></i>
                            ল্যান্ডিং পেজ
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