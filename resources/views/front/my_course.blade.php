@extends('theme.master')
@section('title', 'My Courses')
@section('content')
    @include('admin.message')
    <!-- about-home start -->
    @php
        $gets = App\Breadcum::first();
    @endphp
    @if (isset($gets))
        <section id="business-home" class="business-home-main-block">
            <div class="business-img">
                @if ($gets['img'] !== null && $gets['img'] !== '')
                    <img src="{{ url('/images/breadcum/' . $gets->img) }}" class="img-fluid" alt="" />
                @else
                    <img src="{{ Avatar::create($gets->text)->toBase64() }}" alt="course" class="img-fluid">
                @endif
            </div>
            <div class="overlay-bg"></div>
            <div class="container-fluid">
                <div class="business-dtl">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="bredcrumb-dtl">
                                <h1 class="wishlist-home-heading">{{ __('My Courses') }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- about-home end -->
    @php
        $user_enrolled = App\Order::where('refunded', '0')
            ->where('user_id', Auth::user()->id)
            ->get();
    @endphp
    @foreach ($user_enrolled as $enrolled)
        @php
            $bigbluemeeting = App\BBL::where('course_id', '=', $enrolled->course_id)
                ->where('is_ended', '!=', 1)
                ->where('link_by', '!=', null)
                ->get();
            $zoommeeting = App\Meeting::where('course_id', '=', $enrolled->course_id)
                ->where('link_by', '!=', null)
                ->get();
        @endphp

        @if (count($bigbluemeeting) > 0)
            <section id="learning-courses" class="learning-courses-main-block">
                <div class="container">
                    <h4 class="student-heading">{{ __('BigBlue Meetings') }}</h4>
                    <div class="row">
                        @foreach ($bigbluemeeting as $bbl)
                            <div class="col-lg-3 col-sm-6">

                                <div class="view-block">
                                    <div class="view-img">
                                        <a href="{{ route('bbl.detail', $bbl->id) }}"><img
                                                src="{{ Avatar::create($bbl['meetingname'])->toBase64() }}" alt="course"
                                                class="img-fluid"></a>
                                    </div>
                                    <div class="view-dtl">
                                        <div class="view-heading btm-10"><a
                                                href="{{ route('bbl.detail', $bbl->id) }}">{{ str_limit($bbl['meetingname'], $limit = 30, $end = '...') }}</a>
                                        </div>
                                        <p class="btm-10"><a herf="#">{{ __('by') }} @if (isset($bbl->user))
                                                    {{ $bbl->user['fname'] }}
                                                @endif </a></p>

                                        @if (isset($bbl['start_time']))
                                            <p class="btm-10"><a herf="#">{{ __('Start At') }}:
                                                    {{ date('d-m-Y | h:i:s A', strtotime($bbl['start_time'])) }}</a></p>
                                        @endif

                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        @if (count($zoommeeting) > 0)
            <section id="learning-courses" class="learning-courses-main-block">
                <div class="container">
                    <h4 class="student-heading">{{ __('Zoom Meetings') }}</h4>
                    <div class="row">
                        @foreach ($zoommeeting as $meeting)
                            <div class="col-lg-3 col-sm-6">

                                <div class="view-block">
                                    <div class="view-img">
                                        @if ($meeting['meeting_title'] !== null && $meeting['meeting_title'] !== '')
                                            <a href="{{ route('zoom.detail', $meeting->id) }}"><img
                                                    src="{{ Avatar::create($meeting['meeting_title'])->toBase64() }}"
                                                    alt="course" class="img-fluid"></a>
                                        @endif
                                    </div>
                                    <div class="view-dtl">
                                        <div class="view-heading"><a href="#">
                                                {{ str_limit($meeting->meeting_title, $limit = 30, $end = '...') }}</a>
                                        </div>
                                        <div class="user-name">
                                            <h6>By <span>{{ optional($meeting->user)['fname'] }}</span></h6>
                                        </div>
                                        <!--
                                <p class="btm-10"><a herf="#">{{ __('by') }} @if (isset($meeting->user))
    {{ $meeting->user['fname'] }}
    @endif
        </a>
        </p> -->
                                        <div class="view-footer">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                                    <div class="view-date">
                                                        <a href="#"><i data-feather="calendar"></i>
                                                            {{ date('d-m-Y', strtotime($meeting['start_time'])) }}</a>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                                    <div class="view-time">
                                                        <a href="#"><i data-feather="clock"></i>
                                                            {{ date('h:i:s A', strtotime($meeting['start_time'])) }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- @if (isset($meeting['start_time']))
    <p class="btm-10"><a herf="#">Start At:
                                        {{ date('d-m-Y | h:i:s A', strtotime($meeting['start_time'])) }}</a></p>
    @endif -->
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    @endforeach


    @php
        $item = App\Order::where('refunded', '0')
            ->where('user_id', Auth::User()->id)
            ->get();
    @endphp

    @if (count($item) > 0)
        <section id="learning-courses" class="learning-courses-main-block">
            <div class="container">
                <h4 class="student-heading">{{ __('My Courses') }}</h4>
                <div class="row">
                    @foreach ($enroll as $enrol)
                        @if ($enrol->course_id != null)
                            @if ($enrol->status == 1)
                                @if ($enrol->user_id == Auth::User()->id)
                                    <div class="col-lg-3 col-sm-6">

                                        <div class="view-block">
                                            <div class="view-img">
                                                @if ($enrol->courses['preview_image'] !== null && $enrol->courses['preview_image'] !== '')
                                                    <a
                                                        href="{{ route('course.content', ['id' => $enrol->courses->id, 'slug' => $enrol->courses->slug]) }}"><img
                                                            src="{{ asset('images/course/' . $enrol->courses->preview_image) }}"
                                                            class="img-fluid" alt="student">
                                                    </a>
                                                @else
                                                    <a
                                                        href="{{ route('course.content', ['id' => $enrol->courses->id, 'slug' => $enrol->courses->slug]) }}"><img
                                                            src="{{ Avatar::create($enrol->courses->title)->toBase64() }}"
                                                            class="img-fluid" alt="student"></a>
                                                @endif
                                            </div>
                                            <div class="view-dtl">
                                                <div class="view-heading"><a
                                                        href="{{ route('course.content', ['id' => $enrol->courses->id, 'slug' => $enrol->courses->slug]) }}">{{ str_limit($enrol->courses->title, $limit = 35, $end = '...') }}</a>
                                                </div>
                                                <div class="user-name">
                                                    <h6>{{ __('By') }}
                                                        <span>{{ optional($enrol->courses->user)['fname'] }}</span>
                                                    </h6>
                                                </div>
                                                <!-- <p class="btm-10"><a href="#">by @if (isset($enrol->courses->user))
    {{ $enrol->courses->user->fname }}
    @endif
        </a>
        </p> -->
                                                <div class="rating">
                                                    <ul>
                                                        <li>
                                                            <!-- star rating -->
                                                            <?php
                                                            $learn = 0;
                                                            $price = 0;
                                                            $value = 0;
                                                            $sub_total = 0;
                                                            $sub_total = 0;
                                                            $reviews = App\ReviewRating::where('course_id', $enrol->courses->id)
                                                                ->where('status', '1')
                                                                ->get();
                                                            ?>
                                                            @if (!empty($reviews[0]))
                                                                <?php
                                                                $count = App\ReviewRating::where('course_id', $enrol->courses->id)->count();
                                                                
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
                                                                    <div class="star-ratings-sprite"><span
                                                                            style="width:<?php echo $ratings_var; ?>%"
                                                                            class="star-ratings-sprite-rating"></span>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="pull-left">
                                                                    {{ __('No Rating') }}
                                                                </div>
                                                            @endif
                                                        </li>
                                                        <!-- overall rating -->
                                                        @php
                                                            $reviews = App\ReviewRating::where('course_id', $enrol->courses->id)->get();
                                                        @endphp
                                                        <?php
                                                        $learn = 0;
                                                        $price = 0;
                                                        $value = 0;
                                                        $sub_total = 0;
                                                        // $count =  count($reviews);
                                                        $count = 1;
                                                        $onlyrev = [];
                                                        
                                                        $reviewcount = App\ReviewRating::where('course_id', $enrol->courses->id)
                                                            ->where('status', '1')
                                                            ->WhereNotNull('review')
                                                            ->get();
                                                        
                                                        foreach ($reviewcount as $review) {
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
                                                            $reviewsrating = App\ReviewRating::where('course_id', $enrol->courses->id)->first();
                                                        @endphp
                                                        @if (!empty($reviewsrating))
                                                            <!-- <li>
                                            <b>{{ round($overallrating, 1) }}</b>
                                        </li> -->
                                                        @endif

                                                        <li class="reviews">
                                                            (@php
                                                                $data = App\ReviewRating::where('course_id', $enrol->courses->id)->count();
                                                                if ($data > 0) {
                                                                    echo $data;
                                                                } else {
                                                                    echo '0';
                                                                }
                                                            @endphp Reviews)
                                                        </li>
                                                    </ul>
                                                </div>


                                                <div class="mycourse-progress">

                                                    <?php
                                                    $progress = App\CourseProgress::where('course_id', $enrol->course_id)
                                                        ->where('user_id', Auth::User()->id)
                                                        ->first();
                                                    ?>
                                                    @if (!empty($progress))
                                                        <?php
                                                        
                                                        $total_class = $progress->all_chapter_id;
                                                        $total_count = count($total_class);
                                                        
                                                        $total_per = 100;
                                                        
                                                        $read_class = $progress->mark_chapter_id;
                                                        $read_count = count($read_class);
                                                        
                                                        $progres = ($read_count / $total_count) * 100;
                                                        ?>

                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-striped bg-success"
                                                                role="progressbar" style="width: <?php echo $progres; ?>%"
                                                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                        <div class="complete"><?php echo $progres; ?>% {{ __('Complete') }}
                                                        </div>
                                                    @else
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-striped bg-success"
                                                                role="progressbar" style="width: 0%" aria-valuenow="100"
                                                                aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                        <div class="complete">{{ __('Start Course') }}</div>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @else
                            @php
                                $bundle_order = App\BundleCourse::where('id', $enrol->bundle_id)->first();
                            @endphp

                            @foreach ($bundle_order->course_id as $bundle_course)
                                @php
                                    
                                    $coursess = App\Course::where('id', $bundle_course)->first();
                                    
                                @endphp

                                <div class="col-lg-3 col-sm-6">

                                    <div class="view-block">
                                        <div class="view-img">
                                            @if ($coursess['preview_image'] !== null && $coursess['preview_image'] !== '')
                                                <a
                                                    href="{{ route('course.content', ['id' => $coursess->id, 'slug' => $coursess->slug]) }}"><img
                                                        src="{{ asset('images/course/' . $coursess->preview_image) }}"
                                                        class="img-fluid" alt="student">
                                                </a>
                                            @else
                                                <a
                                                    href="{{ route('course.content', ['id' => $coursess->id, 'slug' => $coursess->slug]) }}"><img
                                                        src="{{ Avatar::create($coursess->title)->toBase64() }}"
                                                        class="img-fluid" alt="student"></a>
                                            @endif
                                        </div>
                                        <div class="view-dtl">
                                            <div class="view-heading"><a
                                                    href="{{ route('course.content', ['id' => $coursess->id, 'slug' => $coursess->slug]) }}">{{ str_limit($coursess->title, $limit = 35, $end = '...') }}</a>
                                            </div>
                                            <div class="user-name">
                                                <h6>By <span>{{ optional($coursess->user)['fname'] }}</span></h6>
                                            </div>
                                            <!-- <p class="btm-10"><a href="#">by @if (isset($coursess->user))
    {{ $coursess->user->fname }}
    @endif
        </a></p> -->
                                            <div class="rating">
                                                <ul>
                                                    <li>
                                                        <!-- star rating -->
                                                        <?php
                                                        $learn = 0;
                                                        $price = 0;
                                                        $value = 0;
                                                        $sub_total = 0;
                                                        $sub_total = 0;
                                                        $reviews = App\ReviewRating::where('course_id', $coursess->id)
                                                            ->where('status', '1')
                                                            ->get();
                                                        ?>
                                                        @if (!empty($reviews[0]))
                                                            <?php
                                                            $count = App\ReviewRating::where('course_id', $coursess->id)->count();
                                                            
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
                                                                <div class="star-ratings-sprite"><span
                                                                        style="width:<?php echo $ratings_var; ?>%"
                                                                        class="star-ratings-sprite-rating"></span>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="pull-left">
                                                                {{ __('No Rating') }}
                                                            </div>
                                                        @endif
                                                    </li>
                                                    <!-- overall rating -->
                                                    @php
                                                        $reviews = App\ReviewRating::where('course_id', $coursess->id)->get();
                                                    @endphp
                                                    <?php
                                                    $learn = 0;
                                                    $price = 0;
                                                    $value = 0;
                                                    $sub_total = 0;
                                                    $count = count($reviews);
                                                    $onlyrev = [];
                                                    
                                                    $reviewcount = App\ReviewRating::where('course_id', $coursess->id)
                                                        ->where('status', '1')
                                                        ->WhereNotNull('review')
                                                        ->get();
                                                    
                                                    foreach ($reviewcount as $review) {
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
                                                        $reviewsrating = App\ReviewRating::where('course_id', $coursess->id)->first();
                                                    @endphp
                                                    @if (!empty($reviewsrating))
                                                        <!-- <li>
                                            <b>{{ round($overallrating, 1) }}</b>
                                        </li> -->
                                                    @endif

                                                    <li class="reviews">
                                                        (@php
                                                            $data = App\ReviewRating::where('course_id', $coursess->id)->count();
                                                            if ($data > 0) {
                                                                echo $data;
                                                            } else {
                                                                echo '0';
                                                            }
                                                        @endphp Reviews)
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="mycourse-progress">

                                                <?php
                                                $progress = App\CourseProgress::where('course_id', $coursess->id)
                                                    ->where('user_id', Auth::User()->id)
                                                    ->first();
                                                ?>
                                                @if (!empty($progress))
                                                    <?php
                                                    
                                                    $total_class = $progress->all_chapter_id;
                                                    $total_count = count($total_class);
                                                    
                                                    $total_per = 100;
                                                    
                                                    $read_class = $progress->mark_chapter_id;
                                                    $read_count = count($read_class);
                                                    
                                                    $progres = ($read_count / $total_count) * 100;
                                                    ?>

                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped bg-success"
                                                            role="progressbar" style="width: <?php echo $progres; ?>%"
                                                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <div class="complete"><?php echo $progres; ?>% {{ __('Complete') }}</div>
                                                @else
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped bg-success"
                                                            role="progressbar" style="width: 0%" aria-valuenow="100"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <div class="complete">{{ __('Start Course') }}</div>
                                                @endif

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
        {{--  <section id="business-home" class="business-home-main-block">
            <div class="business-img">
                @if ($gets['img'] !== null && $gets['img'] !== '')
                    <img src="{{ url('/images/breadcum/' . $gets->img) }}" class="img-fluid" alt="" />
                @else
                    <img src="{{ Avatar::create($gets->text)->toBase64() }}" alt="course" class="img-fluid">
                @endif
            </div>
            <div class="overlay-bg"></div>
            <div class="container-fluid">
                <div class="business-dtl">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="bredcrumb-dtl">
                                <h1 class="wishlist-home-heading">{{ __('My Subscribed Courses') }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="learning-courses" class="learning-courses-main-block">
            <div class="container">
                <div class="row">
                    @php
                        $isSubscriptionCoursesFound = false;
                    @endphp
                    @foreach ($enroll as $enrol)
                        @if ($enrol->status === 1 && $enrol->subscription_status === 'active')
                            @php
                                $bundle_order = App\BundleCourse::where('id', $enrol->bundle_id)->first();
                            @endphp
                            @foreach ($bundle_order->course_id as $bundle_course)
                                @php
                                    
                                    $coursess = App\Course::where('id', $bundle_course)->first();
                                    
                                @endphp

                                <div class="col-lg-3 col-sm-6">
                                    @php
                                        $isSubscriptionCoursesFound = true;
                                    @endphp

                                    <div class="view-block">
                                        <div class="view-img">
                                            @if ($coursess['preview_image'] !== null && $coursess['preview_image'] !== '')
                                                <a href="{{ url('show/coursecontent', $coursess->id) }}"><img
                                                        src="{{ asset('images/course/' . $coursess->preview_image) }}"
                                                        class="img-fluid" alt="student">
                                                </a>
                                            @else
                                                <a href="{{ url('show/coursecontent', $coursess->id) }}"><img
                                                        src="{{ Avatar::create($coursess->title)->toBase64() }}"
                                                        class="img-fluid" alt="student"></a>
                                            @endif
                                        </div>
                                        <div class="view-dtl" style="height: 170px">
                                            <div class="view-heading btm-10"><a
                                                    href="{{ url('show/coursecontent', $coursess->id) }}">{{ str_limit($coursess->title, $limit = 35, $end = '...') }}</a>
                                            </div>
                                            <p class="btm-10"><a href="#">{{ __('by') }}
                                                    {{ $coursess->user->fname }}</a></p>
                                            <div class="rating">
                                                <ul>
                                                    <li>
                                                        <!-- star rating -->
                                                        <?php
                                                        $learn = 0;
                                                        $price = 0;
                                                        $value = 0;
                                                        $sub_total = 0;
                                                        $sub_total = 0;
                                                        $reviews = App\ReviewRating::where('course_id', $coursess->id)
                                                            ->where('status', '1')
                                                            ->get();
                                                        ?>
                                                        @if (!empty($reviews[0]))
                                                            <?php
                                                            $count = App\ReviewRating::where('course_id', $coursess->id)->count();
                                                            
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
                                                                <div class="star-ratings-sprite"><span
                                                                        style="width:<?php echo $ratings_var; ?>%"
                                                                        class="star-ratings-sprite-rating"></span>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="pull-left">
                                                                {{ __('No Rating') }}
                                                            </div>
                                                        @endif
                                                    </li>
                                                    <!-- overall rating -->
                                                    @php
                                                        $reviews = App\ReviewRating::where('course_id', $coursess->id)->get();
                                                    @endphp
                                                    <?php
                                                    $learn = 0;
                                                    $price = 0;
                                                    $value = 0;
                                                    $sub_total = 0;
                                                    $count = count($reviews);
                                                    $onlyrev = [];
                                                    
                                                    $reviewcount = App\ReviewRating::where('course_id', $coursess->id)
                                                        ->where('status', '1')
                                                        ->WhereNotNull('review')
                                                        ->get();
                                                    
                                                    foreach ($reviewcount as $review) {
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
                                                        $reviewsrating = App\ReviewRating::where('course_id', $coursess->id)->first();
                                                    @endphp
                                                    @if (!empty($reviewsrating))
                                                        <li>
                                                            <b>{{ round($overallrating, 1) }}</b>
                                                        </li>
                                                    @endif

                                                    <li>
                                                        (@php
                                                            $data = App\Order::where('course_id', $coursess->id)->get();
                                                            if (count($data) > 0) {
                                                                echo count($data);
                                                            } else {
                                                                echo '0';
                                                            }
                                                        @endphp)
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="mycourse-progress">

                                                <?php $progress = App\CourseProgress::where('course_id', $coursess->id)
                                                    ->where('user_id', Auth::User()->id)
                                                    ->first(); ?>
                                                @if (!empty($progress))
                                                    <?php
                                                    $total_class = $progress->all_chapter_id;
                                                    $total_count = count($total_class);
                                                    
                                                    $total_per = 100;
                                                    
                                                    $read_class = $progress->mark_chapter_id;
                                                    $read_count = count($read_class);
                                                    
                                                    $progres = ($read_count / $total_count) * 100;
                                                    ?>

                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped bg-success"
                                                            role="progressbar" style="width: <?php echo $progres; ?>%"
                                                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <div class="complete"><?php echo $progres; ?>% {{ __('Complete') }}</div>
                                                @else
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped bg-success"
                                                            role="progressbar" style="width: 0%" aria-valuenow="100"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <div class="complete">{{ __('Start Course') }}</div>
                                                @endif

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
        @if (!$isSubscriptionCoursesFound)
            <section id="no-result-block" class="no-result-block">
                <div class="container">
                    <div class="no-result-courses">{{ __('When Subscribe') }}&nbsp;<a
                            href="{{ url('/') }}"><b>{{ __('Browse') }}</b></a></div>
                </div>
            </section>
        @endif --}}
    @else
        <section id="no-result-block" class="no-result-block">
            <div class="container">
                <div class="no-result-courses">{{ __('when enroll') }}&nbsp;<a
                        href="{{ url('/') }}"><b>{{ __('Browse') }}</b></a></div>
            </div>
        </section> 
    @endif

@endsection
