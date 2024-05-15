@extends('theme.master')
@section('title', 'Compare')
@section('content')
@include('admin.message')
<style>
    .compare-image{
        height:150px;
        width:150px;
    }
</style>
<!-- about-home start -->
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
                        <h1 class="wishlist-home-heading">{{ __('Course Compare') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<section id="blog" class="blog-main-block compare-block">
    <div class="container">
       
      <div class="row">
          <div class="col-md-12">
            <div class="card-body">
                @if(count($compare) > 0)                
                <!-- Start table div -->
                <div class="table-responsive">
                    <!-- Start table-->
                    <table  class="table table-striped table-bordered">
                       
                        
                        <tbody class="bg-white">
                            <tr>
                                <td>
                                    
                                </td>
                                @foreach($compare as $cour)
                                @php
                                $c = App\Course::where('id', $cour->course_id)->first();
                                @endphp
                                <td>
                                    <img src="{{ asset('images/course/'.$c->preview_image) }}" alt="{{ __('course')}}" class="img-fluid compare-image">
                                <h5 class="text-info mt-2">{{ $c->title }}</h5>

                                </td>
                                
                                @endforeach
                               
                            </tr>
                        </tbody>
                        <tbody>
                            <tr class="bg-white">
                                <td>
                                  <h5>Price</h5> 
                                </td>
                                @foreach($compare as $cour)
                                    @php
                                    $c = App\Course::where('id', $cour->course_id)->first();
                                    @endphp
                                    <td>{{ $c->price }}</td>
                                @endforeach
                               
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <td>
                                 <h5>Discount Price</h5>  
                                </td>
                                @foreach($compare as $cour)
                                    @php
                                    $c = App\Course::where('id', $cour->course_id)->first();
                                    @endphp
                                    <td>@if($c->discount_price)
                                        {{  $c->discount_price }}
                                        @else
                                        <i class="fa fa-times text-danger" aria-hidden="true"></i>
                                        @endif
                                    </td>
                                @endforeach
                               
                            </tr>
                        </tbody >
                        <tbody>
                            <tr class="bg-white">
                                <td>
                                  <h5>{{ __('Language')}}</h5>  
                                </td>
                                @foreach($compare as $cour)
                                @php
                                $c = App\Course::where('id', $cour->course_id)->first();
                                @endphp
                                @php
                                $lang = App\Language::where('id', $c->language_id)->first();
                                @endphp
                               <td>
                               <p>{{ $lang->name }}</p>
                               </td>
                               @endforeach
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <td>
                                 <h5>{{ __('Last updated at')}}</h5>   
                                </td>
                                @foreach($compare as $cour)
                                @php
                                $c = App\Course::where('id', $cour->course_id)->first();
                                @endphp
                               
                               <td>
                               <p>{{ date('d-M-Y', strtotime($c->updated_at)); }}</p>
                               </td>
                               @endforeach
                            </tr>
                        </tbody>
                        <tbody >
                            <tr class="bg-white">
                                <td>
                                    <h5>{{ __('Duration end time')}}</h5>
                                    
                                </td>
                                @foreach($compare as $cour)
                                @php
                                $c = App\Course::where('id', $cour->course_id)->first();
                                @endphp
                               
                               <td>
                                <p>@if($c->duration && $c->duration_type)
                                    {{ $c->duration }}  {{ $c->duration_type }}
                                    @else
                                    <span class="badge badge-pill badge-primary">{{ __('Life time')}} </span>
                                 @endif

                                </p>
                                </td>
                               @endforeach
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <td>
                                   <h5>{{ __('Requirements')}}</h5> 
                                </td>
                                @foreach($compare as $cour)
                                @php
                                $c = App\Course::where('id', $cour->course_id)->first();
                                @endphp
                               
                               <td>
                                <p>{{ $c->requirement }}</p>
                                </td>
                               @endforeach
                            </tr>
                        </tbody>
                        <tbody>
                            <tr class="bg-white">
                                <td>
                                 <h5>{{ __('Short Detail')}}</h5>   
                                </td>
                                @foreach($compare as $cour)
                                @php
                                $c = App\Course::where('id', $cour->course_id)->first();
                                @endphp
                               
                               <td>
                                <p>{{ $c->short_detail }}</p>
                                </td>
                               @endforeach
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <td>
                                   <h5>{{ __('Category')}}</h5> 
                                </td>
                                @foreach($compare as $cour)
                                @php
                                    $c = App\Course::where('id', $cour->course_id)->first();
                                @endphp
                                @php
                                    $cate = App\Categories::where('id', $c->category_id)->first();
                                @endphp
                               <td>
                                <p>{{ $cate->title }}</p>
                                </td>
                               @endforeach
                            </tr>
                        </tbody>
                        <tbody>
                            <tr class="bg-white">
                                <td>
                                  <h5>{{ __('Sub Category')}}</h5>  
                                </td>
                                @foreach($compare as $cour)
                                @php
                                    $c = App\Course::where('id', $cour->course_id)->first();
                                @endphp
                                @php
                                    $subcate = App\SubCategory::where('id', $c->subcategory_id)->first();
                                @endphp
                               <td>
                                <p>{{ $subcate->title }}</p>
                                </td>
                               @endforeach
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <td>
                                   <h5>{{ __('Certificate')}}</h5> 
                                </td>
                                @foreach($compare as $cour)
                                @php
                                    $c = App\Course::where('id', $cour->course_id)->first();
                                @endphp
                               
                               <td>
                                <p>@if($c->certificate_enable == 1)</p>
                                <i class="fa fa-check-circle text-success" aria-hidden="true"></i>
                                  @else
                                  <i class="fa fa-times text-danger" aria-hidden="true"></i>
                                  @endif

                                </td>
                               @endforeach
                            </tr>
                        </tbody>
                        <tbody>
                            <tr class="bg-white">
                                <td>
                                   <h5>{{ __('Appointment')}}</h5> 
                                </td>
                                @foreach($compare as $cour)
                                @php
                                    $c = App\Course::where('id', $cour->course_id)->first();
                                @endphp
                               
                               <td>
                                <p>@if($c->appointment_enable == 1)</p>
                                <i class="fa fa-check-circle text-success" aria-hidden="true"></i>
                                  @else
                                  <i class="fa fa-times text-danger" aria-hidden="true"></i>
                                  @endif

                                </td>
                               @endforeach
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <td>
                                   <h5>{{ __('Assignment')}}</h5> 
                                </td>
                                @foreach($compare as $cour)
                                @php
                                    $c = App\Course::where('id', $cour->course_id)->first();
                                @endphp
                               
                               <td>
                                <p>@if($c->assignment_enable == 1)</p>
                                <i class="fa fa-check-circle text-success" aria-hidden="true"></i>
                                  @else
                                  <i class="fa fa-times text-danger" aria-hidden="true"></i>
                                  @endif

                                </td>
                               @endforeach
                            </tr>
                        </tbody>
                        <tbody>
                            <tr class="bg-white">
                                <td>
                                    
                                </td>
                                    @foreach($compare as $cour)
                                <td>

                                <a href="{{ route('compare.remove',['id' => $cour->id]) }}">
                                    <span class="badge badge-danger">{{ __("Remove") }}</span>
                                </a> 

                                </td>
                               @endforeach
                            </tr>
                        </tbody>
                    </table>
                    <!-- end table -->
                </div>
                @else
                <div class="compare-data-block">
                    {{ __('No Data Found')}}
                </div>
                @endif
                <!-- end table div -->
            </div>
          </div>
      </div>
                   
                      
                        

    </div>
</section>

@endsection
