@extends('admin.layouts.master')
@section('title', 'Create SiteMap - Admin')
@section('maincontent')
@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
   {{ __('Site Map') }}
@endslot
@slot('menu1')
{{ __('Site Map') }}
@endslot

@endcomponent
<div class="contentbar">
    <div class="row">
@if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach  
  </div>
  @endif
  
    <!-- row started -->
    <div class="col-lg-12">
    
        <div class="card m-b-30">
                <!-- Card header will display you the heading -->
                <div class="card-header">
                    <h5 class="card-box">{{ __('adminstaticword.GenerateSitemap') }}</h5>
                </div> 
               
                <!-- card body started -->
                <div class="card-body">
                <!-- form start -->
                <div class="row">
                    <div class="col-md-12">

                     <!-- form start -->
                     <form action="{{ action('SiteMapController@sitemap') }}" class="form" method="POST" novalidate enctype="multipart/form-data">
				  		        {{ csrf_field() }}
				              {{ method_field('POST') }}
			                     <div class="form-group">
                              <button type="submit" class="btn btn-primary-rgba btn-lg btn-block"><i class="fa fa-check-circle"></i>
                              {{ __('adminstaticword.GenerateSitemap') }}</button>
		                        </div>
			               </form>
                    <!-- form end -->
                    </div>


                    @php
                      $path = 'sitemap.xml';
                    @endphp



                  @if(file_exists(public_path().'/'.$path))


                    <div class="col-md-12">
                         <!-- form start -->
                        <form action="{{ action('SiteMapController@download') }}" method="POST" enctype="multipart/form-data">
				                {{ csrf_field() }}
				                {{ method_field('POST') }}
                            <div class="form-group">
                            <button type="submit" class="float-left btn btn-primary-rgba"><i class="feather icon-download"></i> {{ __('adminstaticword.DownloadSitemap') }}</button>
                            </div>
			                 </form>

                        <!-- form end -->
                    </div>


                  @endif
                </div>
			
                            

                </div><!-- card body end -->
            
        </div><!-- col end -->
    </div>
</div>
</div><!-- row end -->
    <br><br>
@endsection
<!-- main content section ended -->
<!-- This section will contain javacsript start -->
@section('script')

@endsection
<!-- This section will contain javacsript end -->