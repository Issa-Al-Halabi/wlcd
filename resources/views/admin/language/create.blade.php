@extends('admin.layouts.master')
@section('title', 'Add Language')
@section('maincontent')
@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
   {{ __('Add Language') }}
@endslot
@slot('menu1')
{{ __('Language') }}
@endslot
@slot('button')
<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
  <a href="{{route('show.lang')}}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
  </div>
</div>
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
                    <h5 class="card-box">{{ __('adminstaticword.Language') }}</h5>
                </div> 
               
                <!-- card body started -->
                <div class="card-body">
                 <!-- form start -->
                 <form id="demo-form2" method="post" action="{{action('LanguageController@store')}}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                          <!-- Local -->
                          <div class="col-md-5">
                            <div class="form-group">
                              <label class="text-dark" for="local">{{ __('adminstaticword.Local') }} : <span class="text-danger">*</span></label>
                              <input class="form-control @error('local') is-invalid @enderror" value="{{ old('local') }}" type="text" name="local" placeholder="Please enter language local name" required>
                            </div>
                          </div>

                          <!-- Name -->
                          <div class="col-md-5">
                            <div class="form-group">
                              <label class="text-dark" for="name">{{ __('adminstaticword.Name') }} : <span class="text-danger">*</span></label>
                              <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name" id="sub_heading" placeholder="Please enter language name eg:English" required>
                            </div>
                          </div>

                          <!-- SetDefault -->
                          <div class="form-group col-md-2">
                              <label for="exampleInputDetails">{{ __('adminstaticword.SetDefault') }} :</label><br>
                              <input type="checkbox" class="custom_toggle" name="def" checked />
                              <input type="hidden"  name="free" value="0" for="status" id="status">
                          </div>
                
                    </div>
                   
                    <div class="form-group">
                        <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                        <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                        {{ __("Create")}}</button>
                    </div>
                  
                  </form>
                  <!-- form end -->
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