@extends('admin.layouts.master')
@section('title', 'Edit Country - Admin')
@section('maincontent')


@component('components.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Edit Country') }}
@endslot
@slot('menu1')
{{ __('Country') }}
@endslot
@slot('menu2')
{{ __('Edit Country') }}

@slot('button')
<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
    <a href="{{url('admin/country')}}"  class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>

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
          <h5 class="card-title">{{ __('adminstaticword.Edit') }} {{ __('adminstaticword.Country') }}</h5>
        </div>
        <div class="card-body">

          <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/country/'.$countries->id)}}" data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
            {{ method_field('PUT') }}
            <div class="row">
              <div class="form-group col-md-6">
                <label class="control-label" for="first-name">  {{ __("Country Name")}} <span class="redstar">*</span></label>
                   <select class="select2-single form-control" name="country">
                  <option>{{ __("Choose Country:")}}</option>

                @foreach ($allcountry as $c)
                  <option value="{{ $c->id }}" {{ $countries->country_id == $c->id ? 'selected' : ''}}>{{ $c->nicename }}
                  </option>
                @endforeach
              </select>
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

