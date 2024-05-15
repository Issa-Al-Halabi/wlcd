@extends('admin.layouts.master')
@section('title', 'Remove public - Admin')
@section('maincontent')
@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
   {{ __('Remove Public') }}
@endslot
@slot('menu1')
{{ __('Remove Public') }}
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
                    <h5 class="card-box">{{ __('Remove Public') }}</h5>
                </div> 
               
                <!-- card body started -->
                <div class="card-body">
                <div class="card bg-success-rgba m-b-30">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <small class="text-success process-fonts"><i class="fa fa-info-circle"></i> {{ __('adminstaticword.ImportantNote') }}
                                        <ul class="process-font">
                                    <li>
                                        {{__(('Removing public from URL is only works when you have installed script in main domain.'))}}
                                    </li>

                                    <li>
                                        {{__("Do not remove public when you have Installed script in subdomin or subfolders.")}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- =============================== -->
                <div class="row">
                 
                    @if(file_exists(base_path().'/'.'.htaccess'))         
                    @if($contents == NULL || $contents != $destinationPath)
                    <div class="col-12">
                        <!-- form start -->
                        <form action="{{ route('add.content') }}" class="form" method="POST">
                            @csrf
                            <!-- row start -->
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- card start -->
                                    <div class="card">
                                        <!-- card body start -->
                                        <div class="card-body">
                                            <!-- row start -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <!-- row start -->
                                                    <div class="row">       
                                                            <div class="col-md-12">
                                                                <label class="text-dark">{{ __('Remove public from URL') }}</label>
                                                                    <button type="submit" class="btn btn-primary btn-block">
                                                                        {{__("Click to Remove public")}}
                                                                    </button>
                                                            </div>
                                                    </div><!-- row end -->
                                                </div><!-- col end -->
                                            </div><!-- row end -->
                                        </div><!-- card body end -->
                                    </div><!-- card end -->
                                </div><!-- col end -->
                            </div><!-- row end -->
                        </form>
                    <!-- form end -->
                    </div>@endif
                        @elseif(!file_exists(base_path().'/'.'.htaccess') )
                        <div class="col-12">
                            <!-- form start -->
                            <form action="{{ route('create.file') }}" class="form" method="POST">
                                @csrf
                                <!-- row start -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- card start -->
                                        <div class="card">
                                            <!-- card body start -->
                                            <div class="card-body">
                                                <!-- row start -->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <!-- row start -->
                                                        <div class="row">       
                                                            <div class="col-md-4">
                                                            <label class="text-dark">{{ __('Remove public from URL') }}</label>
                                                                <button type="submit" class="btn btn-primary-rgba btn-block">
                                                                    {{__("Click to Remove public")}}
                                                                </button>
                                                            </div>
                                                        </div><!-- row end -->
                                                    </div><!-- col end -->
                                                </div><!-- row end -->
                                            </div><!-- card body end -->
                                        </div><!-- card end -->
                                    </div><!-- col end -->
                                </div><!-- row end -->
                            </form>
                            <!-- form end -->
                        </div>
                        @endif
                   
                </div>
                <!-- =============================== -->
               
                </div>
                <!-- card body end -->
            
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