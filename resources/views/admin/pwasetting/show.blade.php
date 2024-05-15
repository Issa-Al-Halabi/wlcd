@extends('admin.layouts.master')
@section('title', 'PWA Settings - Admin')
@section('maincontent')
@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
   {{ __('PWA Settings') }}
@endslot
@slot('menu1')
{{ __('PWA Settings') }}
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
                    <h5 class="card-box">{{ __('PWA Settings') }}</h5>
                </div> 
               
                <!-- card body started -->
                <div class="card-body">
                <ul class="nav nav-tabs mb-3" id="defaultTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#facebook" role="tab" aria-controls="home" aria-selected="true">{{ __('Update Manifest') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#google" role="tab" aria-controls="profile" aria-selected="false">{{ __('Update PWA Icons') }}</a>
                </li>
               
            </ul>
            <div class="tab-content" id="defaultTabContent">

                <!-- === Update Manifest start ======== -->
                <div class="tab-pane fade show active" id="facebook" role="tabpanel" aria-labelledby="home-tab">
                   
                    <div class="card bg-success-rgba m-b-30">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <small class="text-success process-fonts"><i class="fa fa-info-circle"></i> {{ __('Progessive Web App Requirements') }}

                                <ul process-font>
                    
                                    <li><b>{{ __('HTTPS') }}</b> {{ __('must required in your domain (for enable contact your host provider for SSL configuration).') }}</li>
                                    <li><b>{{ __('Icons and splash screens') }}</b> {{ __('required and to be updated in Icon Settings') }}</li>
                                </ul>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                    <!-- Update Manifest form start -->
                    @include('admin.pwasetting.manifest')
                    <!-- Update Manifest form end -->    
                </div>
                  <!-- === Update Manifest end ======== -->

                  <!-- === Update PWA Icons start ======== -->
                <div class="tab-pane fade" id="google" role="tabpanel" aria-labelledby="profile-tab">
                    <!-- === Update PWA Icons form start ======== -->
                    @include('admin.pwasetting.icon')
                    <!-- === Update PWA Icons form end ===========-->
                </div>
                <!-- === Update PWA Icons end ======== -->

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