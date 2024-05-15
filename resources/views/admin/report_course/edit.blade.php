@extends('admin.layouts.master')
@section('title', 'Edit Report Course - Admin')
@section('maincontent')
 

@component('components.breadcumb',['thirdactive' => 'active'])
@slot('heading')
   {{ __('Edit Report Course') }}
@endslot
@slot('menu1')
   {{ __('Report') }}
@endslot
@slot('menu2')
   {{ __('Edit Report Course') }}
@endslot

@slot('button')
<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
    <a href="{{url('admin/report/view')}}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>

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
          <h5 class="card-title">{{ __('Edit Report Course') }}</h5>
        </div>
        <div class="card-body">
          
      <form action="{{url('admin/report/view/'.$show->id)}}" method="POST">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
          
          <div class="row">
            <div class="form-group col-md-6">
        <label for="title">{{ __('adminstaticword.Title') }}<sup class="redstar">*</sup></label>
        <input value="{{ $show->title }}" autofocus required name="title" type="text" class="form-control" placeholder="Enter Title"/>
              
            </div>
            <div class="form-group col-md-6">
        <label for="email">{{ __('adminstaticword.Email') }}<sup class="redstar">*</sup></label>
        <input value="{{ $show->email }}" autofocus required name="email" type="email" class="form-control" placeholder="Enter Email"/>
            </div>

           
            <div class="form-group col-md-12">
        <label for="detail">{{ __('adminstaticword.Detail') }}<sup class="redstar">*</sup></label>
        <textarea name="detail" value="" rows="4"  class="form-control" placeholder="">{{ $show->detail }}</textarea>
            </div>
          
            
          <div class="form-group  col-md-12">
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

