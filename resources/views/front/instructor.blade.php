@extends('theme.master')
@section('title', "$user->fname")
@section('content')

    @include('admin.message')
    @include('sweetalert::alert')
    <!-- breadcumb start -->
    @php
        $gets = App\Breadcum::first();
    @endphp
    @if (isset($gets))
        <section id="business-home" class="business-home-main-block">
            <div class="business-img">
                @if ($gets['img'] !== null && $gets['img'] !== '')
                    <img src="{{ url('/images/breadcum/' . $gets->img) }}" class="img-fluid" width="100%" height="100px"
                        alt="" />
                @else
                    <img src="{{ Avatar::create($gets->text)->toBase64() }}" alt="course" width="100%" height="100px"
                        class="img-fluid">
                @endif
            </div>
            <div class="overlay-bg"></div>
            <div class="container-fluid">
                <div class="business-dtl">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <div class="bredcrumb-dtl">
                                <h1 class="wishlist-home-heading">{{ __('Instructor Profile') }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- breadcumb end -->
    <section id="instructor-block" class="instructor-main-block instructor-profile">
        <div class="container">
            <div class="row" style="display: flex; justify-items:center">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12 first">
                    <div class="item testimonial-block text-left">
                        <div class="testimonial-block-one">
                            <div class="row heading" style="padding:30px">
                                <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                                    <div class="testimonial-img tow">
                                        @if ($user['user_img'] !== null && $user['user_img'] !== '')
                                            <img src="{{ url('/images/user_img/' . $user->user_img) }}"
                                                class="img-fluid owl-lazy" />
                                        @else
                                            <img src="{{ Avatar::create($user->fname)->toBase64() }}"
                                                alt="{{ __('course') }}" class="img-fluid owl-lazy">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-10">
                                    <h2 class="about-content-heading">
                                        {{ $user['fname'] }} {{ $user['lname'] }}</h2>
                                </div>
                            </div>
                                <div class="row" style="padding:30px">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="row">
                                            <div class="col-lg-5" style="display: none; justify-content:start">
                                                <h2 class="about-content-heading">
                                                    {{ $user['fname'] }} {{ $user['lname'] }}</h2>
                                                <div class="instructor-btn text-left">

                                                    @auth

                                                        @php
                                                            
                                                            $follow = App\Followers::where('follower_id', $user->id)->first();
                                                            
                                                        @endphp

                                                        @if ($follow == null)
                                                            <form id="demo-form2" method="post" action="{{ route('follow') }}"
                                                                data-parsley-validate class="form-horizontal form-label-left">
                                                                {{ csrf_field() }}

                                                                <input type="hidden" name="follower_id"
                                                                    value="{{ $user->id }}" />


                                                                <button style="width: 100% !important" type="submit"
                                                                    class="btn btn-primary">&nbsp;Follow</button>
                                                            </form>
                                                        @else
                                                            <form id="demo-form2" method="post" action="{{ route('unfollow') }}"
                                                                data-parsley-validate class="form-horizontal form-label-left">
                                                                {{ csrf_field() }}

                                                                <input type="hidden"
                                                                    name="follower_id"value="{{ $user->id }}" />
                                                                <input type="hidden" name="user_id" value="{{ Auth::id() }}" />


                                                                <button type="submit" style="width: 100% !important"
                                                                    class="btn btn-secondary">&nbsp;Unfollow</button>
                                                            </form>
                                                        @endif

                                                    @endauth



                                                </div>
                                                @php
                                                    
                                                    $followers = App\Followers::where('user_id', '!=', $user->id)
                                                        ->where('follower_id', $user->id)
                                                        ->count();
                                                    
                                                    $followings = App\Followers::where('user_id', $user->id)
                                                        ->where('follower_id', '!=', $user->id)
                                                        ->count();
                                                    
                                                @endphp

                                                <div class="instructor-follower">
                                                    <div class="followers-status">
                                                        <span class="followers-value">{{ $followers }}</span>
                                                        <span class="followers-heading">Followers</span>
                                                    </div>
                                                    <div class="following-status">
                                                        <span class="followers-value">{{ $followings }}</span>
                                                        <span class="followers-heading">Following</span>
                                                    </div>
                                                </div>
                                                <div class="testimonial-rating" style="text-align: center">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= 3)
                                                            <i class='fa fa-star' style='color:orange'></i>
                                                        @else
                                                            <i class='fa fa-star' style='color:#ccc'></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <div class="instructor-business-block"
                                                    style="display: block; margin-top:0 !important">
                                                    <div class="instructor-student" style="margin-right:0 !important">
                                                        <div class="total-students">{{ __('frontstaticword.Totalstudents') }}
                                                        </div>
                                                        <div class="total-number">
                                                            @php
                                                                $data = App\Order::where('instructor_id', $user->id)->count();
                                                                if ($data > 0) {
                                                                    echo $data;
                                                                } else {
                                                                    echo '0';
                                                                }
                                                            @endphp
                                                        </div>
                                                    </div>

                                                </div>

                                                @php
                                                    $year = Carbon\Carbon::parse($user->created_at)->year;
                                                    $course_count = App\Course::where('user_id', $user->id)->count();
                                                @endphp

                                                <div class="badges">
                                                    <div class="align">
                                                        <img src="{{ url('images/badges/1.png') }}" class="img-fluid"
                                                            alt="" data-toggle="tooltip" data-placement="bottom"
                                                            title="Member Since {{ $year }}">
                                                        @if ($course_count >= 5)
                                                            <img src="{{ url('images/badges/2.png') }}" class="img-fluid"
                                                                alt="" data-toggle="tooltip" data-placement="bottom"
                                                                title="Has {{ $course_count }} courses">
                                                        @endif
                                                        <img src="{{ url('images/badges/3.png') }}" class="img-fluid"
                                                            alt="" data-toggle="tooltip" data-placement="bottom"
                                                            title="rating from 4 to 5">
                                                        <img src="{{ url('images/badges/4.png') }}" class="img-fluid"
                                                            alt="" data-toggle="tooltip" data-placement="bottom"
                                                            title=" {{ $data }} users has enrolled">
                                                        <img src="{{ url('images/badges/5.png') }}" class="img-fluid"
                                                            alt="" data-toggle="tooltip" data-placement="bottom"
                                                            title="Live classes {{ $live_class }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 my-3" style="display: grid; justify-content:start; padding:0">
                                                <div class="row">
                                                    <div class="col-lg-12 text-left">
                                                        <h5>{{ __('frontstaticword.Aboutme') }}</h5>
                                                        <b>{!! $user['detail'] !!}</b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div class="row">
								<div class="col-lg-6">
                                    <div class="tab-badges-2">
                                        <div class="row tab-badges-heading">
                                            <div class="col-lg-2">
                                                <img src="{{ url('images/badges/1.png') }}" class="img-fluid" alt=""></div>
                                            <div class="col-lg-10">Practical Experiences:</div></div>
											<p>Certified Trainnig</p>
											<p>Educational Copywriter</p>
											<p>Designing e-learning programs</p>
											<p>Writing childern's stories</p>
											<p>designing scientific research</p>
											<p>designing Educational plans</p>
                                    </div>
                                    <div class="tab-badges-2">
                                        <div class="row tab-badges-heading">
                                            <div class="col-lg-2">
                                                <img src="{{ url('images/badges/2.png') }}" class="img-fluid" alt=""></div>
                                            <div class="col-lg-10">Basic Skills:</div>
                                        </div>
                                        <p>Advanced creative writing skills</p>
                                        <p>Educational project management</p>
                                        <p>Team management</p>
                                    </div>
                                    <div class="tab-badges-2">
                                        <div class="row tab-badges-heading">
                                            <div class="col-lg-2">
                                                <img src="{{ url('images/badges/5.png') }}" class="img-fluid" alt=""></div>
                                            <div class="col-lg-10">Contact information:</div>
                                        </div>
                                        <p>Tel: +963123456789</p>
                                        <p>E-mail: admin@wlcd.com</p>
                                    </div>
								</div>
								<div class="col-lg-6">
                                    <div class="tab-badges-2">
                                        <div class="row tab-badges-heading">
                                            <div class="col-lg-2">
                                                <img src="{{ url('images/badges/3.png') }}" class="img-fluid" alt=""></div>
                                            <div class="col-lg-10">
                                                Professional Summary:
                                            </div>
                                        </div>
                                        <p>some text some text some text some text some text some text some text some text some text some text some text some text</p>
                                    </div>
                                    <div class="tab-badges-2">
                                        <div class="row tab-badges-heading">
                                            <div class="col-lg-2">
                                                <img src="{{ url('images/badges/4.png') }}" class="img-fluid" alt=""></div>
                                            <div class="col-lg-10">Scientific Background:</div>
                                        </div>
                                        <p>Ph.D Educational management</p>
                                    </div>
                                    <div class="tab-badges-2">
                                        <div class="row tab-badges-heading">
                                            <div class="col-lg-2">
                                                <img src="{{ url('images/badges/2.png') }}" class="img-fluid" alt=""></div>
                                            <div class="col-lg-10">Courses:</div>
                                        </div>
                                        <p>Courses in content writing and Copywriting</p>
                                        <p>Courses in the field of humanities</p>
                                    </div>
								</div>
							</div>
                            {{-- <p>{{ str_limit(preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode('detailsdeta'))), $limit = 300, $end = '...') }}
						</p> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="padding:20px 0 10px">
                <h3>badges</h3>
            </div>
            <div class="row" style="display: flex; justify-content:space-between; padding:20px 0 10px">
                <div class="col-lg-2 col-md-2 col-sm-12 col-xl-2" style="padding: 0">
                    <div class="tab-badges text-center">
                        <img src="{{ url('images/badges/1.png') }}" class="img-fluid" alt="">
                        <div class="tab-badges-heading">Trusted User</div>
                        <p>Member since {{ $year }}</p>
                    </div>
                </div>
                @if ($course_count >= 5)
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xl-2" style="padding: 0">
                        <div class="tab-badges text-center">
                            <img src="{{ url('images/badges/2.png') }}" class="img-fluid" alt="">
                            <div class="tab-badges-heading">Senior Instructor</div>
                            <p>Has {{ $course_count }} Courses</p>
                        </div>
                    </div>
                @endif
                <div class="col-lg-2 col-md-2 col-sm-12 col-xl-2" style="padding: 0">
                    <div class="tab-badges text-center">
                        <img src="{{ url('images/badges/3.png') }}" class="img-fluid" alt="">
                        <div class="tab-badges-heading">Golden Courses</div>
                        <p>Courses Rating from 4 to 5</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xl-2" style="padding: 0">
                    <div class="tab-badges text-center">
                        <img src="{{ url('images/badges/4.png') }}" class="img-fluid" alt="">
                        <div class="tab-badges-heading">Best Seller</div>
                        <p>{{ $data }} Courses Sales</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xl-2" style="padding: 0">
                    <div class="tab-badges text-center">
                        <img src="{{ url('images/badges/5.png') }}" class="img-fluid" alt="">
                        <div class="tab-badges-heading">Active Classes </div>
                        <p>Live classes {{ $live_class }}</p>
                    </div>
                </div>
            </div>
            <div class="row" style="padding:20px 0 10px">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
                    <div class="about-instructor">
                        <div class="row">
                            <h3 class="more-courses-heading">{{ __('frontstaticword.MyCourses') }}</h3>
                            <div id="instructor-related-course"
                                class="student-view-slider-main-block owl-carousel owl-theme">
                                @foreach ($course as $c)
                                    @if ($c->status == 1)
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="student-view-block">
                                                <div class="view-block">
                                                    <div class="view-img">
                                                        @if ($c['preview_image'] !== null && $c['preview_image'] !== '')
                                                            <a
                                                                href="{{ route('user.course.show', ['id' => $c->id, 'slug' => $c->slug]) }}"><img
                                                                    src="{{ asset('images/course/' . $c['preview_image']) }}"
                                                                    alt="{{ __('course') }}" class="img-fluid"></a>
                                                        @else
                                                            <a
                                                                href="{{ route('user.course.show', ['id' => $c->id, 'slug' => $c->slug]) }}"><img
                                                                    src="{{ Avatar::create($c->title)->toBase64() }}"
                                                                    alt="{{ __('course') }}" class="img-fluid"></a>
                                                        @endif
                                                    </div>
                                                    <div class="view-user-img">

                                                        @if (optional($c->user)['user_img'] !== null && optional($c->user)['user_img'] !== '')
                                                            <a href="" title=""><img
                                                                    src="{{ asset('images/user_img/' . $c->user['user_img']) }}"
                                                                    class="img-fluid user-img-one"
                                                                    style="bottom: 45% !important; position: absolute !important; alt=""></a>
                                                        @else
                                                            <a href="" title=""><img
                                                                    src="{{ asset('images/default/user.png') }}"
                                                                    class="img-fluid user-img-one"
                                                                    style="bottom: 45% !important; position: absolute !important; alt=""></a>
                                                        @endif


                                                    </div>
                                                    <div class="view-dtl">
                                                        <div class="view-heading"><a
                                                                href="{{ route('user.course.show', ['id' => $c->id, 'slug' => $c->slug]) }}">{{ str_limit($c->title, $limit = 30, $end = '...') }}</a>
                                                        </div>
                                                        <div class="user-name">
                                                            <h6>By
                                                                <span>{{ optional($c->user)['fname'] }}</span>
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
                                                                    $reviews = App\ReviewRating::where('course_id', $c->id)->get();
                                                                    ?>
                                                                    @if (!empty($reviews[0]))
                                                                        <?php
                                                                        $count = App\ReviewRating::where('course_id', $c->id)->count();
                                                                        
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
                                                                                <span style="width:<?php echo $ratings_var; ?>%"
                                                                                    class="star-ratings-sprite-rating"></span>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div class="pull-left">
                                                                            {{ __('No Rating') }}</div>
                                                                    @endif
                                                                </li>
                                                                <!-- overall rating-->
                                                                <?php
                                                                $learn = 0;
                                                                $price = 0;
                                                                $value = 0;
                                                                $sub_total = 0;
                                                                $count = count($reviews);
                                                                $onlyrev = [];
                                                                
                                                                $reviewcount = App\ReviewRating::where('course_id', $c->id)
                                                                    ->WhereNotNull('review')
                                                                    ->get();
                                                                
                                                                foreach ($reviews as $review) {
                                                                    $learn = $review->learn * 5;
                                                                    $price = $review->price * 5;
                                                                    $value = $review->value * 5;
                                                                    $sub_total = $sub_total + $learn + $price + $value;
                                                                }
                                                                
                                                                $count = $count * 3 * 5;
                                                                
                                                                if ('') {
                                                                    $rat = $sub_total / $count;
                                                                
                                                                    $ratings_var = ($rat * 100) / 5;
                                                                
                                                                    $overallrating = $ratings_var / 2 / 10;
                                                                }
                                                                
                                                                ?>

                                                                @php
                                                                    $reviewsrating = App\ReviewRating::where('course_id', $c->id)->first();
                                                                @endphp
                                                                <li class="reviews">
                                                                    (@php
                                                                        $data = App\ReviewRating::where('course_id', $c->id)->count();
                                                                        if ($data > 0) {
                                                                            echo $data;
                                                                        } else {
                                                                            echo '0';
                                                                        }
                                                                    @endphp Reviews)
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="view-footer" style="height: 65px">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                                                    <div class="count-user">
                                                                        <i data-feather="user"></i><span>1</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                                                    @if ($c->type == 1)
                                                                        <div class="rate text-right">
                                                                            <ul>
                                                                                @php
                                                                                    $currency = App\Currency::first();
                                                                                @endphp

                                                                                @if ($c->discount_price == !null)
                                                                                    <li><a><b><i
                                                                                                    class="{{ $currency->icon }}"></i>{{ $c->discount_price }}</b></a>
                                                                                    </li>&nbsp;
                                                                                    <li><a><b><strike><i
                                                                                                        class="{{ $currency->icon }}"></i>{{ $c->price }}</strike></b></a>
                                                                                    </li>
                                                                                @else
                                                                                    <li><a><b><i
                                                                                                    class="{{ $currency->icon }}"></i>{{ $c->price }}</b></a>
                                                                                    </li>
                                                                                @endif
                                                                            </ul>
                                                                        </div>
                                                                    @else
                                                                        <div class="rate text-right">
                                                                            <ul>
                                                                                <li><a><b>{{ __('Free') }}</b></a>
                                                                                </li>
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
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div>{{ $course->links() }}</div>
                </div>
            </div>
        </div>
    </section>
@endsection

<style>
    .testimonial-block .tow .owl-lazy {
        width: 110px;
        height: 110px;
        border-radius: 100%;
        /* margin-right: 20px; */
        object-fit: cover;
        margin: 0 auto;
        /* position: absolute; */
        /* top: -70px; */
    }

    .testimonial-block:hover {
        border: 2px solid #54b435;
        border-radius: 6px;
        transform: translateY(0px) !important;
        transition: all .5s ease;
    }

    .badges img {
        width: 30px;
        height: 30px;
        border-radius: 100%;
        object-fit: cover;
        margin: 0 auto;
    }

    .tab-badges {
        text-align: center;
        background-color: #FFF;
        box-shadow: 5px 5px 10px rgb(0 0 0 / 10%);
        border: 2px solid transparent;
        border-radius: 6px;
        margin-bottom: 20px;
        padding: 40px 0;
        -webkit-transition: all 0.5s ease;
        -ms-transition: all 0.5s ease;
        -o-transition: all 0.5s ease;
        -moz-transition: all 0.5s ease;
        transition: all 0.5s ease;
    }

    .tab-badges:hover {
        border: 2px solid #54b435;
        border-radius: 6px;
        transform: translateY(-25px);
        transition: all .5s ease;
    }

    .tab-badges img {
        width: 50px;
        height: 50px;
        margin-bottom: 20px;
    }

    .tab-badges p {
        font-size: 12px !important;
        font-weight: 400;
        color: #73726C;
    }
	.moto-widget {
    background-image: url('images/joininstructor/download_app.png');
    background-position: center;
    background-repeat: no-repeat;
}

.container-fluid,
.moto-cell,
.moto-cell.moto-spacing-left-auto {
    padding-left: 15px;
}

.container-fluid,
.moto-cell,
.moto-cell.moto-spacing-right-auto {
    padding-right: 15px;
}

.row {
    margin-left: -15px;
    margin-right: -15px;
}

.moto-container_width-fixed,
.row-fixed .container-fluid {
    max-width: 1200px;
}

.moto-spacing-top-auto {
    padding-top: initial;
}

.moto-spacing-top-zero {
    padding-top: 0;
}

.moto-spacing-top-small {
    padding-top: 25px;
}

.moto-spacing-top-medium {
    padding-top: 100px;
}

.moto-spacing-top-large {
    padding-top: 100px;
}

.moto-spacing-bottom-auto {
    padding-bottom: initial;
}

.moto-spacing-bottom-zero {
    padding-bottom: 0;
}

.moto-spacing-bottom-small {
    padding-bottom: 25px;
}

.moto-spacing-bottom-medium {
    padding-bottom: 60px;
}

.moto-spacing-bottom-large {
    padding-bottom: 100px;
}

.moto-spacing-left-auto {
    padding-left: initial;
}

.moto-spacing-left-zero {
    padding-left: 0;
}

.moto-spacing-left-small {
    padding-left: 25px;
}

.moto-spacing-left-medium {
    padding-left: 60px;
}

.moto-spacing-left-large {
    padding-left: 100px;
}

.moto-spacing-right-auto {
    padding-right: initial;
}

.moto-spacing-right-zero {
    padding-right: 0;
}

.moto-spacing-right-small {
    padding-right: 25px;
}

.moto-spacing-right-medium {
    padding-right: 60px;
}

.moto-spacing-right-large {
    padding-right: 100px;
}

@media (max-width: 1039px) {
    .moto-spacing-top-small {
        padding-top: 20px;
    }

    .moto-spacing-top-medium {
        padding-top: 30px;
    }

    .moto-spacing-top-large {
        padding-top: 35px;
    }

    .moto-spacing-bottom-small {
        padding-bottom: 20px;
    }

    .moto-spacing-bottom-medium {
        padding-bottom: 30px;
    }

    .moto-spacing-bottom-large {
        padding-bottom: 35px;
    }

    .moto-spacing-left-small {
        padding-left: 20px;
    }

    .moto-spacing-left-medium {
        padding-left: 30px;
    }

    .moto-spacing-left-large {
        padding-left: 35px;
    }

    .moto-spacing-right-small {
        padding-right: 20px;
    }

    .moto-spacing-right-medium {
        padding-right: 30px;
    }

    .moto-spacing-right-large {
        padding-right: 35px;
    }
}

@media (max-width: 767px) {
    .moto-spacing-top-small {
        padding-top: 20px;
    }

    .moto-spacing-top-medium {
        padding-top: 30px;
    }

    .moto-spacing-top-large {
        padding-top: 50px;
    }

    .moto-spacing-bottom-small {
        padding-bottom: 20px;
    }

    .moto-spacing-bottom-medium {
        padding-bottom: 30px;
    }

    .moto-spacing-bottom-large {
        padding-bottom: 50px;
    }

    .moto-spacing-left-small {
        padding-left: 20px;
    }

    .moto-spacing-left-medium {
        padding-left: 30px;
    }

    .moto-spacing-left-large {
        padding-left: 50px;
    }

    .moto-spacing-right-small {
        padding-right: 20px;
    }

    .moto-spacing-right-medium {
        padding-right: 30px;
    }

    .moto-spacing-right-large {
        padding-right: 50px;
    }
}

@media (max-width: 768px) {
    .protip-container {
        display: none !important;
    }

    #prime-next-item-description-block {
        display: none !important;
    }

    .prime-description-under-block {
        display: none !important;
    }
}

@media (max-width: 479px) {
    .moto-spacing-top-small {
        padding-top: 15px;
    }

    .moto-spacing-top-medium {
        padding-top: 30px;
    }

    .moto-spacing-top-large {
        padding-top: 50px;
    }

    .moto-spacing-bottom-small {
        padding-bottom: 15px;
    }

    .moto-spacing-bottom-medium {
        padding-bottom: 30px;
    }

    .moto-spacing-bottom-large {
        padding-bottom: 50px;
    }

    .moto-spacing-left-small {
        padding-left: 15px;
    }

    .moto-spacing-left-medium {
        padding-left: 30px;
    }

    .moto-spacing-left-large {
        padding-left: 50px;
    }

    .moto-spacing-right-small {
        padding-right: 15px;
    }

    .moto-spacing-right-medium {
        padding-right: 30px;
    }

    .moto-spacing-right-large {
        padding-right: 50px;
    }
}

.moto-widget-text-content {
    padding: 0 1px;
}

.moto-text_system_13 {
    font-weight: 700;
    font-style: normal;

    color: #ffffff;
    font-size: 66px;
    line-height: 1;
    letter-spacing: -2px;
}

.moto-color1_3 {
    color: #ffffff;
}

.moto-text_system_12 {
    font-weight: 500;
    font-style: normal;

    color: #333333;
    font-size: 30px;
    line-height: 1.4;
    letter-spacing: 0px;
}

.moto-color5_5 {
    color: #ffffff;
}

.moto-text_normal {
    font-weight: 300;
    font-style: normal;

    color: #333333;
    font-size: 20px;
    line-height: 1.5;
    letter-spacing: 0px;
}

.dez-separator {
    display: inline-block;
    height: 3px;
    width: 60px;
    margin-bottom: 10px;
    position: relative;
	background-color: #54b435;
    /*-moz-transition: all 0.5s;*/
    /*-webkit-transition: all 0.5s;*/
    /*transition: all 0.5s;*/
}

/* . {
    background-color: #ffffff !important;
} */

.animate1,
.animate2,
.animate3 {
    position: relative;
    top: 0;
    -moz-transition: all 0.5s;
    -webkit-transition: all 0.5s;
    transition: all 0.5s;
}

.FadeRight:hover .animate1 {
    top: -10px;
    -moz-transition: all 0.5s;
    -webkit-transition: all 0.5s;
    transition: all 0.5s;
    color: #ffde20;
}

.FadeDown:hover .animate2 {
    top: -10px;
    -moz-transition: all 0.5s;
    -webkit-transition: all 0.5s;
    transition: all 0.5s;
    color: #ffde20;
}

.FadeLeft:hover .animate3 {
    top: -10px;
    -moz-transition: all 0.5s;
    -webkit-transition: all 0.5s;
    transition: all 0.5s;
    color: #ffde20;
}
ul{
	margin: 0;
    padding: 0;
    border: 0;
    list-style-type: circle;
    display: block;
    position: relative;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

ul li {
	margin: 0;
    padding: 0;
    border: 0;
    list-style-type: circle;
    display: block;
    position: relative;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
.testimonial-block-one .tab-badges{
    padding: 20px;
}
.tab-badges-2{
    text-align: left;
    background-color: #FFF;
    box-shadow: 5px 5px 10px rgb(0 0 0 / 10%);
    border: 2px solid transparent;
    border-radius: 6px;
    margin-bottom: 20px;
    padding: 40px 20px;
}
.tab-badges-2 img {
    width: 50px;
    height: 50px;
    /* margin-bottom: 20px; */
}
.tab-badges-2 .tab-badges-heading {
    display: flex;
    align-items: center;
}
.heading{
    
    display: flex;
    align-items: center;
}
.first .testimonial-block{
    background-color: #FFF;
    box-shadow: 0px 0px 5px 5px rgb(0 0 0 / 10%) !important;
    border: 2px solid transparent;
    border-radius: 6px;
    margin-top: 70px;
    margin-bottom: 20px;
    margin-left: 20px;
    margin-right: 20px;
    -webkit-transition: all 0.5s ease;
    -ms-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    transition: all 0.5s ease;
}
.testimonial-bloc-2 {
    background-color: var(--background-white-bg-color);
    box-shadow: 0 0 1px 1px rgba(20,23,28,.1),;
}
.testimonial-block-2 p {
  font-size: 12px;
  margin-bottom: 5px;
  text-align: left;
  color: var(--text-dark-grey-color);
}
.testimonial-block-2 {
    padding: 30px 20px;
  }
</style>
