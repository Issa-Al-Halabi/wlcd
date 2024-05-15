@extends('admin.layouts.master')
@section('title', 'Add States - Admin')
@section('maincontent')


@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
{{ __('Add States') }}
@endslot
@slot('menu1')
{{ __('Location') }}
@endslot
@slot('menu2')
{{ __('State') }}
@endslot
@slot('menu3')
{{ __('Add States') }}
@endslot
@slot('button')
<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
    <a href="{{url('admin/state')}}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>

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
          <h5 class="card-title"> {{ __('adminstaticword.Add') }} {{ __('adminstaticword.State') }}</h5>
        </div>
        <div class="card-body">

          <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/state')}}" data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
            <div class="row">
              <div class="form-group col-md-6">
                <label for="exampleInputTit1e">  {{ __('adminstaticword.Add') }} {{ __('adminstaticword.State') }}:<sup class="redstar">*</sup></label>
                <select class="select2-single form-control"name="country_id" required>
                  <option value="">{{ __('adminstaticword.ChooseCountry') }}:</option>

                      @foreach ($country as $c)
                        <option value="{{ $c->id }}">{{ $c->nicename }}</option>
                      @endforeach
                    </select>
              </select>
              </div>
              

            </div>
            <div class="form-group">
							<button type="reset" class="btn btn-danger mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
							<button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
							{{ __("Create")}}</button>
						</div>


          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

