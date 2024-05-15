@extends('admin.layouts.master')
@section('title', 'Edit Facts Slider - Admin')
@section('maincontent')



	@component('components.breadcumb', ['fourthactive' => 'active'])
		@slot('heading')
			{{ __('Edit Facts Slider') }}
		@endslot
		@slot('menu1')
			{{ __('Front Settings') }}
		@endslot
		@slot('menu2')
			{{ __('Facts Slider') }}
		@endslot
		@slot('menu3')
			{{ __('Edit Facts Slider') }}
		@endslot

		@slot('button')
			<div class="col-md-4 col-lg-4">
				<div class="widgetbar">
					<a href="{{ url('facts') }}" class="btn btn-primary-rgba"><i
							class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
				</div>
			</div>
		@endslot
	@endcomponent

	<div class="contentbar">
		@if ($errors->any())
			<div class="alert alert-danger" role="alert">
				@foreach ($errors->all() as $error)
					<p>{{ $error }}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true" style="color:red;">&times;</span></button></p>
				@endforeach
			</div>

		@endif

		<div class="row">
			<div class="col-lg-12">
				<div class="card m-b-30">
					<div class="card-header">
						<h5 class="card-title">{{ __('Edit Facts Slider') }}</h5>
					</div>
					<div class="card-body">

						<form action="{{ route('facts.update', $show->id) }}" method="POST">
							{{ csrf_field() }}
							{{ method_field('PUT') }}


							<div class="row">
								<div class="form-group col-md-4">
									<label for="icon">{{ __('adminstaticword.Icon') }}:<sup class="redstar text-danger">*</sup></label>

									<div class="input-group">
										<input type="text" class="form-control iconvalue" name="icon" value="{{ $show->icon }}">
										<span class="input-group-append">
											<button type="button" class="btnicon btn btn-outline-secondary" role="iconpicker"></button>
										</span>
									</div>

								</div>
								<div class="form-group col-md-4">
									<label for="heading">{{ __('adminstaticword.en_Heading') }}:<sup class="redstar text-danger">*</sup></label>
									<input value="{{ $show->getTranslation('heading', 'en', false) }}" autofocus required name="heading_en"
										type="text" class="form-control" placeholder="Enter Facts Heading" />
								</div>
								{{-- ------- --}}
								<div class="form-group col-md-4">
									<label for="heading">{{ __('adminstaticword.ar_Heading') }}:<sup class="redstar text-danger">*</sup></label>
									<input value="{{ $show->getTranslation('heading', 'ar', false) }}" autofocus required name="heading_ar"
										type="text" class="form-control" placeholder="Enter Facts Heading" />
								</div>
								{{-- ------- --}}

								<div class="form-group col-md-4">
									<label for="sub_heading">{{ __('adminstaticword.en_SubHeading') }}:<sup
											class="redstar text-danger">*</sup></label>
									<input value="{{ $show->getTranslation('sub_heading', 'en', false) }}" autofocus required name="sub_heading_en"
										type="text" class="form-control" placeholder="Enter Facts Sub Heading" />
								</div>
								<div class="form-group col-md-4">
									<label for="sub_heading">{{ __('adminstaticword.ar_SubHeading') }}:<sup
											class="redstar text-danger">*</sup></label>
									<input value="{{ $show->getTranslation('sub_heading', 'ar', false) }}" autofocus required name="sub_heading_ar"
										type="text" class="form-control" placeholder="Enter Facts Sub Heading" />
								</div>
							</div>

							<div class="form-group">
								<button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __('Reset') }}</button>
								<button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
									{{ __('Update') }}</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>


@endsection
