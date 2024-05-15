@extends('theme.master')
@section('title')
@section('content')
    @include('admin.message')
    <!-- breadcumb start -->
    @php
        $gets = App\Breadcum::first();
    @endphp
    @if (isset($gets))
        <section id="business-home" class="business-home-main-block" style="width: 100% !important; height:100px !important;" >
            <div class="business-img">
                @if ($gets['img'] !== null && $gets['img'] !== '')
                    <img src="{{ url('/images/breadcum/' . $gets->img) }}" class="img-fluid" alt="" style="width: 100% !important; height:100px !important;"/>
                @else
                    <img src="{{ Avatar::create($gets->text)->toBase64() }}" alt="{{ __('course') }}" class="img-fluid">
                @endif
            </div>
            <div class="overlay-bg"></div>
            <div class="container-fluid">
                <div class="business-dtl">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="bredcrumb-dtl text-center">
                                <h1 class="wishlist-home-heading">{{ __('Instructors') }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- breadcumb end -->
    <!-- instructor start -->
    @if (isset($instructors))
        <section id="instructor-home" class="instructor-home-main-block instructor-page">
            <div class="container">
                <div class="row">
                    @foreach ($instructors as $inst)
                        <div class="col-lg-3 col-md-6">
                            <div class="instructor-home-block text-center">
                                <div class="instructor-home-block-one">
                                    @if ($inst['user_img'] !== null && $inst['user_img'] !== '')
                                        <a href="#" title=""><img
                                                src="{{ url('/images/user_img/' . $inst->user_img) }}"
                                                class="img-fluid" /></a>
                                    @else
                                        <a href="#" title=""><img
                                                src="{{ Avatar::create($inst->fname)->toBase64() }}" alt="course"
                                                class="img-fluid"></a>
                                    @endif
                                    <div class="tooltip">
                                        {{-- <div class="tooltip-icon">
                                <i data-feather="share-2"></i>
                            </div> --}}
                                        <span class="tooltiptext">
                                            <div class="instructor-home-social-icon">
                                                <ul>
                                                    <li><a href="{{ $inst->fb_url }}"><i data-feather="facebook"></i></a>
                                                    </li>
                                                    <li><a href="{{ $inst->twitter_url }}"><i
                                                                data-feather="twitter"></i></a></li>
                                                    <li><a href="{{ $inst->youtube_url }}"></a><i
                                                            data-feather="youtube"></i></a></li>
                                                    <li><a href="{{ $inst->linkedin_url }}"><i
                                                                data-feather="linkedin"></i></a></li>
                                                </ul>
                                            </div>
                                        </span>
                                    </div>
                                    <div class="instructor-home-dtl">
                                        <h4 class="instructor-home-heading"><a href="#"
                                                title="">{{ $inst->fname }} {{ $inst->lname }}</a></h4>
                                        <p>{{ $inst->role }}</p>

                                        @php
                                            
                                            $followers = App\Followers::where('user_id', '!=', $inst->id)
                                                ->where('follower_id', $inst->id)
                                                ->count();
                                            
                                            $followings = App\Followers::where('user_id', $inst->id)
                                                ->where('follower_id', '!=', $inst->id)
                                                ->count();
                                            $course = App\Course::where('user_id', $inst->id)->count();
                                            
                                        @endphp
                                        <div class="instructor-home-info">
                                            <ul>
                                                <li>{{ $course }} {{ __('Courses') }}</li>
                                                <li>{{ $followers }} {{ __('Follower') }}</li>
                                                <li>{{ $followings }} {{ __('Following') }}</li>
                                            </ul>
                                        </div>
                                        <hr>
                                        <div class="instructor-home-btn">
                                            @php
                                            $fullnameIns = optional($inst)->fname . ' ' . optional($inst)->lname;
                                            $fullnameIns = preg_replace('/\s+/', '', $fullnameIns);
                                            @endphp
                                
                                            <a href="{{ route('instructor.profile', ['id' => $inst->id, 'name' => $fullnameIns]) }}"
                                                class="btn btn-primary" title="View Profile"><i
                                                    data-feather="eye"></i>View Profile</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!-- instructor end -->
@endsection
