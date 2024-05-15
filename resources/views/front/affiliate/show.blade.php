<!-- Affiliate Refferal section start -->
@extends('theme.master')
@section('title', 'Refer Link')
@section('content')
@include('admin.message')
<!-- affiliate-header start -->
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
                        <h1 class="wishlist-home-heading">{{ __('Refer & Earn') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- affiliate-header end -->

<!-- affiliate-user-link start -->
<section id="profile-item" class="profile-item-block refer-block">
    <div class="container">

        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-4">
                <div class="dashboard-author-block text-center">
                    <div class="author-image">
					    <div class="avatar-upload">
					        <div class="avatar-preview">
					        	@if(Auth::user()->user_img != null || Auth::user()->user_img !='')
						            <div class="avatar-preview-img" id="imagePreview" style="background-image: url({{ url('/images/user_img/'.Auth::user()->user_img) }});">
						            </div>
						        @else
						        	<div class="avatar-preview-img" id="imagePreview" style="background-image: url({{ asset('images/default/user.jpg')}});">
						            </div>
						        @endif
					        </div>
					    </div>
                    </div>
                    <div class="author-name">{{ Auth::user()->fname }}&nbsp;{{ Auth::user()->lname }}</div>
                </div>
                <div class="dashboard-items">
                    <ul>
                        <li>
                            <i class="fa fa-bookmark"></i>
                            <a href="{{ route('mycourse.show') }}" title="{{ __('Dashboard')}}">{{ __('My Courses') }}</a>
                        </li>
                        <li>
                            <i class="fa fa-heart"></i>
                            <a href="{{ route('wishlist.show') }}" title="{{ __('Profile Update')}}">{{ __('My Wishlist') }}</a>
                        </li>
                        <li>
                            <i class="fa fa-history"></i>
                            <a href="{{ route('purchase.show') }}" title="{{ __('Followers')}}">{{ __('Purchase History') }}</a>
                        </li>
                        <li>
                            <i class="fa fa-user"></i>
                            <a href="{{route('profile.show',Auth::user()->id)}}" title="{{ __('Upload Items')}}">{{ __('User Profile') }}</a>
                        </li>
                        @if(Auth::user()->role == "user")
                        <li>
                            <i class="fas fa-chalkboard-teacher"></i>
                            <a href="#" data-toggle="modal" data-target="#myModalinstructor" title="{{ __('Become An Instructor')}}">{{ __('Become An Instructor') }}</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 col-md-8">

                <div class="profile-info-block user-bank-button">

                    <h4 class="">{{ __('Your Refferal Link') }}</h4>

      				@auth


                    <div class="input-group mb-3">
                      <input type="text" id="myInput" class="form-control" value="{{ url('/register') . '/?ref=' . Auth::user()->affiliate_id }}" >
                      <div class="input-group-append refer-btn">
                        <button onclick="myFunction()" class="btn btn-primary" type="button"><i data-feather="copy"></i></button>
                      </div>
                    </div>


					@endauth

                    @if(auth()->user()->affiliate_id == NULL)

		            <form id="mainform" action="{{ route('generate.affiliate') }}" method="POST">
		              @csrf

		                <button type="submit" class="pull-left btn btn-primary">
		                  {{ __('Generate Affiliate Link') }}
		                </button>
		              </div>

		            </form>

                    @endif

                    @php
                      $affilates = App\Affiliate::first();
                    @endphp
                      
                    @if(isset($affilates))
                        @if($affilates['image'] !== NULL && $affilates['image'] !== '')
                        
                            <div class="recommendation-main-block  text-center" style="background-image: url('{{ asset('images/affiliate/'.$affilates['image']) }}')">
                           
                            </div>
                            <br>
                        @endif
                        <div class="info">{!! $affilates->text !!}</div>
                    @endif
                 
                    <br>
                </div>
                
            </div>
        </div>
    </div>
</section>
<!-- affiliate-user-link end -->
@endsection
<!-- Affiliate Refferal section end -->
@section('custom-script')
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