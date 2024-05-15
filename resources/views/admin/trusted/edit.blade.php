@extends('admin.layouts.master')
@section('title', 'Edit TruestedSlider- Admin')
@section('maincontent')
 

@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
   {{ __('Edit Truested Slider') }}
@endslot
@slot('menu1')
   {{ __('Front Settings') }}
@endslot
@slot('menu2')
   {{ __('Truested Slider') }}
@endslot

@slot('menu3')
   {{ __('Edit Truested Slider') }}
@endslot

@slot('button')
<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
    <a  href="{{url('trusted')}}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
      
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
          <h5 class="card-title">{{ __('adminstaticword.Edit') }} {{ __('adminstaticword.TrustedSlider') }}</h5>
        </div>
        <div class="card-body">
          <form id="demo-form" method="post"  action="{{url('trusted/'.$trusted->id)}}
            "data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
              {{ csrf_field() }}
              {{ method_field('PUT') }}

            <div class="row">
              <div class="form-group col-md-6">
                <label for="exampleInputTit1e">{{ __('adminstaticword.URL') }}:<sup class="redstar">*</sup></label>
                <input type="text" class="form-control" name="url" id="exampleInputTitle" value="{{$trusted->url}}">
                
              </div>
              <div class="form-group col-md-4 offset-md-2">
                <label for="exampleInputDetails">{{ __('adminstaticword.Status') }}:</label><br>
                
              
                <input id="status_toggle" type="checkbox" class="custom_toggle" name="status" {{ $trusted->status == '1' ? 'checked' : '' }} />
                <input type="hidden"  name="free" value="0" for="status" id="status">
              </div>
              <div class="form-group col-md-6">
                <label for="exampleInputSlug">{{ __('adminstaticword.Image') }}:<sup class="redstar">*</sup></label><br>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                  </div>
                  <div class="custom-file">
                    <input type="file" name="image" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                    <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                  </div>
                
                </div>
                <img src="{{ url('/images/trusted/'.$trusted->image) }}" class="img-responsive image_size" />
               
               
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
          
               
            
      
          
                    
                  

            
            
                      
                   
                   
