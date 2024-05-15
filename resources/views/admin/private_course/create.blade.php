@extends('admin.layouts.master')
@section('title','Create a new private_course')
@section('breadcum')
@component('components.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
{{ __('Private Course') }}
@endslot

@slot('menu1')
{{ __('Private Course') }}
@endslot

@slot('button')

<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
    <a href="{{ url('private-course') }}" class="float-right btn btn-primary-rgba mr-2"><i
        class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a> </div>
</div>

@endslot
@endcomponent
<div class="contentbar">
  <div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-box">{{ __('adminstaticword.Add') }} {{ __('Private Course') }}</h5>
        </div>
        <div class="card-body">
          <form action="{{url('private-course/')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="row">
              <div class="col-md-12">

                <div class="form-group">
                  <label>{{ __('adminstaticword.Select') }} {{ __('adminstaticword.Course') }}: <span
                      class="text-danger">*</span></label>
                  <select class="form-control js-example-basic-single" name="course_id" size="5" row="5"
                    placeholder="{{ __('adminstaticword.Select') }} {{ __('adminstaticword.Course') }}">


                    @foreach ($courses as $cat)
                    @if($cat->status == 1)
                    <option value="{{ $cat->id }}">{{ $cat->title }}
                    </option>
                    @endif

                    @endforeach

                  </select>
                </div>
              </div>
              

                <div class="form-group col-md-12">
                  <label>{{ __('Hide from ') }} {{ __('adminstaticword.Users') }}: <span
                      class="text-danger">*</span></label>
                  <select class="form-control js-example-basic-single" name="user_id[]" multiple="multiple" size="5"
                    row="5" placeholder="{{ __('adminstaticword.Select') }} {{ __('adminstaticword.Users') }}">


                    @foreach ($users as $user)
                    @if($user->status == 1)
                    <option value="{{ $user->id }}">{{ $user->fname }}
                    </option>
                    @endif

                    @endforeach

                  </select>
                </div>
             


             


                  <div class="form-group col-md-12">
                    @if(Auth::User()->role == "admin")
                    <label for="exampleInputDetails">{{ __('adminstaticword.Status') }}:</label>

                    <input class="custom_toggle" type="checkbox" name="status" id="cb3" checked />
                   


                   
                    @endif
                  </div>


              
                
                <div class="form-group col-md-12">
                  <button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i> {{ __('Reset') }}</button>
                  <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                    {{ __('Create') }}</button>
                </div>

                <div class="clear-both"></div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')


<script>
  (function ($) {
    "use strict";


    $(function () {
      $('.js-example-basic-single').select2();
    });


  })(jQuery);
</script>

@endsection