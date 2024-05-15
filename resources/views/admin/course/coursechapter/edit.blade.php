@extends('admin.layouts.master')
@section('title', 'Edit Coursechapter')
@section('maincontent')

	@component('components.breadcumb', ['thirdactive' => 'active'])
		@slot('heading')
			{{ __('Home') }}
		@endslot

		@slot('menu1')
			{{ __('Admin') }}
		@endslot

		@slot('menu2')
			{{ __('Edit Course Chapter') }}
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
						<h5 class="card-title">{{ __('adminstaticword.Edit') }} {{ __('Course Chapter') }}</h5>
					</div>
					<div class="card-body ml-2">
						<form id="demo-form" method="post" action="{{ url('coursechapter/' . $cate->id) }}"data-parsley-validate
							class="form-horizontal form-label-left" enctype="multipart/form-data">
							{{ csrf_field() }}
							{{ method_field('PUT') }}
							<div class="d-none">

								<label class="display-none" for="exampleInputSlug">{{ __('adminstaticword.SelectCourse') }}</label>
								<select name="course_id" class="form-control select2">
									@foreach ($courses as $cou)
										<option value="{{ $cou->id }}" {{ $cate->courses->id == $cou->id ? 'selected' : '' }}>
											{{ $cou->title }}</option>
									@endforeach
								</select>
							</div>

							<div class="row">
								<div class="col-md-6">
									<label for="chapter_name_en">{{ __('adminstaticword.English ChapterName') }} :<span class="redstar">*</span></label>
									<input required type="" class="form-control" name="chapter_name_en" id="exampleInputTitle"
										value="{{ $cate->getTranslation('chapter_name', 'en', false) }}">
									<br>
								</div>
								<div class="col-md-6">
									<label for="chapter_name_ar">{{ __('adminstaticword.Arabic ChapterName') }} :<span class="redstar">*</span></label>
									<input required type="" class="form-control" name="chapter_name_ar" id="exampleInputTitle"
										value="{{ $cate->getTranslation('chapter_name', 'ar', false) }}">
									<br>
								</div>

								<div class="col-md-6">
									<label for="exampleInputDetails">{{ __('adminstaticword.LearningMaterial') }} :</label>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text" id="file">{{ __('Upload') }}</span>
										</div>
										<div class="custom-file">
											<input name="file" type="file" class="custom-file-input" id="inputGroupFile01"
												aria-describedby="inputGroupFileAddon01">
											<label class="custom-file-label" for="inputGroupFile01">
												@if (isset($cate->file))
													{{ $cate->file }}
												@else
													{{ __('Choose file') }}
												@endif
											</label>
										</div>
									</div>
								</div>

							</div>
							<br>
							<div class="row">

								@if ($cate->courses->drip_enable == 1)
									<div class="col-md-2">
										<label for="exampleInputTit1e">{{ __('adminstaticword.Status') }} :</label><br>
										<label class="switch">
											<input class="slider" type="checkbox" name="status" {{ $cate->status == '1' ? 'checked' : '' }} />
											<span class="knob"></span>
										</label>
									</div>
									<div class="col-md-10">
										<label for="married_status">{{ __('Drip Content Type') }}: </label>
										<select class="form-control js-example-basic-single" id="drip_type" name="drip_type">
											<option value="" selected hidden>
												{{ __('Select an Option ') }}
											</option>
											<option value="none" {{ $cate->drip_type != 'date' && $cate->drip_type != 'days' ? 'selected' : '' }}>
												{{ __('None') }}</option>
											<option value="date" {{ $cate->drip_type == 'date' ? 'selected' : '' }}>{{ __('Specific Date') }}</option>
											<option value="days" {{ $cate->drip_type == 'days' ? 'selected' : '' }}>{{ __('Days After Enrollment') }}
											</option>
										</select>
										<br>
									</div>

									<div class="col-md-6" @if ($cate->drip_type == 'days' || $cate->drip_type == null) style="display: none;" @endif id="dripdate">
										<label>{{ __('Specific Date') }} :</label>


										<div class="input-group" id='datetimepicker1'>
											<input type="text" name="drip_date" id="time-format" class="form-control"
												placeholder="dd/mm/yyyy - hh:ii aa" aria-describedby="basic-addon5" value="{{ $cate->drip_date }}" />
											<div class="input-group-append">
												<span class="input-group-text" id="basic-addon5"><i class="feather icon-calendar"></i></span>
											</div>
										</div>

									</div>

									<div class="col-md-6" @if ($cate->drip_type == 'date' || $cate->drip_type == null) style="display: none;" @endif id="dripdays">
										<label>{{ __('Days After Enrollment') }} :</label>
										<input type="number" min="1" class="form-control" name="drip_days" value="{{ $cate->drip_days }}">
										<small class="text-muted"><i class="fa fa-question-circle"></i> {{ __('Enter days') }}.</small>
									</div>
							</div>
							@endif
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
@section('script')


	<script>
		$('#drip_type').change(function() {

			if ($(this).val() == 'date') {
				$('#dripdate').show();
				$("input[name='drip_date']").attr('required', 'required');
			} else {
				$('#dripdate').hide();
			}

			if ($(this).val() == 'days') {
				$('#dripdays').show();
				$("input[name='drip_days']").attr('required', 'required');
			} else {
				$('#dripdays').hide();
			}


		});
	</script>


@endsection
