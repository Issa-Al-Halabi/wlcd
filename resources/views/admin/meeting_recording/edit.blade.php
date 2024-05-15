@extends('admin.layouts.master')
@section('title', 'Edit Meeting Recording- Admin')
@section('maincontent')
 

@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
   {{ __('Edit Meeting Recording') }}
@endslot
@slot('menu1')
   {{ __('Meeting ') }}
@endslot
@slot('menu2')
   {{ __('Meeting Recording') }}
@endslot
@slot('menu3')
   {{ __('Edit Meeting Recording') }}
@endslot
@slot('button')
<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
    <a href="{{url('meeting-recordings')}}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
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
      <h5 class="card-title">{{ __(' Edit Meeting Recording') }}</h5>
      </div>
      <div class="card-body">
        <form id="demo-form" method="post"  action="{{url('meeting-recordings/'.$recording->id)}}
          "data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
          {{ csrf_field() }}
          {{ method_field('PUT') }}
          <div class="row">
            <div class="col-md-6">
              <label for="exampleInputTit1e">{{ __('adminstaticword.Title') }}:<sup class="redstar">*</sup></label>
              <input type="text" class="form-control" name="title" id="exampleInputTitle" value="{{$recording->title}}">
            </div>
      
            <div class="col-md-6">
              <label for="exampleInputTit1e">{{ __('adminstaticword.Meeting') }} {{ __('adminstaticword.URL') }}:<sup class="redstar">*</sup></label>
              <input type="text" class="form-control" name="url" id="exampleInputTitle" value="{{$recording->url}}">
            </div>
          </div>
          <div class="form-group mt-3">
            <button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i> {{ __('Reset') }}</button>
            <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
              {{ __('Update') }}</button>
          </div>
        </form>
      </div>
    </div>
    </div>
  </div>
</div>

       
@endsection

