@extends('admin/layouts.master')
@section('title', 'Edit Advertisement - Admin')
@section('maincontent')
 

@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
   {{ __('Edit Advertisement') }}
@endslot
@slot('menu1')
   {{ __('Front Settings') }}
@endslot
@slot('menu2')
   {{ __('Advertisement') }}
@endslot
@slot('menu3')
   {{ __('Edit Advertisement') }}
@endslot

@slot('button')
<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
    <a href="{{url('advertisement')}}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>

  </div>
</div>
@endslot
@endcomponent


<div class="contentbar">
  @if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
  @endforeach  
  </div>
  @endif
         

  <div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-title">{{ __('adminstaticword.Edit') }} {{ __('adminstaticword.Advertisement') }}</h5>
        </div>
        <div class="card-body">

          <form id="demo-form" method="post" action="{{url('advertisement/'.$advs->id)}}
            "data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
                    
            <div class="row">
              <div class="form-group col-md-6">
                <label for="exampleInputDetails">{{ __('adminstaticword.EnterURL') }}:</label>
                <input type="title" class="form-control" name="url1" id="exampleInputTitle" value="{{ $advs->url1 }}" placeholder="{{ __('adminstaticword.EnterURL') }}" >

              </div>
              <div class="form-group col-md-6">
                <label for="exampleInputDetails">{{ __('adminstaticword.Position') }}:<sup class="redstar">*</sup></label>
                          <select class="select2-single form-control"  name="position">
                          </option>
                          <option {{ $advs->position == 'belowslider' ? 'selected' : ''}} value="belowslider">{{ __('Below Slider') }}</option>

                          <option {{ $advs->position == 'belowrecent' ? 'selected' : ''}} value="belowrecent">{{ __('Below Recent Courses') }}</option>
      
                          <option {{ $advs->position == 'belowbundle' ? 'selected' : ''}} value="belowbundle">{{ __('Below Bundle Courses') }}</option>
      
                          <option {{ $advs->position == 'belowtestimonial' ? 'selected' : ''}} value="belowtestimonial">{{ __('Below Testimonial') }}</option>
                        </select>
                      </div>
                      
              <div class="form-group col-md-6">
                <label for="exampleInputTit1e">{{ __('adminstaticword.Image') }}:<sup class="redstar">*</sup></label><br>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                  </div>
                  <div class="custom-file">
                    <input type="file" name="image1" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                    <label class="custom-file-label" for="inputGroupFile01">{{ __('Back') }}{{ __('Choose file') }}</label>
                  </div>
                </div>
                
               
                <img src="{{ url('/images/advertisement/'.$advs->image1) }}" class="image_size"/><br>

                <small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('adminstaticword.RecommnadedSize') }} (1375 x 409px)</small>
              </div>
              <div class="form-group col-md-6">
                <label for="exampleInputDetails">{{ __('adminstaticword.Status') }}:</label><br>
                
                <input type="hidden"  name="free" value="0" for="status" id="status">
                <input id="status" type="checkbox" name="status" {{ $advs->status == '1' ? 'checked' : '' }} class="custom_toggle" />
              </div>
                
            </div>
          
          <div class="form-group">
            <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
            <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
            {{ __("Update")}}</button>
          </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
            

@endsection

      
      
      

              



