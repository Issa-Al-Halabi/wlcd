@extends('admin.layouts.master')
@section('title', 'Edit Whatlearn')
@section('maincontent')

	@component('components.breadcumb', ['thirdactive' => 'active'])
		@slot('heading')
			{{ __('Home') }}
		@endslot

		@slot('menu1')
			{{ __('Admin') }}
		@endslot

		@slot('menu2')
			{{ __('Edit What Learn') }}
		@endslot

		@slot('button')
			<div class="col-md-4 col-lg-4">
				<a href="{{ url('course/create/' . $cate->courses->id) }}" class="float-right btn btn-primary-rgba"><i
						class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
			</div>
		@endslot
	@endcomponent
	@if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	<div class="contentbar">
		<div class="row">
			<div class="col-lg-12">
				<div class="card m-b-30">
					<div class="card-header">
						<h5 class="card-title">{{ __('adminstaticword.Edit') }} {{ __('What Learn') }}</h5>
					</div>
					<div class="card-body ml-2">
						<form id="demo-form" method="post" action="{{ url('whatlearns/' . $cate->id) }}" data-parsley-validate
							class="form-horizontal form-label-left">
							{{ csrf_field() }}
							{{ method_field('PUT') }}
							<div class="col-md-12">
								<div class="d-none">

									<label class="d-none" for="exampleInputSlug">{{ __('adminstaticword.SelectCourse') }}</label>
									<select name="course_id" class="form-control select2 d-none">

										@foreach ($courses as $cou)
											<option class="display-none"
												value="{{ $cou->id }}"{{ $cate->courses->id == $cou->id ? 'selected' : '' }}>{{ $cou->title }}
											</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-12">
								<label for="exampleInputDetails">{{ __('adminstaticword.English Detail') }}:<sup class="redstar">*</sup></label>
								<textarea required name="detail_en" class="form-control">{!! $cate->getTranslation('detail', 'en', false) !!}</textarea>
							</div>
							<br>
							<div class="col-md-12">
								<label for="exampleInputDetails">{{ __('adminstaticword.Arabic Detail') }}:<sup class="redstar">*</sup></label>
								<textarea required name="detail_ar" class="form-control">{!! $cate->getTranslation('detail', 'ar', false) !!}</textarea>
							</div>
							<br>
							<div class="col-md-12">
								<label for="exampleInputTit1e">{{ __('adminstaticword.Status') }}:</label><br>
								<label class="switch">
									<input class="slider" type="checkbox" name="status" {{ $cate->status == '1' ? 'checked' : '' }} />
									<span class="knob"></span>
								</label>
							</div>

							<br>

							<div class="form-group">
								<button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i>
									{{ __('Reset') }}</button>
								<button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
									{{ __('Update') }}</button>
							</div>
							<div class="clear-both"></div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
