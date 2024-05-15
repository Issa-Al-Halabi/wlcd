@extends('admin.layouts.master')
@section('title','Edit Answer')
@section('maincontent')

@component('components.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __('Admin') }}
@endslot

@slot('menu2')
{{ __(' Edit Answer') }}
@endslot

@slot('button')
<div class="col-md-4 col-lg-4">
  <a href="{{ url('instructoranswer')}}" class="float-right btn btn-primary mr-2"><i
      class="feather icon-arrow-left mr-2"></i>Back</a>
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
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="box-title">{{ __('adminstaticword.Edit') }} {{ __('adminstaticword.Answer') }}</h5>
        </div>
        <div class="card-body ml-2">
          <form action="{{url('instructoranswer/'.$answer->id)}}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <label class="d-none" for="exampleInputSlug">{{ __('adminstaticword.SelectCourse') }}</label>
              <input value="{{ $answer->course_id }}" autofocus name="course_id" class="d-none" type="text" class="form-control select2" >


              <div class="row">
                <div class="col-md-12">
                  <label for="exampleInput"> {{ __('adminstaticword.Answer') }}:<sup class="redstar">*</sup></label>
                  <textarea name="answer" rows="4" class="form-control" placeholder="Please Enter Your Answer">{{ $answer->answer }}</textarea>
                </div>
              </div>
            
            <br>


            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                <label for="exampleInputTit1e">{{ __('adminstaticword.Status') }}:</label>
                <input id="cb10111" type="checkbox" class="custom_toggle" name="status"
                {{ $answer->status==1 ? 'checked' : '' }} />
               
                <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="cb10111"></label>
                
                <input type="hidden" name="status" value="{{ $answer->status }}" id="jjjj">
            </div>
           
            
            
            <div class="form-group">
              <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i>
                Reset</button>
              <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                Update</button>
            </div>

            <div class="clear-both"></div>
        </div>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
{{-- @extends('admin/layouts.master')
@section('title', 'Edit Answer - Instructor')
@section('body')

<section class="content">
  <div class="row">
    <!-- left column -->
    <div class="col-xs-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> {{ __('adminstaticword.Edit') }} {{ __('adminstaticword.Answer') }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="form-group">
            <form action="{{url('instructoranswer/'.$answer->id)}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <label class="display-none" for="exampleInputSlug">{{ __('adminstaticword.SelectCourse') }}</label>
                  <input value="{{ $answer->course_id }}" autofocus name="course_id" type="text" class="form-control display-none" >


                  <div class="row">
                    <div class="col-md-12">
                      <label for="exampleInput"> {{ __('adminstaticword.Answer') }}:<sup class="redstar">*</sup></label>
                      <textarea name="answer" rows="4" class="form-control" placeholder="Please Enter Your Answer">{{ $answer->answer }}</textarea>
                    </div>
                  </div>
                
                <br>


                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                    <label for="exampleInputTit1e">{{ __('adminstaticword.Status') }}:</label>
                    <li class="tg-list-item">
                    <input class="tgl tgl-skewed" id="cb10111" type="checkbox" {{ $answer->status==1 ? 'checked' : '' }}>
                    <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="cb10111"></label>
                    </li>
                    <input type="hidden" name="status" value="{{ $answer->status }}" id="jjjj">
                </div>
                </div>
                <br>
                <br>
                <br>
                
                <div class="box-footer">
                  <button value="" type="submit"  class="btn btn-md col-md-2 btn-primary">{{ __('adminstaticword.Save') }}</button>
                </div>

            </form>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!--/.col (right) -->
  </div>
  <!-- /.row -->
</section> 

@endsection --}}
