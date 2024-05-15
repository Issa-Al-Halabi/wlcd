@extends('admin/layouts.master')
@section('title', 'Add Testimonial - Admin')
@section('maincontent')
@component('components.breadcumb', ['fourthactive' => 'active'])
		@slot('heading')
			{{ __('Add Testimonial') }}
		@endslot
		@slot('menu1')
			{{ __('Front Settings') }}
		@endslot
		@slot('menu2')
			{{ __('Testimonial') }}
		@endslot

		@slot('button')
			<div class="col-md-4 col-lg-4">
				<div class="widgetbar">
					<a href="{{ url('testimonial') }}" class="btn btn-primary-rgba"><i
							class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>

				</div>
			</div>
		@endslot
	@endcomponent
	<div class="contentbar">
		<div class="row">
			<div class="col-md-12">
				<div class="card m-b-30">
					<div class="card-header">
						<div class="row">
							<div class="col-md-6">
								<h5 class="card-box">{{ __('testimonial') }}</h5>
							</div>
						</div>
					</div>
					<div class="card-body">
						<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
									aria-controls="pills-home" aria-selected="true">{{ __('English') }}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
									aria-controls="pills-profile" aria-selected="false">{{ __('Arabic') }}</a>
							</li>
						</ul>
						<div class="tab-content" id="pills-tabContent">
							<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
								@include('admin.testimonial.testi_form')
							</div>
							<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
								@include('admin.testimonial.testi_form_ar')
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
