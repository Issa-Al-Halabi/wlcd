@extends('admin.layouts.master')
@section('title', 'Edit Appointment - Admin')
@section('maincontent')
@component('components.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Edit Appointment') }}
@endslot
@slot('menu1')
{{ __('Appointment') }}
@endslot
@slot('menu2')
{{ __('Edit Appointment') }}
@endslot
@endcomponent
<div class="contentbar">
  <div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-title">{{ __('adminstaticword.Appointment') }}</h5>
        </div>
        <div class="card-body">
          <div class="view-instructor">
            <div class="instructor-detail ">
              <ul style="list-style-type:none;" class="mt-3">
                <li>
                  @if($appoint->user->user_img != null || $appoint->user->user_img !='')
                    <img src="{{ asset('images/user_img/'.$appoint->user->user_img) }}" class="img-circle"/>
                  @else
                    <img src="{{ asset('images/default/user.jpg')}}" class="img-circle" alt="User Image">
                  @endif
                </li>
                <li><span class="text-dark">{{ __('adminstaticword.User') }}: </span>{{ $appoint->user->fname }} {{ $appoint->user->lname }}</li>
                <li><span class="text-dark">{{ __('adminstaticword.Course') }}: </span>{{ $appoint->courses->title }}</li>
                <li><span class="text-dark">{{ __('adminstaticword.Title') }}:</span> {{ $appoint->title }}</li>
                <li><span class="text-dark">{{ __('adminstaticword.Detail') }}:</span> {!! $appoint->detail !!}</li>
              </ul>
            </div>
          </div>
          <div class="row col-md-12 ml-4">
            <form action="{{route('appointment.update',$appoint->id)}}" method="POST" enctype="multipart/form-data">
              {{ csrf_field() }}
              {{ method_field('PUT') }}
              <input type="hidden" value="{{ $appoint->user_id }}" name="user_id" class="form-control">
              <input type="hidden" value="{{ $appoint->course_id }}" name="course_id" class="form-control">
              <div class="row ">
                <div class=" form-group col-md-6">
                  <label for="exampleInputTit1e">{{ __('adminstaticword.Accept') }}:</label><br>
                  <label class="switch">
                    <input class="slider" type="checkbox" name="search_enable" {{ $appoint->accept == 1 ? 'checked' : '' }}  />
                    <span class="knob"></span>
                  </label>
                    <!--<input  type="checkbox" name="search_enable"  id="appoint_accept" {{ $appoint->accept == 1 ? 'checked' : '' }}  class="custom_toggle"/>           -->
                </div>
              </div>
              <br>
              <div class="row" style="{{ $appoint['accept'] == '1' ? '' : 'display:none' }}" id="sec1_one">
                <div class="col-md-12">
                  <label for="exampleInputDetails">{{ __('adminstaticword.Reply') }}:</label>
                  <textarea id="reply" name="reply" rows="1" class="form-control" placeholder="Enter class detail">{{ $appoint['reply'] }}</textarea>
                </div>
              </div>
              <br>
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
@section('script')
<!--courseclass.js is included -->
<script>
 tinymce.init({selector:'textarea#reply'});
</script>
<script>
(function($) {
  "use strict";
  $(function(){
      $('#appoint_accept').change(function(){
        if($('#appoint_accept').is(':checked')){
          $('#sec1_one').show('fast');
          $('#sec_one').hide('fast');
        }else{
          $('#sec1_one').hide('fast');
          $('#sec_one').show('fast');
        }
      });
  });
})(jQuery);
</script>
@endsection