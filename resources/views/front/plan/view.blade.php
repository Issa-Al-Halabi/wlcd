@extends('theme.master')
@section('title', 'Instructor Subscription Plan')
@section('content')

@include('admin.message')


<!-- about-home start -->
<section id="blog-home" class="blog-home-main-block">
    <div class="container">
        <h1 class="blog-home-heading text-white">{{ __('Instructor Plan') }}</h1>
    </div>
</section> 

<section id="profile-item" class="profile-item-block">
    <div class="container">
        @if(isset($subscribed))
        <h4 class="student-heading">{{ __('Active Plan') }}</h4>
        <div class="row">
            @foreach($subscribed as $subscrib)
            @if($subscrib->plans->status == '1')
            
                <div class="col-lg-3 col-sm-6 col-md-4">
                    <div class="view-block btm-10">
                        <div class="view-img">
                            @if($subscrib->plans['preview_image'] !== NULL && $subscrib->plans['preview_image'] !== '')
                                <img src="{{ asset('images/plan/'.$subscrib->plans->preview_image) }}" class="img-fluid" alt="{{ __('course')}}">
                            @else
                                <a href=""><img src="{{ Avatar::create($subscrib->plans->title)->toBase64() }}" class="img-fluid" alt="{{ __('course')}}">
                            @endif
                            </a>
                        </div>
                       
                        <div class="view-dtl">
                            <div class="view-heading btm-10"><a href="">{{ str_limit($subscrib->plans->title, $limit = 35, $end = '...') }}</a></div>

                            <div class="text-right">{{ __('Allowed Courses') }}: {{ $subscrib->plans->courses_allowed }}</div>

                            <div class="text-right">

                                <div class="">{{ __('Duration') }}:</div>
                                <ul>


                                @if($subscrib->plans->duration == 'm')

                                    @if($subscrib->plans->discount_price == !NULL)

                                    <li class="rate-r"><s>@if($subscrib->plans->type == 1)<i class="{{ $currency->icon }}"></i>{{ $subscrib->plans->price }} /@endif {{ $subscrib->plans->duration }} {{ __('Month') }}</s></li>

                                    <li><b>@if($subscrib->plans->type == 1)<i class="{{ $currency->icon }}"></i>{{ $subscrib->plans->discount_price }}/@endif {{ $subscrib->plans->duration }} {{ __('Month') }}</b></li>

                                    @else

                                    <li class="rate-r">@if($subscrib->plans->type == 1)<i class="{{ $currency->icon }}"></i>{{ $subscrib->plans->price }} /@endif {{ $subscrib->plans->duration }} {{ __('Month') }}</li>

                                    @endif
                                    
                                @else

                                    @if($subscrib->plans->discount_price == !NULL)
                                    <li class="rate-r"><s>@if($subscrib->plans->type == 1)<i class="{{ $currency->icon }}"></i>{{ $subscrib->plans->price }} /@endif {{ $subscrib->plans->duration }} {{ __('Days') }}</s></li>

                                    <li><b>@if($subscrib->plans->type == 1)<i class="{{ $currency->icon }}"></i>{{ $subscrib->plans->discount_price }}/@endif {{ $subscrib->plans->duration }} {{ __('Days') }}</b></li>

                                    @else

                                    <li class="rate-r">@if($subscrib->plans->type == 1)<i class="{{ $currency->icon }}"></i>{{ $subscrib->plans->price }} /@endif {{ $subscrib->plans->duration }} {{ __('Days') }}</li>

                                    @endif
                                @endif
                            </ul>

                            </div>
                           
                            @if($subscrib->plans->type == 1)
                            <div class="rate text-right">
                                <ul>
                                    

                                    @if($subscrib->plans->discount_price == !NULL)

                                        <li class="rate-r"><s><i class="{{ $currency->icon }}"></i>{{ $subscrib->plans->price }}</s></li>
                                        <li><b><i class="{{ $currency->icon }}"></i>{{ $subscrib->plans->discount_price }}</b></li>
                                    @else
                                        <li><b><i class="{{ $currency->icon }}"></i>{{ $subscrib->plans->price }}</b></li>
                                    @endif
                                </ul>
                            </div>
                            @else
                            <div class="rate text-right">
                                <ul>
                                  <li><b>{{ __('Free') }}</b></li>
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                   
                </div>
            @endif
            @endforeach
        </div>

        @endif
        
    </div>
</section>
<!-- profile update start -->
<section id="profile-item" class="profile-item-block">
    <div class="container">
        <h4 class="student-heading">{{ __('All Plans Available') }}</h4>
    	<div class="row">
    		@foreach($plans as $plan)
            @if($plan->status == '1')
        	
                <div class="col-lg-3 col-sm-6 col-md-4">
                    <div class="genre-slide-image @if($gsetting['course_hover'] == 1) protip @endif" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-next-item-description-block{{$plan->id}}">
                        <div class="view-block btm-10">
                            <div class="view-img">
                                @if($plan['preview_image'] !== NULL && $plan['preview_image'] !== '')
                                    <a href=""><img src="{{ asset('images/plan/'.$plan->preview_image) }}" class="img-fluid" alt="course">
                                @else
                                    <a href=""><img src="{{ Avatar::create($plan->title)->toBase64() }}" class="img-fluid" alt="course">
                                @endif
                                </a>
                            </div>
                           
                            <div class="view-dtl">
                                <div class="view-heading"><a href="">{{ str_limit($plan->title, $limit = 35, $end = '...') }}</a></div>

                                <div class="text-right">{{ __('Allowed Courses') }}: {{ $plan->courses_allowed }}</div>

                                <div class="text-right">

                                	<div class="">Duration:</div>
                                    <ul>


                                	@if($plan->duration == 'm')

                                		@if($plan->discount_price == !NULL)

                                        <li class="rate-r"><s>@if($plan->type == 1)<i class="{{ $currency->icon }}"></i>{{ $plan->price }} /@endif {{ $plan->duration }} {{ __('Month')}}</s></li>

                                        <li><b>@if($plan->type == 1)<i class="{{ $currency->icon }}"></i>{{ $plan->discount_price }} /@endif {{ $plan->duration }} {{ __('Month')}}</b></li>

                                        @else

                                        <li class="rate-r">@if($plan->type == 1)<i class="{{ $currency->icon }}"></i>{{ $plan->price }} /@endif {{ $plan->duration }} {{ __('Month')}}</li>

                                        @endif
                                        
                                    @else

                                    	@if($plan->discount_price == !NULL)
                                        <li class="rate-r"><s>@if($plan->type == 1)<i class="{{ $currency->icon }}"></i>{{ $plan->price }} @endif / {{ $plan->duration }} {{ __('Days')}}</s></li>

                                        <li><b>@if($plan->type == 1)<i class="{{ $currency->icon }}"></i>{{ $plan->discount_price }} / @endif {{ $plan->duration }} {{ __('Days')}}</b></li>

                                        @else

                                        <li class="rate-r">@if($plan->type == 1)<i class="{{ $currency->icon }}"></i>{{ $plan->price }} / @endif {{ $plan->duration }} {{ __('Days')}}</li>

                                        @endif
                                    @endif
                                </ul>

                                </div>
                               
                               
                            </div>
                        </div>
                    </div>
                    <div id="prime-next-item-description-block{{$plan->id}}" class="prime-description-block">
                        <div class="prime-description-under-block">
                            <div class="prime-description-under-block">
                                <h5 class="description-heading">{{ $plan['title'] }}</h5>
                                

                                <div class="main-des">
                                    <p>{!! $plan->detail !!}</p>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="planlist-action">
                        <div class="row">
                        	<div class="col-md-12 col-12">
                               
                                @if($plan->type == 1)
                                <div class="plan-enroll-btn btm-10">
                                    <form id="demo-form2" method="post" action="{{ route('plan.checkout') }}"
                                            data-parsley-validate class="form-horizontal form-label-left">
                                            {{ csrf_field() }}
                                            
                                            <input type="hidden" name="plan_id"  value="{{ $plan->id }}" />
                                        
                                         <button type="submit" class="btn btn-primary"  title="{{ __('Add To Cart')}}">
                                            {{ __('Subscribe Now')}}
                                        </button>
                                    </form>
                                </div>
                                @else

                                <div class="plan-enroll-btn btm-10">
                                    <form id="demo-form2" method="post" action="{{ route('free.plan.checkout') }}"
                                            data-parsley-validate class="form-horizontal form-label-left">
                                            {{ csrf_field() }}
                                            
                                            <input type="hidden" name="plan_id"  value="{{ $plan->id }}" />
                                        
                                         <button type="submit" class="btn btn-primary"  title="Add To Cart">
                                            {{ __('Subscribe Now')}}
                                        </button>
                                    </form>
                                </div>

                                @endif
                        	</div>
                        	
                        </div>
                    </div>
                </div>
            @endif
            @endforeach
    	</div>
    	
    </div>
</section>
<!-- profile update end -->
@endsection

@section('custom-script')



@endsection
