@extends('theme.master')
@section('title', 'Help')
@section('content')

@include('admin.message')

<!-- help start-->
@php
$gets = App\Breadcum::first();
@endphp
@if(isset($gets))
<section id="business-home" class="business-home-main-block">
    <div class="business-img">
        @if($gets['img'] !== NULL && $gets['img'] !== '')
        <img src="{{ url('/images/breadcum/'.$gets->img) }}" class="img-fluid" alt="" />
        @else
        <img src="{{ Avatar::create($gets->text)->toBase64() }}" alt="{{ __('course')}}" class="img-fluid">
        @endif
    </div>
    <div class="overlay-bg"></div>
    <div class="container-fluid">
        <div class="business-dtl">
            <div class="row">
                <div class="col-lg-6">
                    <div class="bredcrumb-dtl">
                        <h1 class="wishlist-home-heading">{{ __('help text') }}</h1>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="business-home-search">
                        <form method="GET" id="searchform" action="{{ route('search') }}">
                            <div class="search">
                                <input type="text" name="searchTerm" class="searchTerm" placeholder="Search for courses" value="{{ isset($searchTerm) ? $searchTerm : '' }}" autocomplete="off">
                                <button type="submit" class="searchButton">
                                    {{ __('Search')}}
                                </button>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- help end-->
<!-- help-tab start-->
<section id="help-tab" class="help-tab-main-block">
    <div class="container">
        <div class="offset-lg-4 col-lg-6">
            <nav>
                <div class="nav nav-tabs btm-40" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">{{ __('Students') }} </a>
                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">{{ __('Instructor') }} </a>
                </div>
            </nav>
        </div>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="help-tab-heading btm-40">{{ __('faq') }}</div>
                <div class="help-tab-block btm-30">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                @php
                                    $faqs = App\FaqStudent::all();
                                @endphp
                                @foreach($faqs as $faq)
                                @if($faq->status == 1)
                                <div class="col-lg-4 col-md-6">
                                    <a href="{{ route('faq.detail',$faq->id) }}">
                                        <div class="categories-block help-tab">
                                            <div class="help-tab-one-block"> 
                                            {{ $faq->title }}
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="help-tab-heading btm-40">{{ __('search topic') }}</div>
                <div class="help-tab-block btm-30">
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <div class="categories-block help-tab-one text-center">
                                <div class="help-tab-two">
                                    <a href="{{ route('purchase.show') }}">
                                    <ul>
                                        <li class="btm-10"><img src="{{ asset('images/icons/05.png') }}"></li>
                                        <li class="btm-5"><span>{{ __('Purchase History') }}</span></li>
                                        <li>{{ __('See your purchase history & explore more Courses')}}</li>
                                    </ul>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="categories-block help-tab-one text-center">
                                <div class="help-tab-two">
                                    @if(Auth::check())
                                        <a href="{{route('profile.show',Auth::User()->id)}}">
                                        <ul>
                                            <li class="btm-10"><img src="{{ asset('images/icons/02.png') }}"></li>
                                            <li class="btm-5"><span>{{ __('UserProfile') }}</span></li>
                                            <li>{{ __('Manage your account settings.')}}</li>
                                        </ul>
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}">
                                        <ul>
                                            <li class="btm-10"><img src="{{ asset('images/icons/02.png') }}"></li>
                                            <li class="btm-5"><span>{{ __('UserProfile') }}</span></li>
                                            <li>{{ __('Manage your account settings.')}}</li>
                                        </ul>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">                            
                            <div class="categories-block help-contact text-center text-white">
                                
                                <a href="{{url('user_contact')}}">
                                    <ul>
                                        <li class="btm-10"><img src="{{ asset('images/icons/contact.png') }}"></li>
                                        <br>
                                        <li class="text-white"><span>{{ __('Contactus') }}</span></li>
                                        <br>
                                        <li class="text-white">{{ __('Open a support ticket')}}</li>
                                    </ul>
                                </a>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="help-tab-heading btm-40">{{ __('faq') }}</div>
                <div class="help-tab-block btm-30">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                @php
                                    $faqss = App\FaqInstructor::all();
                                @endphp
                                @foreach($faqss as $faqs)
                                @if($faqs->status == 1)
                                <div class="col-lg-4 col-md-6">
                                    <a href="{{ route('faqinstructor.detail',$faqs->id) }}">
                                        <div class="categories-block help-tab">
                                            <div class="help-tab-one-block"> 
                                                {{ $faqs->title }}
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endif
                                @endforeach
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="help-tab-heading btm-40">{{ __('search topic') }}</div>
                <div class="help-tab-block btm-30">
                    <div class="row">
                        @if($gsetting->instructor_enable == 1)
                        <div class="col-lg-4 col-md-4">
                            
                            <div class="categories-block help-tab-one text-center">
                                <div class="help-tab-two">
                                    @if(Auth::check())
                                        @if(Auth::User()->role == "user")
                                        
                                        <a href="#" data-toggle="modal" data-target="#myModalinstructor" title="{{ __('Become An Instructor')}}">
                                        <ul>
                                            <li class="btm-10"><img src="{{ asset('images/icons/08.png') }}"></li>
                                            <li class="btm-5"><span>{{ __('Become An Instructor') }}</span></li>
                                            <li>{{ __('To Become An Online Instructor')}}</li>
                                        </ul>
                                        </a>
                                        @endif
                                        
                                    @else
                                        <a href="{{ route('login') }}">
                                        <ul>
                                            <li class="btm-10"><img src="{{ asset('images/icons/08.png') }}"></li>
                                            <li class="btm-5"><span>{{ __('Become An Instructor') }}</span></li>
                                            <li>{{ __('To Become An Online Instructor')}}</li>
                                        </ul>
                                        </a>
                                    @endif
                                </div>
                            </div>

                        </div>
                        @endif
                        <div class="col-lg-4 col-md-4">
                            <div class="categories-block help-contact text-center text-white">
                               
                                <a href="{{url('user_contact')}}">
                                    <ul>
                                        <li class="btm-10"><img src="{{ asset('images/icons/contact.png') }}"></li>
                                        <br>
                                        <li class="text-white"><span>{{ __('Contact us') }}</span></li>
                                        <br>
                                        <li class="text-white">{{ __('Open a support ticket')}}</li>
                                    </ul>
                                </a>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- help-tab end-->

@endsection

@section('custom-script')
<!-- script to remain on active tab-->
<script>
(function($) {
  "use strict";
  $(document).ready(function(){
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#nav-tab a[href="' + activeTab + '"]').tab('show');
    }
  });

})(jQuery);
</script>

@endsection