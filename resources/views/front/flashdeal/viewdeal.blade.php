@extends('theme.master')
@section('title', 'All deals')
@section('content')

@include('admin.message')
@include('sweetalert::alert')

@section('meta_tags')

<link rel="canonical" href="{{ url()->full() }}" />
<meta name="robots" content="all">
<meta property="og:title" content="{{ __("All deals") }}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ url()->full() }}" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="{{ url()->full() }}" />
@endsection
@php
$gets = App\Breadcum::first();
@endphp
@if(isset($gets))
<section id="business-home" class="business-home-main-block">
    <div class="business-img">
        @if($gets['img'] !== NULL && $gets['img'] !== '')
        <img src="{{ url('/images/breadcum/'.$gets->img) }}" class="img-fluid" alt="" />
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
                        <h1 class="wishlist-home-heading text-white">{{ __('Home') }} / <a href="{{ route('flash.deals') }}">{{ __('Flash deals') }}</a> / <a href="{{ url()->full() }}">{{ $deal->title }}</a></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif



<section id="flash-home" class="flash-home-main-block">
<div class="container-fluid">
    <div class="test" style="background-image: url('{{ url('images/flashdeals/'.$deal->background_image) }}');">


        @php
            $mytime = Carbon\Carbon::now();
        @endphp

        @if($mytime <= $deal->end_date)

            <div class="overlay-bg"></div>
            <div class="bg_image_deal">

            

                <div class="countdown-deal">
                    <p class="text-center text-white">{{__("Sale ends in ")}}</p>
                    <div id="countdown">
                        <ul>
                            <li class="text-shadow"><span class="text-white" id="days"></span><span class="text-white text-20">days</span></li>
                            <li class="text-shadow"><span class="text-white" id="hours"></span><span class="text-white text-20"> hours</span></li>
                            <li class="text-shadow"><span class="text-white" id="minutes"></span><span class="text-white text-20"> minutes</span></li>
                            <li class="text-shadow"><span class="text-white" id="seconds"></span><span class="text-white text-20">seconds</span></li>
                        </ul>
                    </div>
                </div>


                <div>
                    {!! $deal->detail !!}
                </div>
                <div class="row p-3">
                    @forelse($deal->saleitems as $item)
                    <div class="mt-2 col-xl-3 col-lg-4 col-md-6">
                        <div class="h-100 card">
                            @if(isset($item->courses))
                                
                                <center>
                                    @if(isset($item->courses->preview_image))
                                    <a href="{{ route('user.course.show',['id' => $item->courses->id, 'slug' => $item->courses->slug ]) }}">

                                        <img src="{{ asset('images/course/'.$item->courses['preview_image']) }}" class="img-fluid owl-lazy" alt="...">
                                    </a>
                                    @else
                                    <a href="{{ route('user.course.show',['id' => $item->courses->id, 'slug' => $item->courses->slug ]) }}">

                                        <img src="{{ Avatar::create($item->courses->title)->toBase64() }}" class="img-fluid owl-lazy" alt="..." style="width: 100%">
                                    </a>

                                    @endif
                                </center>
                                <div class="card-body">
                                   
                                        <div class="card-title">
                                            <a class="text-dark" href="{{ route('user.course.show',['id' => $item->courses->id, 'slug' => $item->courses->slug ]) }}">
                                                {{$item->courses->title}}
                                            </a>
                                        </div>

                                        
                                        <p class="details">
                                            {{ substr(strip_tags($item->courses->detail), 0, 100)}}{{strlen(strip_tags($item->courses->detail))>100 ? '...' : ""}}
                                        </p>

                                        <h5>Discount : {{ $item->discount }}% ({{ $item->discount_type }})</h5>
                                        <hr>
                                        @php

                                            $mainprice = 0;

                                          

                                            if($item->courses->discount_price != '0'){
                                                
                                            
                                                echo sprintf("%.2f",$item->courses->discount_price);

                                            }else{
                                                
                                              
                                                echo sprintf("%.2f",$item->courses->price);

                                            }

                                            $sellprice = $item->courses->discount_price != 0 ? $item->courses->discount_price : $item->courses->price;

                                            $discount = $item->discount;

                                            $discount_type = $item->discount_type;

                                            $discounted_amount = 0;

                                            if($discount_type == 'upto'){

                                                $random_no = rand(0,$discount);
                                                
                                                $discounted_amount = $sellprice * $random_no / 100;

                                            }else{

                                                $discounted_amount = $sellprice * $discount / 100;

                                            }

                                            $deal_price = $sellprice - $discounted_amount;

                                        @endphp
                                        
                                        <div class="card-body">
                                            <form action="{{ route('addtocart',['course_id' => $item->courses->id, 'price' => $sellprice, 'discount_price' => $deal_price ]) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-md btn-primary">
                                                    <i class="fa fa-cart-plus"></i> {{ __("Add to cart") }}
                                                </button>
                                            </form>
                                        </div>
                                </div>
                            @else
                                <center>
                                    <a href="{{ route('user.course.show',['id' => $item->courses->id, 'slug' => $item->courses->slug ]) }}">

                                        <img width="100px" src="{{ asset('images/course/'.$item->courses['preview_image']) }}" class="mt-2" alt="...">
                                    </a>
                                </center>
                                <div class="card-body">
                                    <div class="card-title">
                                        <a class="text-dark" href="{{ route('user.course.show',['id' => $item->courses->id, 'slug' => $item->courses->slug ]) }}"></a>
                                    </div>

                                    <p>
                                        {{ substr(strip_tags($item->courses->detail), 0, 100)}}{{strlen(strip_tags($item->courses->detail))>100 ? '...' : ""}}
                                    </p>

                                    <h5>Discount : {{ $item->discount }}% ({{ $item->discount_type }})</h5>
                                    <hr>
                                        @php

                                            $mainprice = 0;


                                            if($item->courses->discount_price != '0'){
                                              
                                                echo sprintf("%.2f",$item->courses->discount_price);

                                            }else{
                                               
                                                echo sprintf("%.2f",$item->courses->price);

                                            }

                                            $sellprice = $item->courses->discount_price != 0 ? $item->courses->discount_price : $item->courses->price;

                                            $discount = $item->discount;

                                            $discount_type = $item->discount_type;

                                            $discounted_amount = 0;

                                            if($discount_type == 'upto'){

                                                $random_no = rand(0,$discount);
                                                
                                                $discounted_amount = $sellprice * $random_no / 100;

                                            }else{

                                                $discounted_amount = $sellprice * $discount / 100;

                                            }

                                            $deal_price = $sellprice - $discounted_amount;

                                        @endphp
                                        
                                        <div class="card-body">
                                            <form action="{{ route('addtocart',['course_id' => $item->courses->id, 'price' => $sellprice, 'discount_price' => $deal_price ]) }}" method="POST">
                                                @csrf
                                             
                                                <button class="btn btn-md btn-primary">
                                                    <i class="fa fa-cart-plus"></i> {{ __("Add to cart") }}
                                                </button>
                                            </form>
                                        </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @empty

                    <div class="col-md-12">
                        <h4 class="text-center">
                            {{__("No products found !")}}
                        </h4>
                    </div>
                        
                    @endforelse
                   
                </div>


            </div>

        @else
        
            <section id="search-block" class="search-main-block search-block-no-result text-center">
                <div class="container">
                    <div class="no-result-courses btm-10">{{ __('Flash Deal Ends') }}</div>
                    <div class="recommendation-btn text-white text-center">
                        <a href="{{ route('flash.deals') }}" class="btn btn-primary" title="search"><b>{{ __('Browse More Deals') }}</b></a>
                    </div> 
                </div>
            </section>

        @endif
        
    </div>
</div>
</section>

@endsection
@section('custom-script')
<script>
    (function () {
        const second = 1000,
            minute = second * 60,
            hour = minute * 60,
            day = hour * 24;

        let birthday = "{{ date('M d, Y h:i:s',strtotime($deal->end_date)) }}",
            countDown = new Date(birthday).getTime(),
            x = setInterval(function () {

                let now = new Date().getTime(),
                    distance = countDown - now;

                document.getElementById("days").innerText = Math.floor(distance / (day)),
                    document.getElementById("hours").innerText = Math.floor((distance % (day)) / (hour)),
                    document.getElementById("minutes").innerText = Math.floor((distance % (hour)) / (minute)),
                    document.getElementById("seconds").innerText = Math.floor((distance % (minute)) / second);

                //do something later when date is reached
                if (distance < 0) {
                    let headline = document.getElementById("headline"),
                        countdown = document.getElementById("countdown"),
                        content = document.getElementById("content");

                    headline.innerText = "It's my birthday!";
                    countdown.style.display = "none";
                    content.style.display = "block";

                    clearInterval(x);
                }
                //seconds
            }, 0)
    }());
</script>
@endsection