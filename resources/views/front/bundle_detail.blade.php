@extends('theme.master')
@section('title', "$bundle->title")
@section('content')

@section('meta_tags')

@php
    $url =  URL::current();
@endphp

<meta name="title" content="{{ $bundle['title'] }}">
<meta name="description" content="{{ $bundle['short_detail'] }} ">
<meta name="author" content="elsecolor">
<meta property="og:title" content="{{ $bundle['title'] }} ">
<meta property="og:url" content="{{ $url }}">
<meta property="og:description" content="{{ $bundle['short_detail'] }}">
<meta property="og:image" content="{{ asset('images/bundle/'.$bundle['preview_image']) }}">
<meta itemprop="image" content="{{ asset('images/bundle/'.$bundle['preview_image']) }}">
<meta property="og:type" content="website">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:image" content="{{ asset('images/bundle/'.$bundle['preview_image']) }}">
<meta property="twitter:title" content="{{ $bundle['title'] }} ">
<meta property="twitter:description" content="{{ $bundle['short_detail'] }}">
<meta name="twitter:site" content="{{ url()->full() }}" />
<link rel="canonical" href="{{ url()->full() }}"/>
<meta name="robots" content="all">
<meta name="keywords" content="{{ $gsetting->meta_data_keyword }}">
    
@endsection

@include('admin.message')
<!-- course detail header start -->
<section id="about-home" class="about-home-main-block">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <div class="about-home-block text-white">
                    <h1 class="about-home-heading text-white">{{ $bundle['title'] }}</h1>
                    <p>{{ $bundle['short_detail'] }}</p>
                    <ul>

                        <ul>
                            <li><a href="#" title="about">{{ __('Created') }}:
                                    {{ $bundle->user['fname'] }} </a></li>
                            <li><a href="#" title="about">{{ __('Last Updated') }}:
                                    {{ date('jS F Y', strtotime($bundle['updated_at'])) }}</a></li>

                        </ul>
                </div>
            </div>
            <!-- course preview -->
            <div class="col-lg-4 col-md-4">


                <div class="about-home-product">
                    <div class="video-item hidden-xs">

                        <div class="video-device">
                            @if ($bundle['preview_image'] !== null && $bundle['preview_image'] !== '')
                                <img src="{{ asset('images/bundle/' . $bundle['preview_image']) }}"
                                    class="bg_img img-fluid" alt="Background">
                            @else
                                <img src="{{ Avatar::create($bundle->title)->toBase64() }}" class="bg_img img-fluid"
                                    alt="Background">
                            @endif

                        </div>
                    </div>


                    <div class="about-home-dtl-training">
                        <div class="about-home-dtl-block btm-10">
                            @if ($bundle->type == 1)
                                @if ($bundle->is_subscription_enabled == 1)
                                    <div class="about-home-rate">
                                        <ul>
                                            
                                            @if($bundle->discount_price == !null)
                                                
                                                <li>{{ currency($bundle->discount_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}/{{ $bundle->billing_interval }}</li>

                                                <li><span><s>{{ currency($bundle->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}{{ $bundle->billing_interval }}</s></span></li>
                                                
                                            @else
                                                
                                                <li>{{ currency($bundle->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}/{{ $bundle->billing_interval }}</li>
                                                
                                            @endif

                                        </ul>
                                    </div>
                                @else
                                    <div class="about-home-rate">
                                        <ul>
                                           
                                            @if ($bundle->discount_price == !null)
                                                
                                                <li>{{ currency($bundle->discount_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}/{{ $bundle->billing_interval }}</li>

                                                <li><span><s>{{ currency($bundle->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}{{ $bundle->billing_interval }}</s></span></li>
                                               
                                            @else
                                                
                                                <li>{{ currency($bundle->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}/{{ $bundle->billing_interval }}</li>
                                               
                                            @endif

                                        </ul>
                                    </div>
                                @endif
                                @if (Auth::check())
                                    @if (Auth::User()->role == 'admin')
                                        <div class="about-home-btn btm-20">
                                            <a href="" class="btn btn-secondary"
                                                title="course">{{ __('Purchased') }}</a>
                                        </div>
                                    @else


                                        @php
                                        $order = App\Order::where('user_id', Auth::User()->id)->where('bundle_id',
                                        $bundle->id)->first();
                                        @endphp



                                        @if (!empty($order) && $order->status == 1)

                                            <div class="about-home-btn btm-20">
                                                <a href="" class="btn btn-secondary"
                                                    title="course">{{ __('Purchased') }}</a>
                                            </div>

                                        @else
                                            @php
                                            $cart = App\Cart::where('user_id', Auth::User()->id)->where('bundle_id',
                                            $bundle->id)->first();
                                            @endphp
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
                                                        action="{{ route('bundlecart', $bundle->id) }}"
                                                        data-parsley-validate class="form-horizontal form-label-left">
                                                        {{ csrf_field() }}

                                                        <div class="box-footer">
                                                            @if ($bundle->is_subscription_enabled == 1)
                                                                <button type="submit" class="btn btn-primary"><i
                                                                        class="fa fa-cart-plus"
                                                                        aria-hidden="true"></i>&nbsp;{{ __('Subscribe Now') }}</button>
                                                            @else
                                                                <button type="submit" class="btn btn-primary"><i
                                                                        class="fa fa-cart-plus"
                                                                        aria-hidden="true"></i>&nbsp;{{ __('Add To Cart') }}</button>
                                                            @endif
                                                        </div>
                                                    </form>
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                @else
                                    <div class="about-home-btn btm-20">
                                        @if ($bundle->is_subscription_enabled == 1)
                                            <a href="{{ route('login') }}" class="btn btn-primary"><i
                                                    class="fa fa-cart-plus"
                                                    aria-hidden="true"></i>&nbsp;{{ __('Subscribe Now') }}</a>
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
                                            <a href="" class="btn btn-secondary"
                                                title="course">{{ __('Purchased') }}</a>
                                        </div>
                                    @else
                                        @php
                                        $enroll = App\Order::where('user_id', Auth::User()->id)->where('bundle_id',
                                        $bundle->id)->first();
                                        @endphp
                                        @if ($enroll == null)
                                            <div class="about-home-btn btm-20">
                                                <a href="{{ url('bundle/enroll', $bundle->id) }}"
                                                    class="btn btn-primary"
                                                    title="Enroll Now">{{ __('Enroll Now') }}</a>
                                            </div>
                                        @else
                                            <div class="about-home-btn btm-20">
                                                <a href="" class="btn btn-secondary"
                                                    title="Cart">{{ __('Purchased') }}</a>
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

                            <hr>


                            <div class="row">
                                <div class="col-md-6 col-6">
                                    <div class="about-home-share text-center">
                                        <a href="https://calendar.google.com/calendar/r/eventedit?text={{ $bundle['title'] }}" target="__blank"><i data-feather="calendar"></i></a>
                                    </div>
                                </div>
                                <div class="col-md-6 col-6">
                                    <div class="about-home-share text-center">
                                        <a href="#" data-toggle="modal" data-target="#myModalshare" title="share" data-dismiss="modal"><i data-feather="share"></i></a>
                                    </div>
                                </div>
                            </div>

                            <!--Model start-->
                            <div class="modal fade" data-backdrop="" style="z-index: 1050;" id="myModalshare" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog modal-lg" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">

                                      <h4 class="modal-title" id="myModalLabel">{{ __('Share this course') }}</h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="box box-primary">
                                      <div class="panel panel-sum">
                                        <div class="modal-body">

                                            @php
                                            $url=  URL::current();
                                            @endphp

                                            <!-- The text field -->

                                            <div class="nav-search">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="myInput"  value="{{ $url }}">
                                                </div>
                                                <button onclick="myFunction()" class="btn btn-primary">{{ __('CopyText') }}</button>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- course header end -->
<!-- course detail start -->
<section id="about-product" class="about-product-main-block">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <div class="requirements">
                    <h3>{{ __('Detail') }}</h3>
                    <ul>
                        <li class="comment more">

                            {!! $bundle->detail !!}

                        </li>

                    </ul>
                </div>

                <div class="course-content-block btm-30">
                    <h3>{{ __('Courses In Bundle') }}</h3>
                    <!-- FSMS -->

                    <div class="row" style="padding-bottom:10px">
                        <div class="col-lg-8 col-6">
                            @php
                            // FSMS
                            function convertToHoursMins($time, $format = '%02d:%02d') {
                                if ($time < 1) {
                                    return;
                                }
                                $hours =floor($time / 60);
                                $minutes = ($time % 60);

                                return sprintf($format, $hours, $minutes);
                            }

                            $courseCount = count( $bundle['course_id'] )

                            // FSMS
                        @endphp

                        <small> &nbsp; {{ $courseCount . " courses" }}</small>
                        </div>
                        <div class="col-lg-4 col-6">
                            <button type="button" onclick="toggleAllSections()" class="btn btn-link courseToggle float-right"><span
                                    style="color:#0384a3">Expand all courses</span></button>
                            <button type="button" onclick="toggleAllSections()" class="btn btn-link courseToggle float-right"
                                style="display:none"><span style="color:#0384a3">Collapse all
                                        courses</span></button>
                        </div>
                    </div>


                    <!-- FSMS -->

                    <div class="faq-block">
                        <div class="faq-dtl">
                            <div id="accordion" class="second-accordion">
                                @foreach ($bundle->course_id as $bundles)

                                    @php
                                    $course = App\Course::where('id', $bundles)->first();
                                    @endphp

                                    <div class="card">
                                        <div class="card-header" id="headingTwo{{ $course->id }}">
                                            <div class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse"
                                                    data-target="#collapseTwo{{ $course->id }}" aria-expanded="false"
                                                    aria-controls="collapseTwo">

                                                    <div class="row">
                                                        <div class="col-lg-8 col-12">
                                                            <a
                                                                href="{{ route('user.course.show', ['id' => $course->id, 'slug' => $course->slug]) }}">{{ $course->title }}</a>
                                                        </div>

                                                    </div>

                                                </button>
                                            </div>

                                        </div>

                                        <div id="collapseTwo{{ $course->id }}" class="collapse"
                                            aria-labelledby="headingTwo" data-parent="#accordion">

                                            <div class="card-body">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td class="class-icon">
                                                                {{ $course->short_detail }}
                                                            </td>
                                                        </tr>
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
            </div>
        </div>
    </div>
</section>


<!-- course detail end -->
@endsection


@section('custom-script')
    <script>
        // FSMS
        function toggleAllSections() {
            $("div[id*='collapseTwo']").collapse('toggle');
            $(".courseToggle").toggle();
        }
        // FSMS

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
@endsection