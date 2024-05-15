@extends('admin.layouts.master')
@section('title', 'Widget Setting - Admin')
@section('maincontent')
@component('components.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Widget Setting') }}
@endslot
@slot('menu1')
{{ __('Front Settings') }}
@endslot
@slot('menu2')
{{ __('Widget Setting') }}
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
					<h5 class="card-title">{{ __('Widget Setting') }}</h5>
				</div>
				<div class="card-body">

					<form action="{{action('WidgetController@update')}}" method="POST">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<div class="row">
							<div class="update-password">
								<div class="form-group col-md-12">
									<label for="">{{ __('Enable Widget') }}: </label>
									<input class="custom_toggle" class="custom_toggle" type="checkbox" id="myCheck"
										name="widget_enable" {{ optional($show)->widget_enable == 1 ? 'checked' : '' }}
										onclick="myFunction()" />
								</div>
							</div>
						</div>
							<div style="{{$show->widget_enable == 0 ? 'display: none' : ''}}" id="update-password">
								<div class="row">
								<div class="form-group col-md-12">
									<label for="heading">{{ __('adminstaticword.WidgetOne') }}<sup
											class="redstar text-danger">*</sup></label>

									<input value="{{ $show ? $show->widget_one : '' }}" autofocus name="widget_one"
										type="text" class="form-control" placeholder="Enter widget" required />
								</div>
								<div class="form-group col-md-3">
									<label for="">{{ __('Enable About Us') }}: </label><br>
									<input id="status_toggle" class="custom_toggle" type="checkbox" id="widget_enable"
										name="about_enable" {{ optional($show)->about_enable == 1 ? 'checked' : '' }} />

								</div>
								<div class="form-group col-md-6">
									<label for="">{{ __('Enable Contact Us') }}: </label><br>
									<input id="status_toggle" class="custom_toggle" type="checkbox" id="widget_enable"
										name="contact_enable"
										{{ optional($show)->contact_enable == 1 ? 'checked' : '' }} />
								</div>
								<div class="form-group col-md-12">
									<label for="heading">{{ __('adminstaticword.WidgetTwo') }}<sup
											class="redstar text-danger">*</sup></label>
									<input value="{{ optional($show)->widget_two }}" autofocus name="widget_two"
										type="text" class="form-control" placeholder="Enter widget" required />

								</div>
								{{-- <div class="form-group col-md-3">
									<label for="">{{ __('Enable Career Us') }}: </label><br>
									<input id="status_toggle" class="custom_toggle" type="checkbox" id="widget_enable"
										name="career_enable"
										{{  optional($show)->career_enable == 1 ? 'checked' : '' }} />
								</div> --}}
								<div class="form-group col-md-3">
									<label for="">{{ __('Enable Blog') }}: </label><br>
									<input id="status_toggle" class="custom_toggle" type="checkbox" id="widget_enable"
										name="blog_enable" {{ optional($show)->blog_enable == 1 ? 'checked' : '' }} />


								</div>
								<div class="form-group col-md-3">
									<label for="">{{ __('Enable Help & Support') }}: </label><br>
									<input id="status_toggle" class="custom_toggle" type="checkbox" id="widget_enable"
										name="help_enable" {{ optional($show)->help_enable == 1 ? 'checked' : '' }} />

								</div>
								<div class="form-group col-md-12">
									<label for="heading">{{ __('adminstaticword.WidgetThree') }}<sup
											class="redstar">*</sup></label>
									<input value="{{ optional($show)->widget_three }}" autofocus name="widget_three"
										type="text" class="form-control" placeholder="Enter widget" required />
									</div>
								</div>
							</div>
							<div class="form-group">
							<button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i>
								{{ __("Reset")}}</button>
							<button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
								{{ __("Update")}}</button>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')

<script>

		"use strict";
		$(function () {
			$('#myCheck').change(function () {
				if ($('#myCheck').is(':checked')) {
					$('#update-password').show('fast');
				} else {
					$('#update-password').hide('fast');
				}
			});

		})(jQuery);
</script>
@endsection