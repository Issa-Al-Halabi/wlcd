@extends('admin.layouts.master')
@section('title','Edit reviewrating')
@section('maincontent')

@component('components.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __('Admin') }}
@endslot

@slot('menu2')
{{ __(' Edit Review Rating') }}
@endslot

@slot('button')
<div class="col-md-4 col-lg-4">
<a href="" class="float-right btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
</div>
@endslot
@endcomponent
<div class="contentbar">
  <div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-title">{{ __('adminstaticword.Edit') }} {{ __('Review Rating') }}</h5>
        </div>
        <div class="card-body ml-2">
          <form id="demo-form" method="post" action="{{url('reviewrating/'.$jp->id)}}"data-parsley-validate class="form-horizontal form-label-left">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <div class="row">
              <div class="col-md-6">
                <label class="display-none" for="exampleInputSlug">{{ __('adminstaticword.Course') }} :</label>
                <select name="course" class="form-control select2 col-md-7 col-xs-12 display-none">
                  @foreach($courses as $cou)
                    <option value="{{ $cou->id }}" {{$jp->courses->id == $cou->id  ? 'selected' : ''}}>{{ $cou->title}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <label class="display-none" for="exampleInputSlug">{{ __('adminstaticword.User') }} :</label>
                <select name="user" class="form-control select2 col-md-7 col-xs-12 display-none">
                @foreach($users as $cu)
                <option value="{{ $cu->id }}" {{$jp->user->id == $cu->id  ? 'selected' : ''}}>{{ $cu->fname}}</option>
                @endforeach
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <label for="Details">{{ __('adminstaticword.Review') }} :<sup class="redstar">*</sup></label>
                <textarea rows="3" name="review"  class="form-control" placeholder="Enter Your review">{{ $jp->review }}</textarea>
              </div>
            </div>   
            <br>

            <div class="row">
              <div class="col-md-3">
                <label for="exampleInputTit1e">{{ __('adminstaticword.Status') }} :</label><br>
                <label class="switch">
                  <input class="slider" type="checkbox" name="status" {{ $jp->status == '1' ? 'checked' : '' }} />
                  <span class="knob"></span>
                </label>
                
              </div>
              <div class="col-md-3">
                <label for="exampleInputTit1e">{{ __('adminstaticword.Approved') }} :</label><br>
                <label class="switch">
                  <input class="slider" type="checkbox" name="approved" {{ $jp->approved == '1' ? 'checked' : '' }} />
                  <span class="knob"></span>
                </label>
              </div>
              <div class="col-md-3">
                <label for="exampleInputTit1e">{{ __('adminstaticword.Featured') }} :</label><br>
                <label class="switch">
                  <input class="slider" type="checkbox" name="featured" {{ $jp->featured == '1' ? 'checked' : '' }} />
                  <span class="knob"></span>
                </label>
              </div>
            </div>
            <br>
      
            <div class="form-group">
              <button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i>
                {{ __('Reset') }}</button>
              <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                {{ __('Update') }}</button>
            </div>
            <div class="clear-both"></div>
        
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
