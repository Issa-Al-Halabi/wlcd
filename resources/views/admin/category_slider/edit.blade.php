@extends('admin.layouts.master')
@section('title', 'Category Slider- Admin')
@section('maincontent')
 

@component('components.breadcumb',['thirdactive' => 'active'])
@slot('heading')
   {{ __('Category Slider') }}
@endslot
@slot('menu1')
   {{ __('Front Settings') }}
@endslot
@slot('menu2')
   {{ __('Category Slider') }}
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
				<h5 class="card-title">{{ __('Category Slider') }}</h5>
			  </div>
			  <div class="card-body">
				<form action="{{ action('CategorySliderController@update') }}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
			
				
				<div class="row">
				  <div class="form-group col-md-6">
					<label for="heading">{{ __('adminstaticword.SelectCategory') }}</label>
					<select class="select2-multi-select form-control" name="category_id[]" multiple="multiple" size="3" required>
						@foreach ($category as $cat)
						@if($cat->status == 1)
						<option value="{{ $cat->id }}" {{in_array($cat->id, optional($category_slider)->category_id ?: []) ? "selected": ""}}>{{ $cat->title }}
						</option>
						@endif
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
  
