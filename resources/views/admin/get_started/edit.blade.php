@extends('admin.layouts.master')
@section('title', 'Get Started - Admin')
@section('maincontent')
 

@component('components.breadcumb',['thirdactive' => 'active'])
@slot('heading')
   {{ __('Get Started') }}
@endslot
@slot('menu1')
   {{ __('Front Settings') }}
@endslot
@slot('menu2')
   {{ __('Get Started') }}
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
			<h5 class="card-title">{{ __('Get Started') }}</h5>
		  </div>
		  <div class="card-body">
			<form action="{{ action('GetstartedController@update') }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				{{ method_field('PUT') }}
		
			
			<div class="row">
			  <div class="form-group col-md-6">
				<label for="heading">{{ __('adminstaticword.Heading') }}</label>
				<input value="{{ optional($show)['heading'] }}" autofocus name="heading" type="text" class="form-control" placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Heading') }}"/>
			</div>
			  <div class="form-group col-md-6">
				<label for="sub_heading">{{ __('adminstaticword.SubHeading') }}</label>
				<input value="{{ optional($show)['sub_heading'] }}" autofocus name="sub_heading" type="text" class="form-control" placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.SubHeading') }}"/>
			</div>
			  <div class="form-group col-md-6">
				<label for="button_txt">{{ __('adminstaticword.ButtonText') }}</label>
				<input value="{{ optional($show)['button_txt'] }}" autofocus name="button_txt" type="text" class="form-control" placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.ButtonText') }}"/>
			</div>
			  <div class="form-group col-md-6">
				<label for="button_txt">{{ __('adminstaticword.ButtonLink') }}</label>
				<input value="{{ optional($show)['link'] }}" name="link" type="text" class="form-control" placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.ButtonLink') }}"/>
			</div>
			  <div class="form-group col-md-6">
				  
				<label for="image">{{ __('adminstaticword.BackgroundImage') }}<sup class="redstar text-danger">*</sup></label><br>
				<div class="input-group mb-3">
					<div class="input-group-prepend">
					  <span class="input-group-text" id="inputGroupFileAddon01">{{ __("Upload")}}</span>
					</div>
					<div class="custom-file">
					  <input type="file" name="image" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
					  <label class="custom-file-label" for="inputGroupFile01">{{ __("Choose file")}}</label>
					</div>
				  </div>
				  
				  
				
				<img src="{{ url('/images/getstarted/'.optional($show)['image']) }}" class="img-responsive image_size"/>
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
	



