@extends('theme.master')
@section('title', 'Institute Profile')
@section('content')

@include('admin.message')
<!-- about-home start -->
@php
$gets = App\Breadcum::first();
@endphp
@if(isset($gets))
<!-- <section id="business-home" class="business-home-main-block">
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
                        <h1 class="wishlist-home-heading">{{ __('Institute Profile') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->
@endif
<!-- about-home end -->
<section id="institute" class="institute-main-block">
    <div class="instructor-img">
        <img src="{{ asset('images\default\insti_back.png') }}" alt="" class="back_img ">
    </div>
     <div class="overlay-bg"></div>
 </section>
<section id="blog" class="blog-main-block">
   
    <div class="container">
       
        <div class="card institute-profile-block">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="institute-profile">
                            <img src="{{ asset('files/institute/'.$data->image) }}" class="img-fluid" alt="">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="institute-profile-dtl">
                            <h5 class="card-title">{{ $data->title }}
                            @if($data->verified)
                                <img src="{{ url('admin_assets\assets\images\verified.png') }}" alt="">
                                @endif
                            </h5>
                            @php
                                $year = Carbon\Carbon::parse($data->created_at)->year;
                                $course_count = App\Course::where('institude_id',$data->id)->count();
                                $enroll_count = App\Order::where('course_id', $course->id)->count();
                                $live_1 = App\Meeting::where('course_id','=',$course->id)->count();
                                $live_2 = App\Googlemeet::where('course_id','=',$course->id)->count();
                                $live_3 = App\JitsiMeeting::where('course_id','=',$course->id)->count();
                                $live_4 = App\BBL::where('course_id','=',$course->id)->count();

                                $live_class = $live_1 + $live_2 + $live_3 + $live_4;
                            @endphp

                            <div class="about-reward-badges text-left">
                                <img src="{{url('images/badges/1.png')}}" class="img-fluid" alt="" data-toggle="tooltip" data-placement="bottom" title="Member Since {{ $year }}">
                                @if($course_count >= 5)
                                <img src="{{url('images/badges/2.png')}}" class="img-fluid" alt="" data-toggle="tooltip" data-placement="bottom" title="Has {{ $course_count }} courses">
                                @endif
                                <img src="{{url('images/badges/3.png')}}" class="img-fluid" alt="" data-toggle="tooltip" data-placement="bottom" title="rating from 4 to 5">
                                <img src="{{url('images/badges/4.png')}}" class="img-fluid" alt="" data-toggle="tooltip" data-placement="bottom" title="{{ $enroll_count }} users has enrolled">
                                <img src="{{url('images/badges/5.png')}}" class="img-fluid" alt="" data-toggle="tooltip" data-placement="bottom" title="Live classes {{ $live_class }}">
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="institute-profile-block-one text-center">
                    <div class="row">
                        <div class="col-md-4 col-6"> 
                            @php
                                $inst_count = App\Course::where('institude_id',$data->id)->count();
                            @endphp
                            
                                <div class="institute-profile-icon border-color text-center">
                                    <i class="fa fa-users course-icon"  aria-hidden="true"></i>
                                </div>
                                <p class="mt-2">{{ $inst_count }}</p>
                               

                                <p>Courses</p>
                            
                        </div>
                        <div class="col-md-4 col-6 border2">
                            @php
                                $instii= App\Course::where('institude_id',$data->id)->get();
                                $count = 0;
                                $count1 = 0;
                            @endphp
                            
                                
                            @foreach($instii as $value)
                            @php

                                $instii_count = App\Order::where('course_id',$value->id)->count();
                                $count  = $count + $instii_count;
                                
                            @endphp
                            
                            
                            @endforeach
                            

                            

                          
                            <div class="institute-profile-icon border1-color text-center">
                                <i class="fa fa-graduation-cap  course1-icon" aria-hidden="true"></i>
                               
                            </div>
                            <p class="mt-2">{{ $count }}</p>
                            
                            <p>Students</p>
                        </div>

                       
                            
                        <div class="col-md-4 col-6 border3 ">
                           
                            <div class="institute-profile-icon border2-color text-center">
                                <i class="fa fa-video-camera  course2-icon" aria-hidden="true"></i>
                                
                               
                            </div>
                            
                            <p class="mt-2">{{ $live_class }}</p>
                            <p>Meetings</p>

                        </div>
                    </div>
                </div>               
            </div>
        </div>
    </div>
  
</section>

<section id="blog" class="blog--block mb-4 institute-profile-des">
   
    <div class="container">
        <div class="card mt-3">
            <div class="card-body">
                
                <div class="row">
                    <div class="col-md-3 col-6">
                        <h5>About</h5>
                        <p >{{ $data->detail }}</p>
                    </div>
                    <div class="col-md-3 col-6">
                        <h5>Skill</h5>
                        <p >{{ $data->skill }}</p>
                    </div>
                    @if(isset($data->email))
                     <div class="col-md-3 col-6">
                        <h5>Email</h5>
                        <p >{{ $data->email ?? '' }}</p>
                    </div>
                    @endif
                    @if(isset($data->mobile))
                    <div class="col-md-3 col-6">
                        <h5>Mobile</h5>
                        <p >{{ $data->mobile ?? '' }}</p>
                    </div>
                    @endif
                </div>
              
                
            </div>
        </div>
        </div>
  
</section>


<!-- blog end -->

@endsection
