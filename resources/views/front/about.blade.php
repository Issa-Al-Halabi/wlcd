@extends('theme.master')
@section('title', 'About Us')
@section('content')

@include('admin.message')
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
                <div class="col-lg-12">
                    <div class="bredcrumb-dtl text-center">
                        <h1 class="wishlist-home-heading">{{ __('About us') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- about-home start -->
{{-- @if($about['one_enable'] == 1)
<section id="about-home-one" class="about-home-one-main-block" style="background-image: url('{{ asset('images/about/'.$about->one_image) }}')">
    <div class="overlay-bg"></div>
    <div class="container">
        <h1 class="about-home-one-heading text-center">{{ $about->one_heading }}</h1>
    </div>
</section>
<section id="about-blog" class="about-blog-main-block">
    <div class="container">
        <div class="about-blog-block text-center"><a href="{{ $about->link_four }}" title="NextClass Blog"><span>
            <i class="fa fa-circle rgt-10"></i>{{ $gsetting->project_title }} {{ __('Blog')}}: </span>{{ $about->one_text }}</a>
        </div>
    </div>   
</section>
@endif  --}}
<!-- about-blog end -->
<!-- about-Transforming start -->
@if($about['two_enable'] == 1)
<section id="about-transforming" class="about-transforming-main-block">
   <div class="container">
        <div class="about-transforming-heading-block text-center">
            <div class="row">
                <div class="offset-lg-2 col-lg-8 col-12">
                    <h1 class="text-center">{{ $about->two_heading }}</h1>  
                    <p>{{ $about->two_text }}</p>
                </div>
            </div>
        </div>
     

        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-xl-3 col-sm-6 cols-6" style="padding: 10px;">
                    <div class="nav-border">
                        <a  href="#">
                            <img src="{{ asset('images/about/'.$about->two_imagetwo) }}" class="img-fluid tab-img" alt="about-img">
                            <div class="about-nav-heading active">
                                <b>{{ $about->two_txttwo }}</b>
                                <p class="btm-40">{{ $about->two_imagetext }}</p>
                            </div>
                          </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-xl-3 col-sm-6 cols-6" style="padding: 10px;">
                    <div class="nav-border">
                        <a href="#">
                            <img src="{{ asset('images/about/'.$about->two_imagefour) }}" class="img-fluid tab-img" alt="about-img">
                            <div class="about-nav-heading active">
                                <b>{{ $about->two_txtfour }}</b>
                            <p class="btm-40">{{ $about->two_imagetext }}</p>
                            </div>
                          </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-xl-3 col-sm-6 cols-6" style="padding: 10px;">
                    <div class="nav-border">
                        <a href="#">
                            <img src="{{ asset('images/about/'.$about->two_imagethree) }}" class="img-fluid tab-img" alt="about-img">
                            <div class="about-nav-heading active">
                                <b>{{ $about->two_txtthree }}</b>
                                <p class="btm-40">{{ $about->text_three }}</p>
                            </div>
                          </a>
                    </div>
                </div>
                <div class=" col-lg-3 col-md-3 col-xl-3 col-sm-6 cols-6" style="padding: 10px;">
                    <div class="nav-border">
                        <a href="#">
                            <img src="{{ asset('images/about/'.$about->two_imageone) }}" class="img-fluid tab-img" alt="about-img">
                            <div class="about-nav-heading active">
                                <b>{{ $about->two_txtone }}</b>
                                <p class="btm-40">{{ $about->text_one }}</p>
                            </div>
                          </a>
                    </div>
                </div>
                    {{-- <ul id="tabs" class="nav nav-tabs" role="tablist"> --}}
                        {{-- <li class="nav-item">
                          <a id="tab-A" href="#pane-A" class="nav-link active" data-toggle="tab" role="tab">
                            <img src="{{ asset('images/about/'.$about->two_imageone) }}" class="img-fluid tab-img" alt="about-img">
                            <div class="about-nav-heading active">{{ $about->two_txtone }}</div>
                          </a>
                        </li> --}}
                        {{-- <li class="nav-item">
                          <a id="tab-B" href="#pane-B" class="nav-link" data-toggle="tab" role="tab">
                            <img src="{{ asset('images/about/'.$about->two_imagetwo) }}" class="img-fluid tab-img" alt="about-img">
                            <div class="about-nav-heading active">{{ $about->two_txttwo }}</div>
                          </a>
                        </li> --}}
                        {{-- <li class="nav-item">
                          <a id="tab-C" href="#pane-C" class="nav-link" data-toggle="tab" role="tab">
                            <img src="{{ asset('images/about/'.$about->two_imagethree) }}" class="img-fluid tab-img" alt="about-img">
                            <div class="about-nav-heading active">{{ $about->two_txtthree }}</div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a id="tab-D" href="#pane-D" class="nav-link" data-toggle="tab" role="tab">
                            <img src="{{ asset('images/about/'.$about->two_imagefour) }}" class="img-fluid tab-img" alt="about-img">
                            <div class="about-nav-heading active">{{ $about->two_txtfour }}</div>
                          </a>
                        </li> --}}
                    {{-- </ul> --}}
                </div>
                {{-- <div class="col-lg-7">
                    <div id="content" class="tab-content" role="tablist">
                        <div id="pane-A" class="card tab-pane fade show active" role="tabpanel" aria-labelledby="tab-A">
                          <div class="card-header" role="tab" id="heading-A">
                            <h5 class="mb-0">
                              <a data-toggle="collapse" href="#collapse-A" data-parent="#content" aria-expanded="true" aria-controls="collapse-A">
                                    {{ $about->two_txtone }}
                                  </a>
                            </h5>
                          </div>
                          <div id="collapse-A" class="collapse show" role="tabpanel" aria-labelledby="heading-A">
                            <div class="card-body">
                              <div class="about-transforming-img">
                                <a href="#" title="about">
                                    <img src="{{ asset('images/about/'.$about->two_imageone) }}" class="img-fluid" alt="about-img"><div class="overlay-bg"></div>
                                </a>
                            </div>
                            <div class="about-transforming-block">
                                <h3>{{ $about->two_txtone }}</h3>
                                <p class="btm-40">{{ $about->two_imagetext }}</p>
                            </div>
                            </div>
                          </div>
                        </div>

                        <div id="pane-B" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-B">
                          <div class="card-header" role="tab" id="heading-B">
                            <h5 class="mb-0">
                              <a class="collapsed" data-toggle="collapse" href="#collapse-B" data-parent="#content" aria-expanded="false" aria-controls="collapse-B">
                                    {{ $about->two_txttwo }}
                                  </a>
                            </h5>
                          </div>
                          <div id="collapse-B" class="collapse" role="tabpanel" aria-labelledby="heading-B">
                            <div class="card-body">
                                <div class="about-transforming-img">
                                    <a href="#" title="about">
                                        <img src="{{ asset('images/about/'.$about->two_imagetwo) }}" class="img-fluid" alt="about-img"><div class="overlay-bg"></div>
                                    </a>
                                </div>
                                <div class="about-transforming-block">
                                    <h3>{{ $about->two_txttwo }}</h3>
                                    <p class="btm-40">{{ $about->text_one }}</p>
                                </div>
                            </div>
                          </div>
                        </div>

                        <div id="pane-C" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-C">
                          <div class="card-header" role="tab" id="heading-C">
                            <h5 class="mb-0">
                              <a class="collapsed" data-toggle="collapse" href="#collapse-C" data-parent="#content" aria-expanded="false" aria-controls="collapse-C">
                                    {{ $about->two_txtthree }}
                                  </a>
                            </h5>
                          </div>
                          <div id="collapse-C" class="collapse" role="tabpanel" aria-labelledby="heading-C">
                            <div class="card-body">
                                <div class="about-transforming-img">
                                    <a href="#" title="about">
                                        <img src="{{ asset('images/about/'.$about->two_imagethree) }}" class="img-fluid" alt="about-img"><div class="overlay-bg"></div>
                                    </a>
                                </div>
                                <div class="about-transforming-block">
                                    <h3>{{ $about->two_txtthree }}</h3>
                                    <p class="btm-40">{{ $about->text_two }}</p>
                                </div>
                            </div>
                          </div>
                        </div>

                        <div id="pane-D" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-D">
                          <div class="card-header" role="tab" id="heading-D">
                            <h5 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" href="#collapse-D" data-parent="#content" aria-expanded="false" aria-controls="collapse-C">
                                    {{ $about->two_txtfour }}
                                </a>
                            </h5>
                          </div>
                          <div id="collapse-D" class="collapse" role="tabpanel" aria-labelledby="heading-D">
                            <div class="card-body">
                                <div class="about-transforming-img">
                                    <a href="#" title="about">
                                        <img src="{{ asset('images/about/'.$about->two_imagefour) }}" class="img-fluid" alt="about-img"><div class="overlay-bg"></div>
                                    </a>
                                </div>
                                <div class="about-transforming-block">
                                    <h3>{{ $about->two_txtfour }}</h3>
                                    <p class="btm-40">{{ $about->text_three }}</p>
                                </div>
                            </div>
                          </div>
                        </div>

                    </div>
                </div> --}}
        </div>

   </div> 
</section>
@endif
<!-- about-Transforming end -->
<!-- facts start-->
@if($about['three_enable'] == 1)
<section id="facts" class="facts-main-block">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="facts-block-heading text-center">{{ $about->three_heading }}</h1>
                <p class="text-center btm-40">{{ $about->three_text }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-4 col-sm-6 col-6">
                <div class="facts-block text-center btm-40">
                    <h1 class="facts-heading counter">{{ $about->three_countone }}</h1>
                    <div class="facts-dtl">{{ $about->three_txtone }}</div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-6">
                <div class="facts-block text-center btm-40">
                    <h1 class="facts-heading counter">{{ $about->three_counttwo }}</h1>
                    <div class="facts-dtl">{{ $about->three_txttwo }}</div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-6">
                <div class="facts-block text-center btm-40">
                    <h1 class="facts-heading counter">{{ $about->three_countthree }}</h1>
                    <div class="facts-dtl">{{ $about->three_txtthree }}</div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-6">
                <div class="facts-block text-center btm-40">
                    <h1 class="facts-heading counter">{{ $about->three_countfour }}</h1>
                    <div class="facts-dtl">{{ $about->three_txtfour }}</div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-6">
                <div class="facts-block text-center btm-40">
                    <h1 class="facts-heading counter">{{ $about->three_countfive }}</h1>
                    <div class="facts-dtl">{{ $about->three_txtfive }}</div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-6">
                <div class="facts-block text-center btm-40">
                    <h1 class="facts-heading counter">{{ $about->three_countsix }}</h1>
                    <div class="facts-dtl">{{ $about->three_txtsix }}</div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- facts end-->
<!-- about-work start-->
@if($about['four_enable'] == 1)
<section id="about-work" class="about-work about-work-mai-block moto-widget moto-widget-block moto-background-fixed moto-spacing-top-large moto-spacing-right-auto moto-spacing-bottom-medium moto-spacing-left-auto">
    <div class="container-fluid">
        <div class="row no-gutters">
            <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12">
                <div class="about-work-block text-center">
                    <div class="about-work-heading">{{ $about->four_heading }}</div>
                    <p class="btm-30">{{ $about->four_text }}</p>
                   
                </div>
            </div>
            {{-- <div class="col-lg-6">
                <div class="about-work-video">
                    <div class="video-item hidden-xs">
                        <script type="text/javascript">
                        var video_url = '<iframe src="https://www.youtube.com/embed/ZMdCsIaE7II?autoplay=1&showinfo=0" frameborder="0"></iframe>';
                        </script>
                        <div class="video-device">
                            <img src="{{ asset('images/about/background.png') }}" class="bg_img img-fluid" alt="Background">

                            <div class="overlay-bg"></div>
                            <div class="video-preview">
                                <p>{{ $about->four_txtone }}</p>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
        {{-- <div class="row no-gutters">
            <div class="col-lg-6">
                <div class="about-work-video">
                    <div class="video-item hidden-xs">
                        <script type="text/javascript">
                        var video_url = '<iframe src="https://www.youtube.com/embed/ZMdCsIaE7II?autoplay=1&showinfo=0" frameborder="0"></iframe>';
                        </script>
                        <div class="video-device">
                            <img src="{{ asset('images/about/'.$about->four_imagetwo) }}" class="bg_img img-fluid" alt="Background">

                            <div class="overlay-bg"></div>
                            <div class="video-preview">
                                <p>{{ $about->four_txttwo }}</p>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-work-block text-center">
                    <div class="about-work-heading">{{ $about->four_heading }}</div>
                    <p class="text-white btm-30">{{ $about->four_text }}</p>
                    
                </div>
            </div>
        </div> --}}
    </div>
</section>
@endif
<!-- about-work end-->
<!-- about-team start-->
{{-- @if($about['five_enable'] == 1)
<section id="about-team" class="about-team-main-block">
    <div class="container">
        <div class="row no-gutters">
            <div class="col-lg-6">
                <div class="about-team-block text-center">
                    <div class="about-team-heading btm-20">{{ $about->five_heading }}</div>
                    <p class="btm-40">{{ str_limit($about->five_text, $limit = 200, $end = '...') }}</p>
                   
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-team-img">
                    <img src="{{ asset('images/about/'.$about->five_imageone) }}" class="img-fluid" alt="about-img">
                </div>
                <div class="row no-gutters">
                    <div class="col-lg-6 col-sm-6">
                       <div class="about-team-img">
                            <img src="{{ asset('images/about/'.$about->five_imagetwo) }}" class="img-fluid" alt="about-img">
                        </div> 
                    </div>
                    <div class="col-lg-6 col-sm-6">
                       <div class="about-team-img">
                            <img src="{{ asset('images/about/'.$about->five_imagethree) }}" class="img-fluid" alt="about-img">
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif --}}
<!-- about-team start-->
<!-- about-learning-blog start-->
@if($about['six_enable'] == 1)
<section id="about-learning-blog" class="about-learning-blog-main-block">
    <div class="container">
        <h1 class="about-learning-blog-heading text-center text-dark btm-40">{{ $about->six_heading }}</h1>
        <div class="about-learning-blog-block">
            <div class="row">
                <div class="col-lg-4">
                    <a href="{{ $about->link_one }}">
                    <div class="about-learning-blog-dtl nav-border btm-20">
                        <p class="moto-text_system_13 animate1 text-dark">
                            <span
                              class="display-9 my-3 font-weight-bold text-dark animate1"
                              >01</span
                            >
                          </p>
                        <h3 class="about-learning-blog-dtl-heading text-dark">{{ $about->six_txtone }}</h3>
                        <div class="row">
                            <div class="col-lg-10 col-9">
                                <div class="about-learning-blog-paragraph">
                                    <p class="text-dark">{{ str_limit($about->six_deatilone, $limit = 100, $end = '...') }}</p>
                                </div>
                            </div>
                            <div class="col-lg-2 col-3">
                                <div class="about-learning-blog-icon lft-7">
                                    {{-- <i class="fa fa-chevron-right"></i> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-lg-4">
                    <a href="{{ $about->link_two }}">
                    <div class="about-learning-blog-dtl btm-20 nav-border">
                        <p class="moto-text_system_13 animate1 text-dark">
                            <span
                              class="display-9 my-3 font-weight-bold text-dark animate1"
                              >02</span
                            >
                          </p>
                        <h3 class="about-learning-blog-dtl-heading text-dark">{{ $about->six_txttwo }}</h3>
                        <div class="row">
                            <div class="col-lg-10 col-9">
                                <div class="about-learning-blog-paragraph lft-7">
                                    <p class="text-dark">{{ str_limit($about->six_deatiltwo, $limit = 100, $end = '...') }}</p>
                                </div>
                            </div>
                            <div class="col-lg-2 col-3">
                                <div class="about-learning-blog-icon">
                                    {{-- <i class="fa fa-chevron-right"></i> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-lg-4">
                    <a href="{{ $about->link_three }}">
                    <div class="about-learning-blog-dtl text-dark nav-border">
                        <p class="moto-text_system_13 animate1">
                            <span
                              class="display-9 my-3 font-weight-bold text-dark animate1"
                              >03</span
                            >
                          </p>
                        <h3 class="about-learning-blog-dtl-heading text-dark">{{ $about->six_txtthree }}</h3>
                        <div class="row">
                            <div class="col-lg-10 col-9">
                                <div class="about-learning-blog-paragraph">
                                    <p>{{ str_limit($about->six_deatilthree, $limit = 100, $end = '...') }}</p>
                                </div>
                            </div>
                            <div class="col-lg-2 col-3">
                                <div class="about-learning-blog-icon lft-7">
                                    {{-- <i class="fa fa-chevron-right"></i> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="about-social-list text-white text-center">
        <ul>
            <li>Follow Us :</li>
            @if($about->four_btntext == !NULL)
            <li><a href="{{ $about->four_btntext }}" target="_blank" title="facebook"><i class="fab fa-facebook-f"></i></a></li>
            @endif
            @if($about->five_btntext == !NULL)
            <li><a href="{{ $about->five_btntext }}" target="_blank" title="instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>
            @endif
            @if($about->linkedin == !NULL)
            <li><a href="{{ $about->linkedin }}" target="_blank" title="linkedin"><i class="fab fa-linkedin" aria-hidden="true"></i></a></li>
            @endif
            @if($about->twitter == !NULL)
            <li><a href="{{ $about->twitter }}" target="_blank" title="twitter"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
            @endif
        </ul>
    </div>
</section>
@endif
<!-- about-learning-blog end-->
@endsection


<style>
    @import url("http://fonts.googleapis.com/css?family=Raleway:400,100,200,300,500,600,800,700,900");
    .nav-border{
    border-radius: 6px;
    overflow: hidden;
    position: relative;
    cursor: pointer;
    -webkit-transition: all 0.5s ease;
    -ms-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    transition: all 0.5s ease;
    box-shadow: 5px 5px 10px rgb(0 0 0 / 10%);
    border: 2px solid transparent;
    }
    .nav-border:hover{
    border: 2px solid #54b435;
    border-radius: 6px;
    transform: translateY(-15px);
    transition: all .5s ease;
    box-shadow: 0px 0px 10px rgb(84 180 53 / 80%);
    }
    .moto-text_system_13 {
  font-weight: 700;
  font-style: normal;
  font-family: "Raleway", sans-serif;
  color: #ffffff;
  font-size: 66px;
  line-height: 1;
  letter-spacing: -2px;
}
.moto-widget {
    background-image: url("/images/joininstructor/background.png");
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
    width: 180px;
    margin-bottom: 10px;
    position: relative;
    /*-moz-transition: all 0.5s;*/
    /*-webkit-transition: all 0.5s;*/
    /*transition: all 0.5s;*/
}

.bg-primary {
    background-color: #ffffff !important;
}

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
</style>