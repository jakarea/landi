@extends('layouts.latest.students')
@section('title') Course Activity @endsection

{{-- page style @S --}}
@section('style')
<link href="{{ asset('assets/admin-css/subscription.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin-css/student-dash.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/admin-css/elearning.css') }}" rel="stylesheet" type="text/css" />
@endsection
{{-- page style @S --}}

{{-- page content @S --}}
@section('content')
{{-- ==== course activity list page @S ==== --}}
<main class="course-activity-list-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="package-list-header" style="grid-template-columns: 50% 50%">
                    <h5>Course Activity</h5>
                    <div class="text-end">
                        <a href="{{url('student/dashboard/enrolled')}}" class="common-bttn me-4"><i class="fas fa-angle-left me-2"></i> My Courses</a>
                    </div>
                </div>
            </div>
        </div>
        @if (count($courseActivities) > 0 )
        <div class="row">
            <div class="col-12">
                <div class="subscription-table-wrap activity-table filter-image">
                    <table>
                        <tr>
                            <th>Course Name</th>
                            <th>Duration</th>
                            {{-- <th>Total Point</th>
                            <th>Your Point</th> --}}
                            <th>Status</th>
                            <th>Progress</th>
                            <th>Progress</th>
                        </tr>
                        @foreach ($courseActivities as $activityCourse)
                        <tr>
                            <td>
                                <div class="media">
                                    <img src="{{ asset($activityCourse->thumbnail) }}" alt="a" class="img-fluid">
                                    <div class="media-body">
                                        <h5><a style="background: transparent!important" href="{{url('student/courses/'.$activityCourse->slug)}}">
                                            {{ Str::limit($activityCourse->title, $limit = 45, $end = '..') }}
                                        </a></h5>
                                        <h6>{{ $activityCourse->categories }}</h6>
                                    </div>
                                </div>
                            </td>

                            {{-- course lesson duration calculation --}}
                            @php
                            $totalDurationMinutes = 0;
                            @endphp
                            @foreach($activityCourse->modules as $module)
                            @foreach($module->lessons as $lesson)
                            @php
                            $totalDurationMinutes += $lesson->duration;
                            @endphp
                            @endforeach
                            @endforeach
                            {{-- course lesson duration calculation --}}

                            <td>
                                <p>{{ number_format($totalDurationMinutes /60, 2) }} h
                                </p>
                            </td>
                            {{-- <td>
                                <p>0</p>
                            </td>
                            <td>
                                <p>0</p>
                            </td>   --}}
                            @php
                            $totalPorgressPercent = StudentActitviesProgress(auth()->user()->id, $activityCourse->id);
                            $showPercentage = null;

                            if($totalPorgressPercent > 95 && $totalPorgressPercent < 100){
                                $showPercentage = $totalPorgressPercent - 2;
                            }
                            @endphp
                            <td>
                                @if($totalPorgressPercent > 99 && $totalPorgressPercent < 101)
                                    <span>Completed</span>
                                @elseif($totalPorgressPercent < 1)
                                    <span class="danger">Not Started</span>
                                @elseif($totalPorgressPercent > 0 && $totalPorgressPercent < 99)
                                    <span>Inprogress</span>
                                @endif
                            </td>
                            <td>

                                <div class="circle-prog">
                                    <div class="cards">
                                        <div class="percent">
                                            <svg>
                                                <circle cx="27" cy="30" r="25"></circle>
                                                <circle cx="27" cy="30" r="25"
                                                    style="--percent: {{ $showPercentage ? $showPercentage : $totalPorgressPercent }}"></circle>
                                            </svg>
                                            @php
                                                $totalLessons = 0;
                                                $completedLessons = 0;
                                            @endphp
                                            @foreach ($activityCourse->modules as $module)
                                                @php
                                                    $totalLessons += count($module->lessons);
                                                    $completedLessons += $module->lessons->where('completed', 1)->count();
                                                @endphp
                                            @endforeach
                                            <div class="number" style="left: 27%">
                                                <h6>{{ $totalPorgressPercent }}<b style="font-size: 14px">%</b></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="{{url('student/courses/'.$activityCourse->slug)}}" class="play-bttn">Play <img src="{{asset('assets/images/icons/play.svg')}}" alt="a" class="img-fluid"></a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-12">
                @include('partials/no-data')
            </div>
        </div>
        @endif
        <div class="row">
            {{-- pagginate --}}
            <div class="paggination-wrap mt-4">
                {{ $courseActivities->links('pagination::bootstrap-5') }}
            </div>
            {{-- pagginate --}}
        </div>
    </div>
</main>
{{-- ==== course activity list page @E ==== --}}
@endsection
{{-- page content @E --}}
