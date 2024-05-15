@extends('admin.layouts.master')
@section('title', 'Payout Setting - Admin')
@section('maincontent')
@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
   {{ __('Instructor Setting ') }}
@endslot
@slot('menu1')
{{ __('Instructor') }}
@endslot
@slot('menu2')
{{ __('Instructor Payout') }}
@endslot
@slot('menu3')
{{ __('Payout Setting') }}
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
          <h5 class="card-title">{{ __('Payout Setting') }}</h5>
        </div>
        <div class="card-body">
          
			<form action="{{ route('instructor.update') }}" method="POST">
				{{ csrf_field() }}
				{{ method_field('POST') }}
          <div class="row ">

			<div class="form-group col-md-6">
				<label for="Revenue">{{ __('Instructor Revenue') }}:</label>
			    <div class="input-group mb-3">
					<input  min="1" max="100" class="form-control" name="instructor_revenue" type="number" value="{{ optional($setting)->instructor_revenue }}" id="revenue"  placeholder="Enter revenue percentage" class="{{ $errors->has('instructor_revenue') ? ' is-invalid' : '' }} form-control">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">%</span>
					</div>
				</div>
			</div>
				
			<div class="form-group col-md-6">
			<label for="Revenue">{{ __('Admin Revenue') }}:</label>
			    <div class="input-group mb-3">
					<input min="1" max="100" class="form-control" name="admin_revenue" type="number" value="{{ 100 - optional($setting)->instructor_revenue }}" id="revenue"  placeholder="Enter revenue percentage" class="{{ $errors->has('admin_revenue') ? ' is-invalid' : '' }} form-control" readonly>
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">%</span>
					</div>
				</div>
			</div>
      <div class="form-group col-md-4">
            	<label for="">{{ __('adminstaticword.PaytmEnable') }}: </label><br>
              <input  class="custom_toggle"  type="checkbox" name="paytm_enable" {{ optional($setting)['paytm_enable'] == '1' ? 'checked' : '' }}  />
              <input type="hidden"  name="free" value="0" for="paytm" id="paytm">
                
              
            </div>
            <div class="form-group col-md-4">
				<label for="">{{ __('adminstaticword.PaypalEnable') }}: </label><br>
              <input  type="checkbox" class="custom_toggle" name="paypal_enable" {{ optional($setting)['paypal_enable'] == '1' ? 'checked' : '' }} />
			  <input type="hidden"  name="free" value="0" for="paypal" id="paypal">
            
            </div>
            <div class="form-group col-md-4">
				<label for="">{{ __('adminstaticword.BankTransferEnable') }}: </label><br>
              <input  type="checkbox" class="custom_toggle" name="bank_enable" {{ optional($setting)['bank_enable'] == '1' ? 'checked' : '' }}  />
			  <input type="hidden"  name="free" value="0" for="bank" id="bank">
            
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

