<nav class="navbar navbar-expand-lg" >
    <div class="container">
        @if ( Auth::check() )
            @can('student')
            <a class="navbar-brand" href="{{ route('student.dashboard') }}">
                <img src="{{asset('assets/images/black-logo.png')}}" alt="Logo" class="img-fluid">
            </a>
            @else
            <a class="navbar-brand" href="{{ route('instructor.dashboard') }}">
                <img src="{{asset('assets/images/black-logo.png')}}" alt="Logo" class="img-fluid">
            </a>
            @endcan
        @else
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{asset('assets/images/black-logo.png')}}" alt="Logo" class="img-fluid">
        </a>
        @endif
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa-solid fa-bars-staggered"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto custom_nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('courses') }}">কোর্স</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about') }}">সম্পর্কে</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact') }}">যোগাযোগ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('help') }}">সহায়তা</a>
                </li>
            </ul>
            @if (auth()->user() && auth()->user()->user_role == 'instructor')
                <div class="d-flex">
                    <a href="{{ route('instructor.dashboard') }}" class="btn btn-primary me-2">
                        <i class="fas fa-chalkboard-teacher me-1"></i>
                        প্রশিক্ষক প্যানেল
                    </a>
                </div>
			@elseif (auth()->user() && auth()->user()->user_role == 'student')
                <div class="d-flex">
                    <a href="{{ route('student.dashboard') }}" class="btn btn-success me-2">
                        <i class="fas fa-tachometer-alt me-1"></i>
                        ড্যাশবোর্ড
                    </a>
                </div>
            @else
                <div class="d-flex">
                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">
                        <i class="fas fa-sign-in-alt me-1"></i>
                        লগইন
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus me-1"></i>
                        নতুন যোগদান
                    </a>
                </div>
            @endif
        </div>
    </div>
</nav>
