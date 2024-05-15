@extends('admin.layouts.master')
@section('title','Edit Announcement')
@section('maincontent')

@component('components.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __('Admin') }}
@endslot

@slot('menu2')
{{ __(' Edit Announcement') }}
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
          <h5 class="box-title">{{ __('adminstaticword.Edit') }} {{ __('adminstaticword.Announcement') }}</h5>
        </div>
        <div class="card-body ml-2">
          <form id="demo-form" method="post" action="{{url('instructor/announcement/'.$announs->id)}}" data-parsley-validate class="form-horizontal form-label-left">
            {{ csrf_field() }}
            {{ method_field('PUT') }}


            <input type="hidden" name="instructor_id" class="form-control" value="{{ Auth::User()->id }}"  />
            
                 
            <div class="row">
              <div class="col-md-9">
                <label for="exampleInputTit1e">{{ __('adminstaticword.Announsment') }}:<span class="redstar">*</span></label>
                <textarea name="announsment" rows="3" class="form-control" placeholder="Enter Question">{{$announs->announsment}}</textarea>
              </div>
            
              <div class="col-md-3">
                <label for="exampleInputTit1e">{{ __('adminstaticword.Status') }}:</label>
                <input type="checkbox" id="cb77" class="custom_toggle" name="status"
                    {{ $announs->status == '1' ? 'checked' : '' }} />
                  
                  <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="cb77"></label>
                
                <input type="hidden" name="status" value="{{ $announs->status }}" id="jp">
              </div>
            </div> 
            <br>
              
            <div class="col-md-6">
              <div class="form-group">
                               <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i>
                                 Reset</button>
                               <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                                 Update</button>
                             </div>
             
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

