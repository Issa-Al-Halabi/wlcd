@extends('theme.master')
@section('title', "$course->title")
@section('content')

    @include('admin.message')

@section('meta_tags')

    @php
        $url = URL::current();
    @endphp

    <meta name="title" content="{{ $course['title'] }}">
    <meta name="description" content="{{ $course['short_detail'] }} ">
    <meta property="og:title" content="{{ $course['title'] }} ">
    <meta property="og:url" content="{{ $url }}">
    <meta property="og:description" content="{{ $course['short_detail'] }}">
    <meta property="og:image" content="{{ asset('images/course/' . $course['preview_image']) }}">
    <meta itemprop="image" content="{{ asset('images/course/' . $course['preview_image']) }}">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image" content="{{ asset('images/course/' . $course['preview_image']) }}">
    <meta property="twitter:title" content="{{ $course['title'] }} ">
    <meta property="twitter:description" content="{{ $course['short_detail'] }}">
    <meta name="twitter:site" content="{{ url()->full() }}" />
    <link rel="canonical" href="{{ url()->full() }}" />
    <meta name="robots" content="all">
    <meta name="keywords" content="{{ $gsetting->meta_data_keyword }}">
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.3/plyr.css" />
@endsection
    <!-- breadcumb start -->
    @php
        $gets = App\Breadcum::first();
    @endphp
    @if (isset($gets))
        <section id="business-home" class="business-home-main-block">
            <div class="business-img">
                @if ($gets['img'] !== null && $gets['img'] !== '')
                    <img src="{{ url('/images/breadcum/' . $gets->img) }}" class="img-fluid" width="100%" height="100px" alt="" />
                @else
                    <img src="{{ Avatar::create($gets->text)->toBase64() }}" alt="course" width="100%" height="100px" class="img-fluid">
                @endif
            </div>
            <div class="overlay-bg"></div>
            <div class="container-fluid">
                <div class="business-dtl" style="position: absolute;
                top: 10%;
                left: 13%;
                right: 13%;">
                    <div class="row">
                        <div class="col-lg-12 text-left">
                            <div class="bredcrumb-dtl">
                                <div class="about-home-block" style="padding: 0 !important">
                                    <h1 class="about-home-heading" style="margin-bottom: 0 !important">{{ $course['title'] }}</h1>
                                    <p>{{ $course['short_detail'] }}</p>
                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- breadcumb end -->

<!-- course detail start -->
<section id="about-product" class="about-product-main-block">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-8">
                <div class="row">
                    <div class="col-lg-12">
						<div class="video-item hidden-xs" style="display: grid;
                        min-height: 60vh;">
							@if ($course['preview_type'] == 'video')
								<video controls crossorigin playsinline  width="100%" height="90%"{{-- data-poster="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-HD.jpg" --}}
									data-poster="{{ asset('images/course/' . $course['preview_image']) }}" class="js-player">

									<source src="{{ asset('video/preview/' . $course['video']) }}" type="video/mp4" />
									{{-- <source src="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-576p.mp4"
                                    type="video/mp4" size="1080" /> --}}
								</video>
							@elseif($course['preview_type'] == 'url')
								<iframe width="100%" height="90%" src="{{ str_replace('watch?v=', 'embed/', $course['url']) }}"
									frameborder="0" allowfullscreen></iframe>
							@endif
						</div>
					</div>
                </div>
                <div class="row mt-4" style="padding: 0; margin:0">
                    <div class="col-md-12 col-lg-12" style="padding: 0; margin:0">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home"
                                    type="button" role="tab" aria-controls="home" aria-selected="true">What
                                    Learn</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile"
                                    type="button" role="tab" aria-controls="profile"
                                    aria-selected="false">Requirements</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="messages-tab" data-toggle="tab" data-target="#messages"
                                    type="button" role="tab" aria-controls="messages"
                                    aria-selected="false">Description</button>
                            </li>
                            <!-- <li class="nav-item" role="presentation">
                                <button class="nav-link" id="settings-tab" data-toggle="tab" data-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false">Comments & Review</button>
                            </li> -->
                        </ul>
                        <div class="tab-content mt-3">
                            <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                @if ($whatlearns->isNotEmpty())
                                    <div class="product-learn-block">
                                        <h3 class="product-learn-heading">{{ __('Whatlearn') }}</h3>
                                        <div class="row">
                                            @foreach ($course['whatlearns'] as $wl)
                                                @if ($wl->status == 1)
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="product-learn-dtl">
                                                            <ul>
                                                                <li><i
                                                                        data-feather="check-circle"></i>{{ str_limit($wl['detail'], $limit = 120, $end = '...') }}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="requirements">
                                    <h3>{{ __('Requirements') }}</h3>
                                    <ul>
                                        <li class="comment more">
                                            @if (strlen($course->requirement) > 400)
                                                {{ substr($course->requirement, 0, 400) }}
                                                <span
                                                    class="read-more-show hide_content"><br>+&nbsp;{{ __('See More') }}</span>
                                                <span class="read-more-content">
                                                    {{ substr($course->requirement, 400, strlen($course->requirement)) }}
                                                    <span
                                                        class="read-more-hide hide_content"><br>-&nbsp;{{ __('See Less') }}</span>
                                                </span>
                                            @else
                                                {{ $course->requirement }}
                                            @endif
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <div class="tab-pane" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                                <div class="description-block btm-30">
                                    <h3>{{ __('Description') }}</h3>

                                    <p>{!! $course->detail !!}</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding:0; margin:0">
                    <div class="col-lg-12 col-md-12" style="padding: 0; margin:0">
                        @if ($coursechapters->isNotEmpty())
                            <div class="course-content-block btm-30 top-20">

                                <div class="row">
                                    <div class="col-lg-12 col-12">
                                        <h3>{{ __('CourseContent') }}</h3>
                                    </div>
                                </div>
                                <!-- FSMS -->
                                <div class="row" style="padding-bottom:10px">
                                    <div class="col-lg-9 col-6">
                                        @php
                                            // FSMS
                                            function convertToHoursMins($time, $format = '%02d:%02d')
                                            {
                                                if ($time < 1) {
                                                    return;
                                                }
                                                $hours = floor($time / 60);
                                                $minutes = $time % 60;
                                                return sprintf($format, $hours, $minutes);
                                            }
                                            $classtwo = App\CourseClass::where('course_id', $course->id)->sum('duration');
                                            
                                            // echo $duration_round2 = round($classtwo,2);
                                            
                                            $chapterCount = $coursechapters->count();
                                            $classesCount = count(App\CourseClass::where('course_id', $course->id)->get());
                                            $courseDuration = convertToHoursMins($classtwo, '%02dh %02dm total length');
                                            // FSMS
                                        @endphp

                                        <small>{{ $chapterCount . ' sections • ' . $classesCount . ' lectures • ' . $courseDuration }}</small>
                                    </div>
                                    <div class="col-lg-3 col-6 col-xs-6 nopadding">
                                        <button type="button" onclick="toggleAllSections()"
                                            class="btn btn-link courseToggle"><span
                                                style="color:#0384a3">{{ __('Expand all sections') }}</span></button>
                                        <button type="button" onclick="toggleAllSections()"
                                            class="btn btn-link courseToggle" style="display:none"><span
                                                style="color:#0384a3">{{ __('Collapse all sections') }}</span></button>
                                    </div>
                                </div>
                                <!-- FSMS -->

                                <div class="faq-block">
                                    <div class="faq-dtl">
                                        <div id="accordion" class="second-accordion">
                                            @foreach ($coursechapters as $key => $chapter)
                                                @if ($chapter->status == 1 and $chapter->count() > 0)
                                                    <div class="card">
                                                        <div class="card-header" id="headingTwo{{ $chapter->id }}">
                                                            <div class="mb-0">
                                                                <button class="btn btn-link" data-toggle="collapse"
                                                                    data-target="#collapseTwo{{ $chapter->id }}"
                                                                    aria-expanded="{{ $key == 0 ? 'true' : 'false' }}"
                                                                    aria-controls="collapseTwo">

                                                                    <div class="row">
                                                                        <div class="col-lg-8 col-6">
                                                                            {{ $chapter['chapter_name'] }}

                                                                            @if ($course->involvement_request == 1)
                                                                                @if ($chapter->user_id != null)
                                                                                    @php
                                                                                        $fullname = optional($chapter->user)->fname . ' ' . optional($chapter->user)->lname;
                                                                                        $fullname = preg_replace('/\s+/', '', $fullname);
                                                                                    @endphp
                                                                                    <a
                                                                                        href="{{ route('instructor.profile', ['id' => $chapter->user->id, 'name' => $fullname]) }}">-
                                                                                        {{ __('by') }}
                                                                                        {{ $chapter->user['fname'] }}
                                                                                    </a>
                                                                                @endif
                                                                            @endif
                                                                        </div>
                                                                        <div class="col-lg-2 col-4">
                                                                            <div class="text-right">
                                                                                @php
                                                                                    $classone = App\CourseClass::where('coursechapter_id', $chapter->id)
                                                                                        ->orderBy('position', 'ASC')
                                                                                        ->get();
                                                                                    if (count($classone) > 0) {
                                                                                        echo count($classone);
                                                                                    } else {
                                                                                        echo '0';
                                                                                    }
                                                                                @endphp
                                                                                {{ __('Classes') }}
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-2 col-2">
                                                                            <div class="chapter-total-time">
                                                                                @php
                                                                                    $classtwo = App\CourseClass::where('coursechapter_id', $chapter->id)->sum('duration');
                                                                                    
                                                                                    echo $duration_round = round($classtwo, 2);
                                                                                @endphp
                                                                                {{ __('min') }}
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                </button>
                                                            </div>

                                                        </div>


                                                        <div id="collapseTwo{{ $chapter->id }}"
                                                            class="collapse {{ $key == 0 ? 'show' : '' }}"
                                                            aria-labelledby="headingTwo" data-parent="#accordion">

                                                            <div class="card-body">
                                                                <table class="table">
                                                                    <tbody>
                                                                        @foreach ($courseclass as $class)
                                                                            @if ($class->status == 1)
                                                                                @if ($class->coursechapter_id == $chapter->id)
                                                                                    <tr>
                                                                                        <th class="class-icon">
                                                                                            @if ($class->type == 'video')
                                                                                                <a href="#"
                                                                                                    title="Course"><i
                                                                                                        class="fa fa-play-circle"></i></a>
                                                                                            @endif
                                                                                            @if ($class->type == 'audio')
                                                                                                <a href="#"
                                                                                                    title="Course"><i
                                                                                                        class="fas fa-play"></i></a>
                                                                                            @endif
                                                                                            @if ($class->type == 'image')
                                                                                                <a href="#"
                                                                                                    title="Course"><i
                                                                                                        class="fas fa-image"></i></a>
                                                                                            @endif
                                                                                            @if ($class->type == 'pdf')
                                                                                                <a href="#"
                                                                                                    title="Course"><i
                                                                                                        class="fas fa-file-pdf"></i></a>
                                                                                            @endif
                                                                                            @if ($class->type == 'zip')
                                                                                                <a href="#"
                                                                                                    title="Course"><i
                                                                                                        class="far fa-file-archive"></i></a>
                                                                                            @endif
                                                                                        </th>

                                                                                        <td>

                                                                                            <div
                                                                                                class="koh-tab-content">
                                                                                                <div
                                                                                                    class="koh-tab-content-body">
                                                                                                    <div
                                                                                                        class="koh-faq">
                                                                                                        <div
                                                                                                            class="koh-faq-question">

                                                                                                            <span
                                                                                                                class="koh-faq-question-span">
                                                                                                                {{ $class['title'] }}
                                                                                                            </span>

                                                                                                            @if ($class->date_time != null)
                                                                                                                <div
                                                                                                                    class="live-class">
                                                                                                                    Live
                                                                                                                    at:
                                                                                                                    {{ $class->date_time }}
                                                                                                                </div>
                                                                                                            @endif
                                                                                                            @if ($class->detail != null)
                                                                                                                <i class="fa fa-sort-down"
                                                                                                                    aria-hidden="true"></i>
                                                                                                            @endif
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="koh-faq-answer">
                                                                                                            {!! $class->detail !!}
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>

                                                                                        <td>
                                                                                            @if ($class->preview_url != null || $class->preview_video != null)
                                                                                                <a href="{{ route('lightbox', $class->id) }}"
                                                                                                    class="iframe"
                                                                                                    style="display: block;">{{ __('preview') }}</a>
                                                                                            @endif

                                                                                        </td>

                                                                                        <td class="txt-rgt">
                                                                                            @if ($class->type == 'video')
                                                                                                {{ $class['duration'] }}{{ __('min') }}
                                                                                            @else
                                                                                                {{ $class['size'] }}mb
                                                                                            @endif



                                                                                    </tr>
                                                                                @endif
                                                                            @endif
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @auth

                            @php
                                $user_enrolled = App\Order::where('course_id', $course->id)
                                    ->where('user_id', Auth::user()->id)
                                    ->first();
                                
                                $bundle = App\Order::where('user_id', Auth::User()->id)
                                    ->where('bundle_id', '!=', null)
                                    ->get();
                                
                                $course_id = [];
                                
                                foreach ($bundle as $b) {
                                    $bundle = App\BundleCourse::where('id', $b->bundle_id)->first();
                                    array_push($course_id, $bundle->course_id);
                                }
                                
                                $course_id = array_values(array_filter($course_id));
                                
                                $course_id = array_flatten($course_id);
                                
                            @endphp


                            @if ($user_enrolled != null || Auth::user()->role == 'admin' || isset($course_id) || in_array($course->id, $course_id))

                                @if (!$bigblue->isEmpty())
                                    <div class="course-content-block btm-30">
                                        <h5>{{ __('Big Blue Meetings') }}</h5>
                                        <div class="faq-block">
                                            <div class="faq-dtl">
                                                <div id="accordion" class="second-accordion">

                                                    @foreach ($bigblue as $bbl)
                                                        @if ($bbl->is_ended != 1)
                                                            <div class="card">
                                                                <div class="card-header"
                                                                    id="headingThree{{ $bbl->id }}">
                                                                    <div class="mb-0">
                                                                        <button class="btn btn-link"
                                                                            data-toggle="collapse"
                                                                            data-target="#collapseThree{{ $bbl->id }}"
                                                                            aria-expanded="false"
                                                                            aria-controls="collapseThree">

                                                                            {{ $bbl['meetingname'] }}

                                                                        </button>
                                                                    </div>

                                                                </div>
                                                                <div id="collapseThree{{ $bbl->id }}"
                                                                    class="collapse" aria-labelledby="headingThree"
                                                                    data-parent="#accordion">

                                                                    <div class="card-body">
                                                                        <table class="table">
                                                                            <tbody>
                                                                                <td>
                                                                                    <ul>
                                                                                        <li><a href="#"
                                                                                                title="about">{{ __('Created') }}:
                                                                                                @if (isset($bbl->user))
                                                                                                    {{ $bbl->user['fname'] }}
                                                                                                    {{ $bbl->user['lname'] }}
                                                                                                @endif
                                                                                            </a>
                                                                                        </li>
                                                                                        <li><a href="#"
                                                                                                title="about">{{ __('Start At') }}:
                                                                                                {{ date('d-m-Y | h:i:s A', strtotime($bbl['start_time'])) }}</a>
                                                                                        </li>
                                                                                        <li class="comment more">
                                                                                            {!! $bbl->detail !!}
                                                                                        </li>

                                                                                        <li>
                                                                                            <a href=""
                                                                                                data-toggle="modal"
                                                                                                data-target="#myModalBBL"
                                                                                                title="join"
                                                                                                class="btn btn-light"
                                                                                                title="course">{{ __('Join Meeting') }}</a>
                                                                                        </li>

                                                                                        <div class="modal fade"
                                                                                            id="myModalBBL" tabindex="-1"
                                                                                            role="dialog"
                                                                                            aria-labelledby="myModalLabel">
                                                                                            <div class="modal-dialog modal-lg"
                                                                                                role="document">
                                                                                                <div class="modal-content">
                                                                                                    <div
                                                                                                        class="modal-header">

                                                                                                        <h4 class="modal-title"
                                                                                                            id="myModalLabel">
                                                                                                            {{ __('Join Meeting') }}
                                                                                                        </h4>
                                                                                                        <button
                                                                                                            type="button"
                                                                                                            class="close"
                                                                                                            data-dismiss="modal"
                                                                                                            aria-label="Close"><span
                                                                                                                aria-hidden="true">&times;</span></button>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="box box-primary">
                                                                                                        <div
                                                                                                            class="panel panel-sum">
                                                                                                            <div
                                                                                                                class="modal-body">

                                                                                                                <form
                                                                                                                    action="{{ route('bbl.api.join') }}"
                                                                                                                    method="POST">
                                                                                                                    @csrf

                                                                                                                    <div
                                                                                                                        class="form-group">
                                                                                                                        <label>{{ __('Meeting ID') }}:</label>
                                                                                                                        <input
                                                                                                                            readonly=""
                                                                                                                            type="text"
                                                                                                                            name="meetingid"
                                                                                                                            value="{{ $bbl['meetingid'] }}"
                                                                                                                            class="form-control">
                                                                                                                    </div>

                                                                                                                    <div
                                                                                                                        class="form-group">
                                                                                                                        <label>{{ __('Your Name') }}:</label>
                                                                                                                        <input
                                                                                                                            value="{{ old('name') }}"
                                                                                                                            type="text"
                                                                                                                            required=""
                                                                                                                            name="name"
                                                                                                                            placeholder="{{ __('Enter your name') }}"
                                                                                                                            class="form-control">
                                                                                                                    </div>

                                                                                                                    <div
                                                                                                                        class="form-group">
                                                                                                                        <label>{{ __('Meeting Password') }}:</label>
                                                                                                                        <input
                                                                                                                            type="password"
                                                                                                                            name="password"
                                                                                                                            placeholder="{{ __('Enter meeting password') }}"
                                                                                                                            class="form-control"
                                                                                                                            required="">
                                                                                                                    </div>

                                                                                                                    <button
                                                                                                                        type="submit"
                                                                                                                        class="btn btn-sm btn-primary">
                                                                                                                        {{ __('Join Meeting') }}
                                                                                                                    </button>

                                                                                                                </form>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                    </ul>
                                                                                </td>

                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                @endif

                                @if (!$meetings->isEmpty())
                                    <div class="course-content-block btm-30">
                                        <h5>{{ __('Zoom Meetings') }}</h5>
                                        <div class="faq-block">
                                            <div class="faq-dtl">
                                                <div id="accordion" class="second-accordion">


                                                    @foreach ($meetings as $meeting)
                                                        <div class="card">
                                                            <div class="card-header" id="headingFour{{ $meeting->id }}">
                                                                <div class="mb-0">
                                                                    <button class="btn btn-link" data-toggle="collapse"
                                                                        data-target="#collapseFour{{ $meeting->id }}"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapseFour">

                                                                        {{ $meeting['meeting_title'] }}

                                                                    </button>
                                                                </div>

                                                            </div>
                                                            <div id="collapseFour{{ $meeting->id }}" class="collapse"
                                                                aria-labelledby="headingFour" data-parent="#accordion">

                                                                <div class="card-body">
                                                                    <table class="table">
                                                                        <tbody>
                                                                            <td>
                                                                                <ul>
                                                                                    <li>
                                                                                        <a href="#"
                                                                                            title="about">{{ __('Created') }}:
                                                                                            @if (isset($meeting->user))
                                                                                                {{ $meeting->user['fname'] }}
                                                                                                {{ $meeting->user['lname'] }}
                                                                                            @endif
                                                                                        </a>

                                                                                    </li>
                                                                                    <li>
                                                                                        <p>{{ __('Meeting Owner') }}:
                                                                                            {{ $meeting->owner_id }}
                                                                                        </p>
                                                                                    </li>
                                                                                    <li>
                                                                                        <p class="btm-10"><a
                                                                                                herf="#">{{ __('Start At') }}:
                                                                                                {{ date('d-m-Y | h:i:s A', strtotime($meeting['start_time'])) }}</a>
                                                                                        </p>
                                                                                    </li>
                                                                                    <li>
                                                                                        <a href="{{ $meeting->zoom_url }}"
                                                                                            target="_blank"
                                                                                            class="btn btn-light">{{ __('Join Meeting') }}</a>
                                                                                    </li>
                                                                                </ul>

                                                                            </td>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif


                                {{-- googlemeeting start --}}
                                @if ($gsetting->googlemeet_enable == '1')
                                    @if (!$googlemeetmeetings->isEmpty())
                                        <div class="course-content-block btm-30">
                                            <h5> Google Meetings</h5>
                                            <div class="faq-block">
                                                <div class="faq-dtl">
                                                    <div id="accordion" class="second-accordion">


                                                        @foreach ($googlemeetmeetings as $meeting)
                                                            <div class="card">
                                                                <div class="card-header"
                                                                    id="headingFour{{ $meeting->id }}">
                                                                    <div class="mb-0">
                                                                        <button class="btn btn-link"
                                                                            data-toggle="collapse"
                                                                            data-target="#collapseFour{{ $meeting->id }}"
                                                                            aria-expanded="false"
                                                                            aria-controls="collapseFour">

                                                                            {{ $meeting['meeting_title'] }}

                                                                        </button>
                                                                    </div>

                                                                </div>
                                                                <div id="collapseFour{{ $meeting->id }}"
                                                                    class="collapse" aria-labelledby="headingFour"
                                                                    data-parent="#accordion">

                                                                    <div class="card-body">
                                                                        <table class="table">
                                                                            <tbody>
                                                                                <td>
                                                                                    <ul>
                                                                                        <li>
                                                                                            <a href="#"
                                                                                                title="about">{{ __('Created') }}:
                                                                                                @if (isset($meeting->user))
                                                                                                    {{ $meeting->user['fname'] }}
                                                                                                    {{ $meeting->user['lname'] }}
                                                                                                @endif
                                                                                            </a>

                                                                                        </li>
                                                                                        <li>
                                                                                            <p>Meeting Owner:
                                                                                                {{ $meeting->owner_id }}
                                                                                            </p>
                                                                                        </li>
                                                                                        <li>
                                                                                            <p class="btm-10"><a
                                                                                                    herf="#">{{ __('Start At') }}:
                                                                                                    {{ date('d-m-Y | h:i:s A', strtotime($meeting['start_time'])) }}</a>
                                                                                            </p>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="{{ $meeting->meet_url }}"
                                                                                                target="_blank"
                                                                                                class="btn btn-light">{{ __('Join Meeting') }}</a>
                                                                                        </li>
                                                                                    </ul>

                                                                                </td>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                {{-- googlemeeting end --}}

                                {{-- jitsi start --}}
                                @if ($gsetting->jitsimeet_enable == '1')
                                    @if (!$jitsimeetings->isEmpty())
                                        <div class="course-content-block btm-30">
                                            <h5> Jitsi Meetings</h5>
                                            <div class="faq-block">
                                                <div class="faq-dtl">
                                                    <div id="accordion" class="second-accordion">


                                                        @foreach ($jitsimeetings as $meeting)
                                                            <div class="card">
                                                                <div class="card-header"
                                                                    id="headingFour{{ $meeting->id }}">
                                                                    <div class="mb-0">
                                                                        <button class="btn btn-link"
                                                                            data-toggle="collapse"
                                                                            data-target="#collapseFour{{ $meeting->id }}"
                                                                            aria-expanded="false"
                                                                            aria-controls="collapseFour">

                                                                            {{ $meeting['meeting_title'] }}

                                                                        </button>
                                                                    </div>

                                                                </div>
                                                                <div id="collapseFour{{ $meeting->id }}"
                                                                    class="collapse" aria-labelledby="headingFour"
                                                                    data-parent="#accordion">

                                                                    <div class="card-body">
                                                                        <table class="table">
                                                                            <tbody>
                                                                                <td>
                                                                                    <ul>
                                                                                        <li>
                                                                                            <a href="#"
                                                                                                title="about">{{ __('Created') }}:
                                                                                                @if (isset($meeting->user))
                                                                                                    {{ $meeting->user['fname'] }}
                                                                                                    {{ $meeting->user['lname'] }}
                                                                                                @endif
                                                                                            </a>

                                                                                        </li>
                                                                                        <li>
                                                                                            <p>{{ __('Meeting Owner') }}:
                                                                                                {{ $meeting->owner_id }}
                                                                                            </p>
                                                                                        </li>
                                                                                        <li>
                                                                                            <p class="btm-10"><a
                                                                                                    herf="#">{{ __('Start At') }}:
                                                                                                    {{ date('d-m-Y | h:i:s A', strtotime($meeting['start_time'])) }}</a>
                                                                                            </p>
                                                                                        </li>
                                                                                        <li>
                                                                                            <a href="{{ url('meetup-conferencing/' . $meeting->meeting_id) }}"
                                                                                                target="_blank"
                                                                                                class="btn btn-light">{{ __('Join Meeting') }}</a>
                                                                                        </li>
                                                                                    </ul>

                                                                                </td>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                @endif
                                {{-- jitsi end --}}


                            @endif

                        @endauth
                        <!--Model close -->
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12" style="padding: 0">
                        @if (!$relatedcourse->isEmpty())
                            <div class="students-bought btm-30">
                                <h3 class="more-courses-heading">{{ __('Related Courses') }}</h3>
                                <div id="student-view-slider-related-course-details"
                                    class="student-view-slider-main-block owl-carousel owl-theme">
                                    @foreach ($relatedcourse as $rel)
                                        @if (optional($rel->courses)->status == 1)
                                            <div class="course-bought-block">
                                                <div class="row" style="display: flex; justify-contnet:center;">
                                                    <div class="col-lg-12 col-sm-12 col-12">
                                                        <div class="view-block">
                                                            <div class="view-img">
                                                                @if ($rel->courses['preview_image'] !== null && $rel->courses['preview_image'] !== '')
                                                                    <a
                                                                        href="{{ route('user.course.show', ['id' => $rel->course_id, 'slug' => $rel->courses->slug]) }}"><img
                                                                            src="{{ asset('images/course/' . $rel->courses->preview_image) }}"
                                                                            alt="student">
                                                                    </a>
                                                                @else
                                                                    <a
                                                                        href="{{ route('user.course.show', ['id' => $rel->course_id, 'slug' => $rel->courses->slug]) }}"><img
                                                                            src="{{ Avatar::create($rel->courses->title)->toBase64() }}"
                                                                            alt="student">
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <div class="view-user-img">
                                                                @if ($rel->user['user_img'] !== null && $rel->user['user_img'] !== '')
                                                                    <a href="" title=""><img
                                                                            src="{{ asset('images/user_img/' . $rel->user['user_img']) }}"
                                                                            class="img-fluid user-img-one"
                                                                            alt=""></a>
                                                                @else
                                                                    <a href="" title=""><img
                                                                            src="{{ asset('images/default/user.png') }}"
                                                                            class="img-fluid user-img-one"
                                                                            alt=""></a>
                                                                @endif
                                                            </div>
                                                            {{-- Add to wishlisht --}}
                                                            @if (Auth::check())
                                                                @php
                                                                    $wishtt = App\Wishlist::where('user_id', Auth::User()->id)
                                                                        ->where('course_id', $rel->course_id)
                                                                        ->first();
                                                                @endphp
                                                                @if ($wishtt == null)
                                                                    <div class="img-wishlist">
                                                                        <div class="protip-wishlist">
                                                                            <ul>
                                                                                @if (Auth::check())
                                                                                    @php
                                                                                        $wish = App\Wishlist::where('user_id', Auth::User()->id)
                                                                                            ->where('course_id', $rel->course_id)
                                                                                            ->first();
                                                                                    @endphp
                                                                                    @if ($wish == null)
                                                                                        <li class="protip-wish-btn">
                                                                                            <form id="demo-form2"
                                                                                                method="post"
                                                                                                action="{{ url('show/wishlist', $rel->course_id) }}"
                                                                                                data-parsley-validate
                                                                                                class="form-horizontal form-label-left">
                                                                                                {{ csrf_field() }}

                                                                                                <input type="hidden"
                                                                                                    name="user_id"
                                                                                                    value="{{ Auth::User()->id }}" />
                                                                                                <input type="hidden"
                                                                                                    name="course_id"
                                                                                                    value="{{ $rel->course_id }}" />

                                                                                                <button
                                                                                                    class="wishlisht-btn"
                                                                                                    title="Add to wishlist"
                                                                                                    type="submit"><i
                                                                                                        data-feather="heart"
                                                                                                        class="rgt-10"></i></button>
                                                                                            </form>
                                                                                        </li>
                                                                                    @else
                                                                                        <li
                                                                                            class="protip-wish-btn-two">
                                                                                            <form id="demo-form2"
                                                                                                method="post"
                                                                                                action="{{ url('remove/wishlist', $rel->course_id) }}"
                                                                                                data-parsley-validate
                                                                                                class="form-horizontal form-label-left">
                                                                                                {{ csrf_field() }}

                                                                                                <input type="hidden"
                                                                                                    name="user_id"
                                                                                                    value="{{ Auth::User()->id }}" />
                                                                                                <input type="hidden"
                                                                                                    name="course_id"
                                                                                                    value="{{ $rel->course_id }}" />

                                                                                                <button
                                                                                                    class="wishlisht-btn heart-fill"
                                                                                                    title="Remove from Wishlist"
                                                                                                    type="submit"><i
                                                                                                        data-feather="heart"
                                                                                                        class="rgt-10"></i></button>
                                                                                            </form>
                                                                                        </li>
                                                                                    @endif
                                                                                @else
                                                                                    <li class="protip-wish-btn">
                                                                                        <a href="{{ route('login') }}"
                                                                                            title="heart"><i
                                                                                                data-feather="heart"
                                                                                                class="rgt-10"></i></a>
                                                                                    </li>
                                                                                @endif
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @else
                                                                <div class="heart">
                                                                    <a href="{{ route('login') }}" title="heart"><i
                                                                            class="fa fa-heart rgt-10"></i></a>
                                                                </div>
                                                            @endif
                                                            {{-- Add to wishlisht end --}}

                                                            <div class="view-dtl">
                                                                <div class="view-heading"><a
                                                                        href="{{ route('user.course.show', ['id' => $rel->course_id, 'slug' => $rel->courses->slug]) }}">{{ str_limit($rel->courses['title'], $limit = 30, $end = '...') }}</a>
                                                                </div>
                                                                <div class="user-name">
                                                                    <h6>By
                                                                        <span>{{ optional($rel->courses->user)['fname'] }}</span>
                                                                    </h6>
                                                                </div>

                                                                <div class="rating">
                                                                    <ul>
                                                                        <li>
                                                                            <?php
                                                                            $learn = 0;
                                                                            $price = 0;
                                                                            $value = 0;
                                                                            $sub_total = 0;
                                                                            $sub_total = 0;
                                                                            $reviews = App\ReviewRating::where('course_id', $rel->course_id)
                                                                                ->where('status', '1')
                                                                                ->get();
                                                                            ?>
                                                                            @if (!empty($reviews[0]))
                                                                                <?php
                                                                                $count = App\ReviewRating::where('course_id', $rel->course_id)->count();
                                                                                
                                                                                foreach ($reviews as $review) {
                                                                                    $learn = $review->price * 5;
                                                                                    $price = $review->price * 5;
                                                                                    $value = $review->value * 5;
                                                                                    $sub_total = $sub_total + $learn + $price + $value;
                                                                                }
                                                                                
                                                                                $count = $count * 3 * 5;
                                                                                $rat = $sub_total / $count;
                                                                                $ratings_var = ($rat * 100) / 5;
                                                                                ?>

                                                                                <div class="pull-left">
                                                                                    <div class="star-ratings-sprite">
                                                                                        <span
                                                                                            style="width:<?php echo $ratings_var; ?>%"
                                                                                            class="star-ratings-sprite-rating"></span>
                                                                                    </div>
                                                                                </div>
                                                                            @else
                                                                                <div class="pull-left no-rating">
                                                                                    {{ __('No Rating') }}
                                                                                </div>
                                                                            @endif
                                                                        </li>

                                                                        <?php
                                                                        $learn = 0;
                                                                        $price = 0;
                                                                        $value = 0;
                                                                        $sub_total = 0;
                                                                        $count = count($reviews);
                                                                        $onlyrev = [];
                                                                        
                                                                        $reviewcount = App\ReviewRating::where('course_id', $course->id)
                                                                            ->where('status', '1')
                                                                            ->WhereNotNull('review')
                                                                            ->get();
                                                                        
                                                                        foreach ($reviews as $review) {
                                                                            $learn = $review->learn * 5;
                                                                            $price = $review->price * 5;
                                                                            $value = $review->value * 5;
                                                                            $sub_total = $sub_total + $learn + $price + $value;
                                                                        }
                                                                        
                                                                        $count = $count * 3 * 5;
                                                                        
                                                                        if ($count != 0) {
                                                                            $rat = $sub_total / $count;
                                                                        
                                                                            $ratings_var = ($rat * 100) / 5;
                                                                        
                                                                            $overallrating = $ratings_var / 2 / 10;
                                                                        }
                                                                        
                                                                        ?>

                                                                        @php
                                                                            $reviewsrating = App\ReviewRating::where('course_id', $rel->course_id)->first();
                                                                        @endphp
                                                                        @if (!empty($reviewsrating))
                                                                            <li class="reviews">
                                                                                (@php
                                                                                    $data = App\ReviewRating::where('course_id', $rel->course_id)->count();
                                                                                    if ($data > 0) {
                                                                                        echo $data;
                                                                                    } else {
                                                                                        echo '0';
                                                                                    }
                                                                                @endphp Reviews)
                                                                            </li>
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                                <div class="view-footer">
                                                                    <div class="row">
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                                                            @if ($rel->courses->type == 1)
                                                                                @if ($rel->courses->discount_price == !null)
                                                                                    <div class="rate text-right">
                                                                                        <ul>


                                                                                            <li>
                                                                                                <a><b>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($rel->courses->discount_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</b></a>
                                                                                            </li>

                                                                                            <li>
                                                                                                <a><b><strike>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($rel->courses->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</strike></b></a>
                                                                                            </li>



                                                                                        </ul>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="rate text-right">
                                                                                        <ul>
                                                                                            <li>
                                                                                                <a><b>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($rel->courses->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</b></a>
                                                                                            </li>


                                                                                        </ul>
                                                                                    </div>
                                                                                @endif
                                                                            @else
                                                                                <div class="rate text-right">
                                                                                    <ul>
                                                                                        <li><a><b>{{ __('Free') }}</b></a>
                                                                                        </li>
                                                                                        <li></li>
                                                                                    </ul>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <!-- course preview -->
                <div class="about-home-product">
                    <div id="bar-fixed">
                        <div class="about-home-dtl-training" style="box-shadow: 0 2px 4px 0 rgb(0 0 0 / 43%);">

                            <div class="about-home-dtl-block btm-10">
                                <h3>About Course</h3>
                                <hr>
                                @if ($course->type == 1)
                                    <div class="about-home-rate">
                                        <ul>

                                            @if ($course->discount_price == !null)

                                                <li>
                                                    {{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($course->discount_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}
                                                </li>
                                                <li>
                                                    <span><s>{{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($course->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}</s></span>
                                                </li>
                                            @else
                                                @if ($course->price == !null)
                                                    <li>
                                                        {{ activeCurrency()->getData()->position == 'l' ? activeCurrency()->getData()->symbol : '' }}{{ price_format(currency($course->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol : '' }}
                                                    </li>
                                                @endif
                                            @endif

                                        </ul>
                                    </div>


                                    @if (Auth::check())

                                        @if (Auth::User()->role == 'admin')
                                            <div class="about-home-btn btm-20">
                                                <a href="{{ route('course.content', ['id' => $course->id, 'slug' => $course->slug]) }}"
                                                    class="btn btn-secondary"
                                                    title="course">{{ __('Go To Course') }}</a>
                                            </div>
                                        @else
                                            @if (isset($course->duration))
                                                @if ($course->duration_type == 'm')
                                                    <div class="course-duration btm-10">{{ __('Enroll Duration') }}:
                                                        {{ $course->duration }} Months</div>
                                                @else
                                                    <div class="course-duration btm-10">{{ __('Enroll Duration') }}:
                                                        {{ $course->duration }} Days</div>
                                                @endif
                                            @endif


                                            @if (!empty($order) && $order->status == 1)

                                                <div class="about-home-btn btm-20">
                                                    <a href="{{ route('course.content', ['id' => $course->id, 'slug' => $course->slug]) }}"
                                                        class="btn btn-secondary"
                                                        title="course">{{ __('Go To Course') }}</a>
                                                </div>
                                            @elseif(isset($course_id) && in_array($course->id, $course_id))
                                                <div class="about-home-btn btm-20">
                                                    <a href="{{ route('course.content', ['id' => $course->id, 'slug' => $course->slug]) }}"
                                                        class="btn btn-secondary"
                                                        title="course">{{ __('Go To Course') }}</a>
                                                </div>
                                            @elseif(!empty($instruct_course->id) && $instruct_course->id == $course->id)
                                                <div class="about-home-btn btm-20">
                                                    <a href="{{ route('course.content', ['id' => $course->id, 'slug' => $course->slug]) }}"
                                                        class="btn btn-secondary"
                                                        title="course">{{ __('Go To Course') }}</a>
                                                </div>
                                            @else
                                                @if (!empty($cart))
                                                    <div class="about-home-btn btm-20">
                                                        <form id="demo-form2" method="post"
                                                            action="{{ route('remove.item.cart', $cart->id) }}">
                                                            {{ csrf_field() }}

                                                            <div class="box-footer">
                                                                <button type="submit" class="btn btn-primary"><i
                                                                        class="fa fa-shopping-cart"
                                                                        aria-hidden="true"></i>&nbsp;{{ __('Remove From Cart') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                @else
                                                    <div class="about-home-btn btm-20">
                                                        <form id="demo-form2" method="post"
                                                            action="{{ route('addtocart', ['course_id' => $course->id, 'price' => $course->price, 'discount_price' => $course->discount_price]) }}"
                                                            data-parsley-validate
                                                            class="form-horizontal form-label-left">
                                                            {{ csrf_field() }}

                                                            <input type="hidden" name="category_id"
                                                                value="{{ $course->category->id }}" />

                                                            <div class="box-footer">
                                                                <button type="submit" class="btn btn-primary"><i
                                                                        class="fa fa-cart-plus"
                                                                        aria-hidden="true"></i>&nbsp;{{ __('Add To Cart') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>

                                                    <div class="about-home-btn btm-20">
                                                        <form id="demo-form2" method="post"
                                                            action="{{ route('buynow') }}" data-parsley-validate
                                                            class="form-horizontal form-label-left">
                                                            {{ csrf_field() }}

                                                            <input type="hidden" name="category_id"
                                                                value="{{ $course->category->id }}" />
                                                            <input type="hidden" name="user_id"
                                                                value="{{ Auth::user()->id }}" />

                                                            <input type="hidden" name="course_id"
                                                                value="{{ $course->id }}" />

                                                            <div class="box-footer">
                                                                <button type="submit"
                                                                    class="btn btn-primary">&nbsp;{{ __('BUY NOW') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                @endif

                                            @endif


                                        @endif
                                    @else
                                        <div class="about-home-btn btm-20">
                                            @if ($gsetting->guest_enable == 1)
                                                <form id="demo-form2" method="post"
                                                    action="{{ route('guest.addtocart', $course->id) }}"
                                                    data-parsley-validate class="form-horizontal form-label-left">
                                                    {{ csrf_field() }}


                                                    <div class="box-footer">
                                                        <button type="submit" class="btn btn-primary"><i
                                                                class="fa fa-cart-plus"
                                                                aria-hidden="true"></i>&nbsp;{{ __('Add To Cart') }}</button>
                                                    </div>
                                                </form>
                                            @else
                                                <a href="{{ route('login') }}" class="btn btn-primary"><i
                                                        class="fa fa-cart-plus"
                                                        aria-hidden="true"></i>&nbsp;{{ __('Add To Cart') }}</a>
                                            @endif

                                        </div>
                                    @endif
                                @else
                                    <div class="about-home-rate">
                                        <ul>
                                            <li>{{ __('Free') }}</li>
                                        </ul>
                                    </div>
                                    @if (Auth::check())
                                        @if (Auth::User()->role == 'admin')
                                            <div class="about-home-btn btm-20">
                                                <a href="{{ route('course.content', ['id' => $course->id, 'slug' => $course->slug]) }}"
                                                    class="btn btn-secondary"
                                                    title="course">{{ __('Go To Course') }}</a>
                                            </div>
                                        @else
                                            @php
                                                $enroll = App\Order::where('user_id', Auth::User()->id)
                                                    ->where('course_id', $course->id)
                                                    ->first();
                                            @endphp
                                            @if ($enroll == null)
                                                <div class="about-home-btn btm-20">
                                                    <a href="{{ url('enroll/show', $course->id) }}"
                                                        class="btn btn-primary"
                                                        title="Enroll Now">{{ __('Enroll Now') }}</a>
                                                </div>
                                            @else
                                                <div class="about-home-btn btm-20">
                                                    <a href="{{ route('course.content', ['id' => $course->id, 'slug' => $course->slug]) }}"
                                                        class="btn btn-secondary"
                                                        title="Cart">{{ __('Go To Course') }}</a>
                                                </div>
                                            @endif
                                        @endif
                                    @else
                                        <div class="about-home-btn btm-20">
                                            <a href="{{ route('login') }}" class="btn btn-primary"
                                                title="Enroll Now">{{ __('Enroll Now') }}</a>
                                        </div>
                                    @endif
                                @endif



                                @if (isset($course->refund_policy_id))
                                    <div class="refund-policy-block">
                                        @if (isset($course->policy))
                                            @php
                                                
                                                $days = $course->policy->days;
                                                
                                                $detail = $course->policy->detail;
                                            @endphp
                                            <div class="money-back-days">
                                                {{ $days }}-{{ __('Day Money-Back Guarantee') }}
                                                <button type="button" class="btn btn-secondary"
                                                    data-toggle="tooltip" data-placement="top" data-html="true"
                                                    title="{!! $detail !!}"><i
                                                        class="fas fa-info-circle"></i></button>
                                            </div>
                                        @endif

                                    </div>
                                @endif


                                <div class="about-home-includes-list btm-40">
                                    <ul class="btm-40">
                                        @if ($courseinclude->isNotEmpty())
                                            <li><span>{{ __('Course Includes') }}</span></li>
                                            @foreach ($course->include as $in)
                                                @if ($in->status == 1)
                                                    <li><i
                                                            class="fa {{ $in->icon }}"></i>{{ str_limit($in->detail, $limit = 50, $end = '...') }}
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endif
                                    </ul>

                                    <div class="about-tags">
                                        @if ($course['course_tags'] == !null)
                                            <span><i data-feather="tag"></i> {{ __('Tags') }}:</span>
                                            @php
                                                $tags = $course['course_tags'];
                                            @endphp
                                            @foreach ($tags as $tag)
                                                <a href="#">
                                                    <span class="badge badge-secondary">

                                                        <div class="badge-button">
                                                            <form method="GET" id="searchform"
                                                                action="{{ route('search') }}">
                                                                <input name="searchTerm" value="{{ $tag }}"
                                                                    type="hidden" />
                                                                <button type="submit">{{ $tag }}</button>
                                                            </form>
                                                        </div>

                                                    </span>
                                                </a>
                                            @endforeach
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <hr>

                                <div class="row">
                                    {{-- <div class="col-md-4">
                                        <div class="about-home-share text-center">
                                            <a href="https://calendar.google.com/calendar/r/eventedit?text={{ $course['title'] }}"
                                                target="__blank"><i data-feather="calendar"></i></a>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-4">
                                        <div class="about-home-share text-center">
                                            <a href="#" data-toggle="modal" data-target="#myModalshare"
                                                title="share" data-dismiss="modal"><i data-feather="share"></i></a>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-4">
                                        <div class="about-home-share text-center">
                                            @auth
                                                @if ($course->type == 1)
                                                    <div><a href="{{ route('gift.view', ['id' => $course->id, 'slug' => $course->slug]) }}"
                                                            title="gift"><i data-feather="gift"></i></a></div>
                                                @endif

                                            @endauth
                                            @guest
                                                @if ($course->type == 1)
                                                    <div><a href="{{ route('login') }}" title="gift"><i
                                                                data-feather="gift"></i></a></div>
                                                @endif
                                            @endguest
                                        </div>
                                    </div> --}}
                                    <div class="col-md-4">
                                        <div class="about-home-share text-center">
                                            @if (Auth::check())

                                                @if ($wish == null)
                                                    <div class="about-icon-one">
                                                        <form id="demo-form2" method="post"
                                                            action="{{ url('show/wishlist', $course->id) }}"
                                                            data-parsley-validate
                                                            class="form-horizontal form-label-left">
                                                            @csrf

                                                            <input type="hidden" name="user_id"
                                                                value="{{ Auth::User()->id }}" />
                                                            <input type="hidden" name="course_id"
                                                                value="{{ $course->id }}" />

                                                            <button class="wishlisht-btn"
                                                                title="{{ __('Add to wishlist') }}"
                                                                type="submit"><i data-feather="heart"></i></button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <div class="about-icon-two">
                                                        <form id="demo-form2" method="post"
                                                            action="{{ url('remove/wishlist', $course->id) }}"
                                                            data-parsley-validate
                                                            class="form-horizontal form-label-left">
                                                            @csrf

                                                            <input type="hidden" name="user_id"
                                                                value="{{ Auth::User()->id }}" />
                                                            <input type="hidden" name="course_id"
                                                                value="{{ $course->id }}" />

                                                            <button class="wishlisht-btn"
                                                                title="{{ __('Remove from Wishlist') }}"
                                                                type="submit"><i data-feather="heart"></i></button>
                                                        </form>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="about-icon-one"><a href="{{ route('login') }}"
                                                        title="heart"><i data-feather="heart"></i></a></div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="about-home-share text-center">
                                            @if (Auth::check())
                                                <div class="report-abuse text-center">
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#myModalCourse" title="Report"><i
                                                            data-feather="flag"></i></a>
                                                </div>
                                            @else
                                                <div class="report-abuse text-center">
                                                    <a href="{{ route('login') }}" title="Report"><i
                                                            data-feather="flag"></i></a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>




                                <!--Model start-->
                                <div class="modal fade" data-backdrop="" style="z-index: 1050;" id="myModalshare"
                                    tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">

                                                <h4 class="modal-title" id="myModalLabel">
                                                    {{ __('Share this course') }}</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close"><span
                                                        aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="box box-primary">
                                                <div class="panel panel-sum">
                                                    <div class="modal-body">

                                                        @php
                                                            $url = URL::current();
                                                        @endphp

                                                        <!-- The text field -->

                                                        <div class="nav-search">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control"
                                                                    id="myInput" value="{{ $url }}">
                                                            </div>
                                                            <button onclick="myFunction()" class="btn btn-primary"><i
                                                                    data-feather="copy"></i></button>
                                                        </div>

                                                        <div class="social-icon">

                                                            @php
                                                                
                                                                echo Share::currentPage('', [], '<div class="row">')
                                                                    ->facebook()
                                                                    ->twitter()
                                                                    ->linkedin('Extra linkedin summary can be passed here')
                                                                    ->whatsapp()
                                                                    ->telegram();
                                                                
                                                            @endphp

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Model close -->
                            </div>


                            <div class="container-fluid" id="adsense">
                                <!-- google adsense code -->
                                <?php
                                if (isset($ad)) {
                                    if ($ad->isdetail == 1 && $ad->status == 1) {
                                        $code = $ad->code;
                                        echo html_entity_decode($code);
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="about-content-sidebar" style="box-shadow: 0 2px 4px 0 rgb(0 0 0 / 43%);">
                        <div class="container">
                            <div class="about-content-img">
                                @if ($course->user['user_img'] !== null && $course->user['user_img'] !== '')
                                    <img src="{{ asset('images/user_img/' . $course->user['user_img']) }}"
                                        class="img-fluid" alt="">
                                @else
                                    <img src="{{ asset('images/default/user.png') }}" class="img-fluid"
                                        alt="">
                                @endif
                                <h5 class="about-content-heading">{{ optional($course->user)['fname'] }}
                                    {{ optional($course->user)['lname'] }}</h5>
                            </div>
                            <hr>
                            <div class="instructor-block text-center">

                                <div class="instructor-post btm-5">{{ __('About Instructor') }}</div>
                                @if (strlen($course->user['detail']) > 200)
                                    {{ substr($course->user['detail'], 0, 200) }}
                                    <span class="read-more-show hide_content"><br>+&nbsp;{{ __('See More') }}</span>
                                    <span class="read-more-content">
                                        {{ substr($course->user['detail'], 200, strlen($course->user['detail'])) }}
                                        <span
                                            class="read-more-hide hide_content"><br>-&nbsp;{{ __('See Less') }}</span>
                                    </span>
                                @else
                                    {{ $course->requirement }}
                                @endif
                                <!-- <p>{!! $course->user['detail'] !!}</p> -->
                            </div>
                            <hr>
                            <div class="ratings">
                                @php
                                    $enrolled = App\Order::where('instructor_id', $course->user->id)->count();
                                @endphp


                                <div class="star-rating">{{ __('Users Enrolled') }} {{ $enrolled }}
                                </div>
                            </div>

                            @php
                                $year = Carbon\Carbon::parse($course->user->created_at)->year;
                                $course_count = App\Course::where('user_id', $course->user->id)->count();
                                $enroll_count = App\Order::where('instructor_id', $course->user->id)->count();
                                $live_1 = App\Meeting::where('user_id', '=', $course->user->id)->count();
                                $live_2 = App\Googlemeet::where('user_id', '=', $course->user->id)->count();
                                $live_3 = App\JitsiMeeting::where('user_id', '=', $course->user->id)->count();
                                $live_4 = App\BBL::where('instructor_id', '=', $course->user->id)->count();
                                
                                $live_class = $live_1 + $live_2 + $live_3 + $live_4;
                            @endphp

                            <div class="about-reward-badges">
                                <img src="{{ url('images/badges/1.png') }}" class="img-fluid" alt=""
                                    data-toggle="tooltip" data-placement="bottom"
                                    title="Member Since {{ $year }}">
                                @if ($course_count >= 5)
                                    <img src="{{ url('images/badges/2.png') }}" class="img-fluid" alt=""
                                        data-toggle="tooltip" data-placement="bottom"
                                        title="Has {{ $course_count }} courses">
                                @endif
                                <img src="{{ url('images/badges/3.png') }}" class="img-fluid" alt=""
                                    data-toggle="tooltip" data-placement="bottom" title="rating from 4 to 5">
                                <img src="{{ url('images/badges/4.png') }}" class="img-fluid" alt=""
                                    data-toggle="tooltip" data-placement="bottom"
                                    title="{{ $enroll_count }} users has enrolled">
                                <img src="{{ url('images/badges/5.png') }}" class="img-fluid" alt=""
                                    data-toggle="tooltip" data-placement="bottom"
                                    title="Live classes {{ $live_class }}">
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    @php
                                        $fullnameIns = optional($course->user)->fname . ' ' . optional($course->user)->lname;
                                        $fullnameIns = preg_replace('/\s+/', '', $fullnameIns);
                                    @endphp
                                    <a href="{{ route('instructor.profile', ['id' => $course->user->id, 'name' => $fullnameIns]) }}"
                                        class="btn btn-primary" title="course">{{ __('Profile') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="display: flex; justify-content: space-between;">
            <div class="col-lg-7 col-md-7">
                @php
                    $alreadyrated = App\ReviewRating::where('course_id', $course->id)
                        ->limit(1)
                        ->first();
                @endphp
                @if ($alreadyrated == !null)
                    @if ($alreadyrated->featured == 1)
                        <div class="featured-review btm-40">
                            <h3>{{ __('Featured Review') }}</h3>
                            <?php
                            
                            $user_count = count([$alreadyrated]);
                            $user_sub_total = 0;
                            $user_learn_t = $alreadyrated->learn * 5;
                            $user_price_t = $alreadyrated->price * 5;
                            $user_value_t = $alreadyrated->value * 5;
                            $user_sub_total = $user_sub_total + $user_learn_t + $user_price_t + $user_value_t;
                            
                            $user_count = $user_count * 3 * 5;
                            $rat1 = $user_sub_total / $user_count;
                            $ratings_var1 = ($rat1 * 100) / 5;
                            
                            ?>
                            @if (isset($alreadyrated))

                                @foreach ($coursereviews as $rating)
                                    @if ($rating->review == !null && $rating->featured == 1)
                                        <div class="featured-review-block">
                                            <div class="row">
                                                <div class="col-lg-2 col-sm-3 col-4">
                                                    <div class="featured-review-img">
                                                        <div class="review-img text-white">
                                                            {{ str_limit($rating->user->fname ?? '', $limit = 1, $end = '') }}{{ str_limit($rating->user->lname ?? '', $limit = 1, $end = '') }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10 col-sm-9 col-8">
                                                    <div class="featured-review-img-dtl">
                                                        <div class="review-img-name"><span>
                                                                @if (isset($rating->user))
                                                                    {{ $rating->user['fname'] }}
                                                                    {{ $rating->user['lname'] }}
                                                                @endif
                                                            </span></div>
                                                        <div class="pull-left">
                                                            <div class="star-ratings-sprite"><span
                                                                    style="width:<?php echo $ratings_var1; ?>%"
                                                                    class="star-ratings-sprite-rating"></span>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="year btm-20">
                                                            {{ date('jS F Y', strtotime($rating['created_at'])) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="btm-20">{{ $rating['review'] }}</p>

                                            @auth
                                                <div class="review">{{ __('helpful') }}?
                                                    @php
                                                        $help = App\ReviewHelpful::where('user_id', Auth::User()->id)
                                                            ->where('review_id', $rating->id)
                                                            ->first();
                                                    @endphp



                                                    @if (isset($help['review_like']) == '1')
                                                        <div class="helpful">

                                                            <form method="post"
                                                                action="{{ route('helpful', $course->id) }}"
                                                                data-parsley-validate
                                                                class="form-horizontal form-label-left">
                                                                {{ csrf_field() }}

                                                                <input type="hidden" name="user_id"
                                                                    value="{{ Auth::User()->id }}" />

                                                                <input type="hidden" name="review_id"
                                                                    value="{{ $rating->id }}" />

                                                                <input type="hidden" name="helpful" value="yes" />
                                                                <input type="hidden" name="review_like"
                                                                    value="0" />

                                                                <button type="submit"
                                                                    class="btn btn-link lft-7 rgt-10 "><i
                                                                        class="fa fa-check"></i>
                                                                    {{ __('Yes') }}</button>
                                                            </form>
                                                        </div>
                                                    @else
                                                        <div class="helpful">
                                                            <form method="post"
                                                                action="{{ route('helpful', $course->id) }}"
                                                                data-parsley-validate
                                                                class="form-horizontal form-label-left">
                                                                {{ csrf_field() }}

                                                                <input type="hidden" name="user_id"
                                                                    value="{{ Auth::User()->id }}" />

                                                                <input type="hidden" name="review_id"
                                                                    value="{{ $rating->id }}" />

                                                                <input type="hidden" name="helpful" value="yes" />
                                                                <input type="hidden" name="review_like"
                                                                    value="1" />

                                                                <button type="submit"
                                                                    class="btn btn-link lft-7 rgt-10 ">{{ __('Yes') }}</button>
                                                            </form>
                                                        </div>
                                                    @endif



                                                    @if (isset($help['review_dislike']) == '1')
                                                        <div class="helpful">


                                                            <form method="post"
                                                                action="{{ route('helpful', $course->id) }}"
                                                                data-parsley-validate
                                                                class="form-horizontal form-label-left">
                                                                {{ csrf_field() }}

                                                                <input type="hidden" name="user_id"
                                                                    value="{{ Auth::User()->id }}" />

                                                                <input type="hidden" name="review_id"
                                                                    value="{{ $rating->id }}" />

                                                                <input type="hidden" name="helpful" value="yes" />
                                                                <input type="hidden" name="review_dislike"
                                                                    value="0" />

                                                                <button type="submit"
                                                                    class="btn btn-link lft-7 rgt-10 "><i
                                                                        class="fa fa-check"></i>{{ __('No') }}</button>
                                                            </form>
                                                        </div>
                                                    @else
                                                        <div class="helpful">
                                                            <form method="post"
                                                                action="{{ route('helpful', $course->id) }}"
                                                                data-parsley-validate
                                                                class="form-horizontal form-label-left">
                                                                {{ csrf_field() }}

                                                                <input type="hidden" name="user_id"
                                                                    value="{{ Auth::User()->id }}" />

                                                                <input type="hidden" name="review_id"
                                                                    value="{{ $rating->id }}" />

                                                                <input type="hidden" name="helpful" value="yes" />
                                                                <input type="hidden" name="review_dislike"
                                                                    value="1" />

                                                                <button type="submit"
                                                                    class="btn btn-link lft-7 rgt-10 ">{{ __('No') }}</button>
                                                            </form>
                                                        </div>
                                                    @endif



                                                    <a href="#" data-toggle="modal" data-target="#myModalreport"
                                                        title="report">{{ __('Report') }}</a>

                                                </div>

                                            @endauth
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    @endif
                @endif


                @if (!$reviews->isEmpty())
                    <div class="student-feedback btm-40">
                        <h3 class="student-feedback-heading">{{ __('Student Feedback') }}</h3>
                        <div class="student-feedback-block">

                            <div class="rating">
                                <?php
                                $learn = 0;
                                $price = 0;
                                $value = 0;
                                $sub_total = 0;
                                $count = count($reviews);
                                $onlyrev = [];
                                
                                $reviewcount = App\ReviewRating::where('course_id', 1)
                                    ->where('status', '1')
                                    ->WhereNotNull('review')
                                    ->get();
                                
                                foreach ($reviews as $review) {
                                    $learn = $review->learn * 5;
                                    $price = $review->price * 5;
                                    $value = $review->value * 5;
                                    $sub_total = $sub_total + $learn + $price + $value;
                                }
                                
                                $count = $count * 3 * 5;
                                
                                if ($count != 0) {
                                    $rat = $sub_total / $count;
                                
                                    $ratings_var = ($rat * 100) / 5;
                                
                                    $overallrating = $ratings_var / 2 / 10;
                                }
                                
                                ?>

                                <div class="rating-num">{{ round($overallrating, 1) }}</div>

                                <?php
                                $learn = 0;
                                $price = 0;
                                $value = 0;
                                $sub_total = 0;
                                $sub_total = 0;
                                $reviews = App\ReviewRating::where('course_id', $course->id)
                                    ->where('status', '1')
                                    ->get();
                                ?>
                                @if (!empty($reviews[0]))
                                    <?php
                                    $count = App\ReviewRating::where('course_id', $course->id)->count();
                                    
                                    foreach ($reviews as $review) {
                                        $learn = $review->learn * 5;
                                        $price = $review->price * 5;
                                        $value = $review->value * 5;
                                        $sub_total = $sub_total + $learn + $price + $value;
                                    }
                                    
                                    $count = $count * 3 * 5;
                                    $rat = $sub_total / $count;
                                    $ratings_var = ($rat * 100) / 5;
                                    ?>
                                    <div class="pull-left">
                                        <div class="star-ratings-sprite star-ratings-center"><span
                                                style="width:<?php echo $ratings_var; ?>%"
                                                class="star-ratings-sprite-rating"></span>
                                        </div>
                                    </div>
                                @else
                                    <div class="pull-left">
                                        <div class="star-ratings-sprite star-ratings-center"><span style="width:%"
                                                class="star-ratings-sprite-rating"></span>
                                        </div>
                                    </div>
                                @endif
                                <div class="rating-users">{{ __('Course Rating') }}</div>
                            </div>
                            <div class="histo">
                                <div class="three histo-rate">
                                    <span class="histo-star">
                                        <?php
                                        $learn = 0;
                                        $total = 0;
                                        $reviews = App\ReviewRating::where('course_id', $course->id)
                                            ->where('status', '1')
                                            ->get();
                                        ?>
                                        @if (!empty($reviews[0]))
                                            <?php
                                            $count = App\ReviewRating::where('course_id', $course->id)->count();
                                            
                                            foreach ($reviews as $review) {
                                                $learn = $review->learn * 5;
                                                $total = $total + $learn;
                                            }
                                            
                                            $count = $count * 1 * 5;
                                            $rat = $total / $count;
                                            $ratings_var = ($rat * 100) / 5;
                                            ?>

                                            <div class="pull-left">
                                                <div class="star-ratings-sprite star-ratings-center"><span
                                                        style="width:<?php echo $ratings_var; ?>%"
                                                        class="star-ratings-sprite-rating"></span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="pull-left">
                                                <div class="star-ratings-sprite star-ratings-center"><span
                                                        style="width:%" class="star-ratings-sprite-rating"></span>
                                                </div>
                                            </div>
                                        @endif
                                    </span>
                                    <span class="histo-percent">
                                        <a href="#" title="rate">{{ round($ratings_var) }}%</a>
                                    </span>
                                    <span class="bar-block">
                                        <span id="bar-three" style=" width:{{ $ratings_var }}%;"
                                            class="bar bar-clr bar-radius">&nbsp;</span>
                                    </span>
                                </div>
                                <div class="two histo-rate">
                                    <span class="histo-star">
                                        <?php
                                        $price = 0;
                                        $total = 0;
                                        $reviews = App\ReviewRating::where('course_id', $course->id)
                                            ->where('status', '1')
                                            ->get();
                                        ?>
                                        @if (!empty($reviews[0]))
                                            <?php
                                            $count = App\ReviewRating::where('course_id', $course->id)->count();
                                            
                                            foreach ($reviews as $review) {
                                                $price = $review->price * 5;
                                                $total = $total + $price;
                                            }
                                            
                                            $count = $count * 1 * 5;
                                            $rat = $total / $count;
                                            $ratings_var = ($rat * 100) / 5;
                                            ?>

                                            <div class="pull-left">
                                                <div class="star-ratings-sprite star-ratings-center"><span
                                                        style="width:<?php echo $ratings_var; ?>%"
                                                        class="star-ratings-sprite-rating"></span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="pull-left">
                                                <div class="star-ratings-sprite star-ratings-center"><span
                                                        style="width:%" class="star-ratings-sprite-rating"></span>
                                                </div>
                                            </div>
                                        @endif
                                    </span>
                                    <span class="histo-percent">
                                        <a href="#" title="rate">{{ round($ratings_var) }}%</a>
                                    </span>
                                    <span class="bar-block">
                                        <span id="bar-two" style="width: {{ $ratings_var }}%"
                                            class="bar bar-clr bar-radius">&nbsp;</span>
                                    </span>
                                </div>
                                <div class="one histo-rate">
                                    <span class="histo-star">
                                        <?php
                                        $value = 0;
                                        $total = 0;
                                        $reviews = App\ReviewRating::where('course_id', $course->id)
                                            ->where('status', '1')
                                            ->get();
                                        ?>
                                        @if (!empty($reviews[0]))
                                            <?php
                                            $count = App\ReviewRating::where('course_id', $course->id)->count();
                                            
                                            foreach ($reviews as $review) {
                                                $value = $review->value * 5;
                                                $total = $total + $value;
                                            }
                                            
                                            $count = $count * 1 * 5;
                                            $rat = $total / $count;
                                            $ratings_var = ($rat * 100) / 5;
                                            ?>

                                            <div class="pull-left">
                                                <div class="star-ratings-sprite star-ratings-center"><span
                                                        style="width:<?php echo $ratings_var; ?>%"
                                                        class="star-ratings-sprite-rating"></span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="pull-left">
                                                <div class="star-ratings-sprite star-ratings-center"><span
                                                        style="width:%" class="star-ratings-sprite-rating"></span>
                                                </div>
                                            </div>
                                        @endif
                                    </span>
                                    <span class="histo-percent">
                                        <a href="#" title="rate">{{ round($ratings_var) }}%</a>
                                    </span>
                                    <span class="bar-block">
                                        <span id="bar-one" style="width: {{ $ratings_var }}%"
                                            class="bar bar-clr bar-radius">&nbsp;</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                @endif

                <div class="learning-review btm-40">

                    @auth
                        {{-- @php
                        $orders = App\Order::where('user_id', Auth::User()->id)->where('course_id', $course->id)->first();
                    @endphp --}}


                        @php
                            $user_enrolled = App\Order::where('course_id', $course->id)
                                ->where('user_id', Auth::user()->id)
                                ->first();
                            
                            $bundle = App\Order::where('user_id', Auth::User()->id)
                                ->where('bundle_id', '!=', null)
                                ->get();
                            
                            $course_id = [];
                            
                            foreach ($bundle as $b) {
                                $bundle = App\BundleCourse::where('id', $b->bundle_id)->first();
                                array_push($course_id, $bundle->course_id);
                            }
                            
                            $course_id = array_values(array_filter($course_id));
                            
                            $course_id = array_flatten($course_id);
                            
                        @endphp


                        @if ($user_enrolled != null || Auth::user()->role == 'admin' || isset($course_id) || in_array($course->id, $course_id))
                            <div class="review-block">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <h3 class="top-20">{{ __('Reviews') }}</h3>
                                    </div>
                                    <div class="col-lg-10 col-12">
                                        <form id="demo-form2" method="post"
                                            action="{{ route('course.rating', $course->id) }}" data-parsley-validate
                                            class="form-horizontal form-label-left">
                                            {{ csrf_field() }}
                                            <div class="review-table">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">{{ __('Learn') }}</th>
                                                            <td>
                                                                <div class="star-rating">
                                                                    <input id="option1" type="radio" name="learn"
                                                                        value="5" />
                                                                    <label for="option1" title="5 stars">
                                                                        <i class="active fa fa-star mrg-lft"
                                                                            aria-hidden="true"></i>
                                                                    </label>
                                                                    <input id="option2" type="radio" name="learn"
                                                                        value="4" />
                                                                    <label for="option2" title="4 stars">
                                                                        <i class="active fa fa-star mrg-lft"
                                                                            aria-hidden="true"></i>
                                                                    </label>
                                                                    <input id="option3" type="radio" name="learn"
                                                                        value="3" />
                                                                    <label for="option3" title="3 stars">
                                                                        <i class="active fa fa-star mrg-lft"
                                                                            aria-hidden="true"></i>
                                                                    </label>
                                                                    <input id="option4" type="radio" name="learn"
                                                                        value="2" />
                                                                    <label for="option4" title="2 stars">
                                                                        <i class="active fa fa-star mrg-lft"
                                                                            aria-hidden="true"></i>
                                                                    </label>
                                                                    <input id="option5" type="radio" name="learn"
                                                                        value="1" />
                                                                    <label for="option5" title="1 star">
                                                                        <i class="active fa fa-star mrg-lft"
                                                                            aria-hidden="true"></i>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('Price') }}</th>
                                                            <td>
                                                                <div class="star-rating">
                                                                    <input id="option6" type="radio" name="price"
                                                                        value="5" />
                                                                    <label for="option6" title="5 stars">
                                                                        <i class="active fa fa-star mrg-lft"
                                                                            aria-hidden="true"></i>
                                                                    </label>
                                                                    <input id="option7" type="radio" name="price"
                                                                        value="4" />
                                                                    <label for="option7" title="4 stars">
                                                                        <i class="active fa fa-star mrg-lft"
                                                                            aria-hidden="true"></i>
                                                                    </label>
                                                                    <input id="option8" type="radio" name="price"
                                                                        value="3" />
                                                                    <label for="option8" title="3 stars">
                                                                        <i class="active fa fa-star mrg-lft"
                                                                            aria-hidden="true"></i>
                                                                    </label>
                                                                    <input id="option9" type="radio" name="price"
                                                                        value="2" />
                                                                    <label for="option9" title="2 stars">
                                                                        <i class="active fa fa-star mrg-lft"
                                                                            aria-hidden="true"></i>
                                                                    </label>
                                                                    <input id="option10" type="radio" name="price"
                                                                        value="1" />
                                                                    <label for="option10" title="1 star">
                                                                        <i class="active fa fa-star mrg-lft"
                                                                            aria-hidden="true"></i>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">{{ __('Value') }}</th>
                                                            <td>
                                                                <div class="star-rating">
                                                                    <input id="option11" type="radio" name="value"
                                                                        value="5" />
                                                                    <label for="option11" title="5 stars">
                                                                        <i class="active fa fa-star mrg-lft"
                                                                            aria-hidden="true"></i>
                                                                    </label>
                                                                    <input id="option12" type="radio" name="value"
                                                                        value="4" />
                                                                    <label for="option12" title="4 stars">
                                                                        <i class="active fa fa-star mrg-lft"
                                                                            aria-hidden="true"></i>
                                                                    </label>
                                                                    <input id="option13" type="radio"
                                                                        name="value" value="3" />
                                                                    <label for="option13" title="3 stars">
                                                                        <i class="active fa fa-star mrg-lft"
                                                                            aria-hidden="true"></i>
                                                                    </label>
                                                                    <input id="option14" type="radio"
                                                                        name="value" value="2" />
                                                                    <label for="option14" title="2 stars">
                                                                        <i class="active fa fa-star mrg-lft"
                                                                            aria-hidden="true"></i>
                                                                    </label>
                                                                    <input id="option15" type="radio"
                                                                        name="value" value="1" />
                                                                    <label for="option15" title="1 star">
                                                                        <i class="active fa fa-star mrg-lft"
                                                                            aria-hidden="true"></i>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="review-text btm-30">
                                                    <label for="review">{{ __('Write review') }}:</label>
                                                    <textarea name="review" rows="4" class="form-control" placeholder=""></textarea>
                                                </div>
                                                <div class="review-rating-btn text-right">
                                                    <button type="submit" class="btn btn-success"
                                                        title="Review">{{ __('Submit') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        @endif
                    @endauth


                    @php
                        $alreadyrated = App\ReviewRating::where('course_id', $course->id)->first();
                    @endphp
                    @if ($alreadyrated == !null)

                        <div class="review-dtl">

                            @if (isset($alreadyrated))
                                @foreach ($course->review as $rating)
                                    <?php
                                    
                                    $user_count = count([$rating]);
                                    $user_sub_total = 0;
                                    $user_learn_t = $rating->learn * 5;
                                    $user_price_t = $rating->price * 5;
                                    $user_value_t = $rating->value * 5;
                                    $user_sub_total = $user_sub_total + $user_learn_t + $user_price_t + $user_value_t;
                                    
                                    $user_count = $user_count * 3 * 5;
                                    $rat1 = $user_sub_total / $user_count;
                                    $ratings_var7 = ($rat1 * 100) / 5;
                                    
                                    ?>

                                    @if ($rating->review == !null && $rating->status == 1 && $rating->approved == 1)
                                        <div class="row btm-20">
                                            <div class="col-lg-4">
                                                <div class="review-img text-white">
                                                    {{ str_limit($rating->user->fname, $limit = 1, $end = '') }}{{ str_limit($rating->user->lname, $limit = 1, $end = '') }}
                                                </div>
                                                <div class="review-img-block">
                                                    <div class="review-month">
                                                        {{ date('d-m-Y', strtotime($rating['created_at'])) }}
                                                    </div>
                                                    <div class="review-name">{{ $rating->user['fname'] }}
                                                        {{ $rating->user['lname'] }}</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="review-rating">
                                                    <div class="pull-left-review">
                                                        <div class="star-ratings-sprite"><span
                                                                style="width:<?php echo $ratings_var7; ?>%"
                                                                class="star-ratings-sprite-rating"></span>
                                                        </div>
                                                    </div>
                                                    <div class="review-text">
                                                        <p>{{ $rating['review'] }}
                                                        <p>
                                                    </div>

                                                    @auth

                                                        <div class="review">{{ __('helpful') }}?
                                                            @php
                                                                $help = App\ReviewHelpful::where('user_id', Auth::User()->id)
                                                                    ->where('review_id', $rating->id)
                                                                    ->first();
                                                            @endphp



                                                            @if (isset($help['review_like']) == '1')
                                                                <div class="helpful">

                                                                    <form method="post"
                                                                        action="{{ route('helpful', $course->id) }}"
                                                                        data-parsley-validate
                                                                        class="form-horizontal form-label-left">
                                                                        {{ csrf_field() }}

                                                                        <input type="hidden" name="user_id"
                                                                            value="{{ Auth::User()->id }}" />

                                                                        <input type="hidden" name="review_id"
                                                                            value="{{ $rating->id }}" />

                                                                        <input type="hidden" name="helpful"
                                                                            value="yes" />
                                                                        <input type="hidden" name="review_like"
                                                                            value="0" />

                                                                        <button type="submit"
                                                                            class="btn btn-link lft-7 rgt-10 "><i
                                                                                class="fa fa-check"></i>
                                                                            {{ __('Yes') }}</button>
                                                                    </form>
                                                                </div>
                                                            @else
                                                                <div class="helpful">
                                                                    <form method="post"
                                                                        action="{{ route('helpful', $course->id) }}"
                                                                        data-parsley-validate
                                                                        class="form-horizontal form-label-left">
                                                                        {{ csrf_field() }}

                                                                        <input type="hidden" name="user_id"
                                                                            value="{{ Auth::User()->id }}" />

                                                                        <input type="hidden" name="review_id"
                                                                            value="{{ $rating->id }}" />

                                                                        <input type="hidden" name="helpful"
                                                                            value="yes" />
                                                                        <input type="hidden" name="review_like"
                                                                            value="1" />

                                                                        <button type="submit"
                                                                            class="btn btn-link lft-7 rgt-10 ">{{ __('Yes') }}</button>
                                                                    </form>
                                                                </div>
                                                            @endif



                                                            @if (isset($help['review_dislike']) == '1')
                                                                <div class="helpful">


                                                                    <form method="post"
                                                                        action="{{ route('helpful', $course->id) }}"
                                                                        data-parsley-validate
                                                                        class="form-horizontal form-label-left">
                                                                        {{ csrf_field() }}

                                                                        <input type="hidden" name="user_id"
                                                                            value="{{ Auth::User()->id }}" />

                                                                        <input type="hidden" name="review_id"
                                                                            value="{{ $rating->id }}" />

                                                                        <input type="hidden" name="helpful"
                                                                            value="yes" />
                                                                        <input type="hidden" name="review_dislike"
                                                                            value="0" />

                                                                        <button type="submit"
                                                                            class="btn btn-link lft-7 rgt-10 "><i
                                                                                class="fa fa-check"></i>{{ __('No') }}</button>
                                                                    </form>
                                                                </div>
                                                            @else
                                                                <div class="helpful">
                                                                    <form method="post"
                                                                        action="{{ route('helpful', $course->id) }}"
                                                                        data-parsley-validate
                                                                        class="form-horizontal form-label-left">
                                                                        {{ csrf_field() }}

                                                                        <input type="hidden" name="user_id"
                                                                            value="{{ Auth::User()->id }}" />

                                                                        <input type="hidden" name="review_id"
                                                                            value="{{ $rating->id }}" />

                                                                        <input type="hidden" name="helpful"
                                                                            value="yes" />
                                                                        <input type="hidden" name="review_dislike"
                                                                            value="1" />

                                                                        <button type="submit"
                                                                            class="btn btn-link lft-7 rgt-10 ">{{ __('No') }}</button>
                                                                    </form>
                                                                </div>
                                                            @endif


                                                            {{-- report --}}
                                                            <a href="#" data-toggle="modal"
                                                                data-target="#myModalreport"
                                                                title="report">{{ __('Report') }}</a>
                                                            <div class="modal fade" id="myModalreport" tabindex="-1"
                                                                role="dialog" aria-labelledby="myModalLabel">
                                                                <div class="modal-dialog modal-lg" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title" id="myModalLabel">
                                                                                {{ __('Report') }}</h4>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal"
                                                                                aria-label="Close"><span
                                                                                    aria-hidden="true">&times;</span></button>
                                                                        </div>
                                                                        <div class="box box-primary">
                                                                            <div class="panel panel-sum">
                                                                                <div class="modal-body">
                                                                                    @php
                                                                                        $courses = App\Course::first();
                                                                                    @endphp
                                                                                    <form id="demo-form2" method="post"
                                                                                        action="{{ route('report.review', $course->id) }}"
                                                                                        data-parsley-validate
                                                                                        class="form-horizontal form-label-left">
                                                                                        {{ csrf_field() }}

                                                                                        <input type="hidden"
                                                                                            name="review_id"
                                                                                            value="{{ $rating->id }}" />

                                                                                        <div class="row">
                                                                                            <div class="col-md-6">
                                                                                                <div class="form-group">
                                                                                                    <label
                                                                                                        for="title">{{ __('Title') }}:<sup
                                                                                                            class="redstar">*</sup></label>
                                                                                                    <input type="text"
                                                                                                        class="form-control"
                                                                                                        name="title"
                                                                                                        id="title"
                                                                                                        placeholder="Please Enter Title"
                                                                                                        value="">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <div class="form-group">
                                                                                                    <label
                                                                                                        for="email">{{ __('Email') }}:<sup
                                                                                                            class="redstar">*</sup></label>
                                                                                                    <input type="email"
                                                                                                        class="form-control"
                                                                                                        name="email"
                                                                                                        id="title"
                                                                                                        placeholder="Please Enter Email"
                                                                                                        value="{{ Auth::User()->email }}"
                                                                                                        required>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <div class="form-group">
                                                                                                    <label
                                                                                                        for="detail">{{ __('Detail') }}:<sup
                                                                                                            class="redstar">*</sup></label>
                                                                                                    <blade
                                                                                                        ___html_tags_1___ />
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <br>
                                                                                        <div class="box-footer">
                                                                                            <button type="submit"
                                                                                                class="btn btn-lg col-md-3 btn-primary">{{ __('Submit') }}</button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    @endauth


                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    @endif

                </div>
                <!--Model start-->
                @auth
                    <div class="modal fade" id="myModalCourse" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <h4 class="modal-title" id="myModalLabel">{{ __('Report') }}</h4>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="box box-primary">
                                    <div class="panel panel-sum">
                                        <div class="modal-body">

                                            <form id="demo-form2" method="post"
                                                action="{{ route('course.report', $course->id) }}" data-parsley-validate
                                                class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="title">{{ __('Title') }}:<sup
                                                                    class="redstar">*</sup></label>
                                                            <input type="text" class="form-control" name="title"
                                                                id="title"
                                                                placeholder="{{ __('Please Enter Title') }}"
                                                                value="" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="email">{{ __('Email') }}:<sup
                                                                    class="redstar">*</sup></label>
                                                            <input type="email" class="form-control" name="email"
                                                                placeholder="{{ __('Please Enter Email') }}"
                                                                value="{{ Auth::user()->email }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="detail">{{ __('Detail') }}:<sup
                                                                    class="redstar">*</sup></label>
                                                            <textarea name="detail" rows="4" class="form-control" placeholder="{{ __('Please Enter Detail') }}"
                                                                required></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="box-footer">
                                                    <button type="submit"
                                                        class="btn btn-lg col-md-3 btn-primary">{{ __('Submit') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</section>
<!-- course detail end -->
@endsection


@section('custom-script')
<script>
    $(function() {
        $('#myTab li:last-child button').tab('show')
    })
</script>
<script>
    function myFunction() {
        /* Get the text field */
        var copyText = document.getElementById("myInput");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        /* Copy the text inside the text field */
        navigator.clipboard.writeText(copyText.value);

        /* Alert the copied text */
    }
</script>
<script>
    // Hide the extra content initially, using JS so that if JS is disabled, no problemo:
    $('.read-more-content').addClass('hide_content')
    $('.read-more-show, .read-more-hide').removeClass('hide_content')

    // Set up the toggle effect:
    $('.read-more-show').on('click', function(e) {
        $(this).next('.read-more-content').removeClass('hide_content');
        $(this).addClass('hide_content');
        e.preventDefault();
    });

    // Changes contributed by @diego-rzg
    $('.read-more-hide').on('click', function(e) {
        var p = $(this).parent('.read-more-content');
        p.addClass('hide_content');
        p.prev('.read-more-show').removeClass('hide_content'); // Hide only the preceding "Read More"
        e.preventDefault();
    });
</script>

<script>
    (function($) {
        "use strict";
        $(document).ready(function() {

            $(".group1").colorbox({
                rel: 'group1'
            });
            $(".group2").colorbox({
                rel: 'group2',
                transition: "fade"
            });
            $(".group3").colorbox({
                rel: 'group3',
                transition: "none",
                width: "75%",
                height: "75%"
            });
            $(".group4").colorbox({
                rel: 'group4',
                slideshow: true
            });
            $(".ajax").colorbox();
            $(".youtube").colorbox({
                iframe: true,
                innerWidth: 640,
                innerHeight: 390
            });
            $(".vimeo").colorbox({
                iframe: true,
                innerWidth: 500,
                innerHeight: 409
            });
            $(".iframe").colorbox({
                iframe: true,
                width: "50%",
                height: "50%"
            });
            $(".inline").colorbox({
                inline: true,
                width: "50%"
            });
            $(".callbacks").colorbox({
                onOpen: function() {
                    alert('onOpen: colorbox is about to open');
                },
                onLoad: function() {
                    alert('onLoad: colorbox has started to load the targeted content');
                },
                onComplete: function() {
                    alert('onComplete: colorbox has displayed the loaded content');
                },
                onCleanup: function() {
                    alert('onCleanup: colorbox has begun the close process');
                },
                onClosed: function() {
                    alert('onClosed: colorbox has completely closed');
                }
            });

            $('.non-retina').colorbox({
                rel: 'group5',
                transition: 'none'
            })
            $('.retina').colorbox({
                rel: 'group5',
                transition: 'none',
                retinaImage: true,
                retinaUrl: true
            });


            $("#click").click(function() {
                $('#click').css({
                    "background-color": "#f00",
                    "color": "#fff",
                    "cursor": "inherit"
                }).text("Open this window again and this message will still be here.");
                return false;
            });
        });
    })(jQuery);
</script>

<script>
    /* it seems javascript..*/
    var topLimit = $('#about-bar-fixed').offset().top;
    var topLimit = $('#bar-fixed').offset().top;
    $(window).scroll(function() {
        //console.log(topLimit <= $(window).scrollTop())
        if (topLimit <= $(window).scrollTop()) {
            $('#about-bar-fixed').addClass('stickIt')
            // $('#bar-fixed').addClass('stickIt')
        } else {
            $('#about-bar-fixed').removeClass('stickIt')
            // $('#bar-fixed').removeClass('stickIt')
        }
    })
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $(this).on("click", ".koh-faq-question", function() {
            $(this).parent().find(".koh-faq-answer").toggle();
            $(this).find(".fa").toggleClass('active');
        });
    });
</script>
<script>
    // FSMS
    function toggleAllSections() {
        $("div[id*='collapseTwo']").collapse('toggle');
        $(".courseToggle").toggle();
    }
    // FSMS
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {

        const controls = [
            'play-large', // The large play button in the center
            'restart', // Restart playback
            'rewind', // Rewind by the seek time (default 10 seconds)
            'play', // Play/pause playback
            'fast-forward', // Fast forward by the seek time (default 10 seconds)
            'progress', // The progress bar and scrubber for playback and buffering
            'current-time', // The current time of playback
            'duration', // The full duration of the media
            'mute', // Toggle mute
            'volume', // Volume control
            'captions', // Toggle captions
            'settings', // Settings menu
            'pip', // Picture-in-picture (currently Safari only)
            'airplay', // Airplay (currently Safari only)
            // 'download', // Show a download button with a link to either the current source or a custom URL you specify in your options
            'fullscreen' // Toggle fullscreen
        ];

        const player = Plyr.setup('.js-player', {
            controls
        });

    });
</script>
<script src="https://cdn.plyr.io/3.7.3/plyr.js"></script>
@endsection


<style type="text/css">
.read-more-show {
    cursor: pointer;
    color: #0284A2;
}

.read-more-hide {
    cursor: pointer;
    color: #0284A2;
}

.hide_content {
    display: none;
}
</style>
