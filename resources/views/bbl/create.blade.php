@extends('admin.layouts.master')
@section('title', 'Create a new meeting - Admin')
@section('maincontent')


@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
{{ __('List all meetings') }}
@endslot
@slot('menu1')
{{ __('Mettings') }}
@endslot
@slot('menu2')
{{ __('Big Blue Mettings') }}
@endslot
@slot('menu3')
{{ __(' List all meetings') }}
@endslot
@slot('button')
<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
    <a href="{{url("bigblue/meetings")}}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>

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
          <h5 class="card-title">{{ __('Create a new meeting') }}</h5>
        </div>
        <div class="card-body">

          <form action="{{ route('bbl.store') }}" method="POST">
            @csrf

           <div class="row">
              <div class="form-group col-md-12">
                <label for="exampleInputDetails">{{ __('adminstaticword.LinkByCourse') }}:</label>
                    {{-- <input id="TextPosition" class="custom_toggle" type="checkbox" name="link_by" /> --}}

                    <input type="checkbox" id="myCheck" name="link_by" class="custom_toggle" onclick="myFunction()">
                    {{-- <input type="hidden" name="free" value="0" for="opp" id="link_by"> --}}

              </div>


              <div class="form-group col-md-12">
               <div style="display: none" id="update-password">
                <label>{{ __('adminstaticword.Courses') }}:<span class="redstar">*</span></label>
                <select name="course_id" id="course_id" class="select2-single form-control">
                  @php
                    $course = App\Course::where('status', '1')->where('user_id', Auth::user()->id)->get();
                  @endphp
                  @foreach($course as $cor)
                    <option value="{{$cor->id}}">{{$cor->title}}</option>
                  @endforeach
                </select>
              </div>
              </div>

              <div class="form-group col-md-6">
                <label  for="exampleInputDetails">{{ __('Presenter Name') }}: <sup class="redstar">*</sup></label>
                <input value="{{ old('presen_name') }}" type="text" name="presen_name" class="form-control" required="" placeholder="enter presenter name">
              </div>

              <div class="form-group col-md-6">
                <label>{{ __('adminstaticword.MeetingID') }}: <sup class="redstar">*</sup></label>
                <input value="{{ old('meetingid') }}" type="text" name="meetingid" class="form-control" required="" placeholder="enter meeting id">
               
              </div>
              <div class="form-group col-md-6">
                <label> {{ __('adminstaticword.Meeting') }} {{ __('adminstaticword.Name') }}: <sup class="redstar">*</sup></label>
                <input value="{{ old('meetingname') }}" type="text" name="meetingname" class="form-control" required="" placeholder="enter meeting name">
              </div>

              <div class="form-group col-md-6">
                <label>{{ __('adminstaticword.Meeting') }} {{ __('adminstaticword.Duration') }}: <sup class="redstar">*</sup>   <small class="text-muted">It will be count in minutes</small> </label>
                <input value="{{ old('duration') }}" type="text" name="duration" class="form-control" required="" placeholder="enter meeting duration eg. 40">
                
              </div>


              <div class="form-group col-md-12">
                <label>
                  {{ __('adminstaticword.StartTime') }}:<sup class="redstar">*</sup>
                </label>

                <div class="input-group" id='datetimepicker1'>
                  <input type="text"  name="start_time"   id="time-format" class="form-control" placeholder="dd/mm/yyyy - hh:ii aa" aria-describedby="basic-addon5" />
                  <div class="input-group-append">
                      <span class="input-group-text" id="basic-addon5"><i class="feather icon-calendar"></i></span>
                  </div>
                </div>
              </div>


              <div class="form-group col-md-6">
                <label> {{ __('Moderator Password') }}:</label>
                <div class="input-group mb-3">
                  
                  <input id="password-field"  type="password"  name="modpw" class="form-control" placeholder="enter moderator password">
                  <div class="input-group-prepend text-center">
                  <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span></i></span>
                  </div>
                </div>
               
              </div>


              <div class="form-group col-md-6">
                <label>{{ __('Attandee Password') }}: <small class="text-muted"><br>
                  (<b>Tip !</b> Share your attendee password to students using social handling networks.)</small></label>
                
                <input required id="attendeepw" value="" type="password" name="attendeepw" class="form-control" placeholder="enter attandee password">
                
                 <small class="text-muted">Should be diffrent from <b>Moderator</b> password</small>

              </div>

              <div class="form-group col-md-6">
                <label>Set Welcome Message:</label>
                <input value="{{ old('welcomemsg') }}" type="text" class="form-control" name="welcomemsg" placeholder="enter welcome message">

              </div>
              <div class="form-group col-md-6">
                <label>Set Max Participants:</label>
              <input value="{{ old('setMaxParticipants') }}" type="number" min="-1" class="form-control" name="setMaxParticipants" placeholder="enter maximum participant no., leave blank if want unlimited participant"/>

              </div>
              <div class="form-group col-md-6">
                <label>Set Mute on Start:</label>
                <input class="custom_toggle" type="checkbox" name="setMuteOnStart" />

              </div>
              <div class="form-group col-md-6">
                <label>Allow Record:</label>
                <input  class="custom_toggle" type="checkbox" ame="allow_record" />

              </div>
            </div>
            <button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i> Reset</button>
            <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
              Create</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>



@endsection
@section('script')

<script>
  (function($) {
    "use strict";
    $(function(){
        $('#myCheck').change(function(){
          if($('#myCheck').is(':checked')){
            $('#update-password').show('fast');
          }else{
            $('#update-password').hide('fast');
          }
        });
        
    });
  })(jQuery);
  </script>
@endsection