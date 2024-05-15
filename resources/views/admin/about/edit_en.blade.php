<div class="row">
	@if ($errors->any())
		<div class="alert alert-danger" role="alert">
			@foreach ($errors->all() as $error)
				<p>{{ $error }}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true" style="color:red;">&times;</span></button></p>
			@endforeach
		</div>
	@endif

	<!-- row started -->
	<div class="col-lg-12">

		<div class="card m-b-30">

			<!-- Card header will display you the heading -->
			<div class="card-header">
				<h5 class="card-box">{{ __('About') }}</h5>
			</div>

			<!-- card body started -->
			<div class="card-body">
				<!-- form start -->
				<form action="{{ action('AboutController@update') }}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					<input type="hidden" name="lang" value="en" id="lang">

					<div class="row">
						<div class="col-md-12">
							<label class="text-dark" for="about_description">{{ __('About Text :') }} <span
									class="text-danger">*</span></label>
							<textarea required name="about_description" rows="3" class="form-control" placeholder="Enter Your Text">{{ $data->getTranslation('about_description', 'en', false) }}</textarea>
							<br>
						</div>
					</div>

					<!-- section 1 start -->
					<div class="row">
						<h5>{{ __('First section :') }}</h5>
						<br> <br>
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-6">
									<label class="text-dark" for="one_heading">{{ __('Section 1 Heading :') }} <span
											class="text-danger">*</span></label>
									<textarea required name="one_heading" rows="3" class="form-control" placeholder="Enter Your Text">{{ $data->getTranslation('one_heading', 'en', false) }}</textarea>
									<br>
								</div>

								<div class="col-md-6">
									<label class="text-dark" for="one_text">{{ __('Section 1 Text :') }} <span
											class="text-danger">*</span></label>
									<textarea required name="one_text" rows="3" class="form-control" placeholder="Enter Your Text">{{ $data->getTranslation('one_text', 'en', false) }}</textarea>
									<br>
								</div>
							</div>
							<div class="row">

								<div class="col-md-4">
									<label class="text-dark">{{ __('section 1 first Image :') }}<span class="text-danger">*</span></label><br>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
										</div>
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="inputGroupFile01" name="one_first_image"
												aria-describedby="inputGroupFileAddon01">
											<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
										</div>
									</div>
									@if ($image = @file_get_contents('../public/images/about/' . $data['one_first_image']))
										<img src="{{ url('/images/about/' . $data['one_first_image']) }}" class="image_size" />
									@endif
								</div>

								<div class="col-md-4">

									<label class="text-dark">{{ __('section 1 second Image :') }}<span class="text-danger">*</span></label><br>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
										</div>
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="inputGroupFile01" name="one_second_image"
												aria-describedby="inputGroupFileAddon01">
											<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
										</div>
									</div>
									@if ($image = @file_get_contents('../public/images/about/' . $data['one_second_image']))
										<img src="{{ url('/images/about/' . $data['one_second_image']) }}" class="image_size" />
									@endif
									<br><br>
								</div>

								<div class="col-md-4">
									<label class="text-dark">{{ __('section 1 third Image :') }}<span class="text-danger">*</span></label><br>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
										</div>
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="inputGroupFile01" name="one_third_image"
												aria-describedby="inputGroupFileAddon01">
											<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
										</div>
									</div>
									@if ($image = @file_get_contents('../public/images/about/' . $data['one_third_image']))
										<img src="{{ url('/images/about/' . $data['one_third_image']) }}" class="image_size" />
									@endif

									<br><br>
								</div>
							</div>
						</div>
					</div>
					<br>
					<hr>
					<!-- section 1 end -->
					<!-- section 2 start -->

					<div class="row">
						<h5>{{ __('Second Section :') }}</h5>
						<br> <br>
						<div class="col-md-12">

							<div class="row">
								<div class="col-md-6">
									<label class="text-dark" for="two_heading">{{ __('Section 2 Heading :') }} <span
											class="text-danger">*</span></label>
									<textarea required name="two_heading" rows="3" class="form-control" placeholder="Enter Your Text">{{ $data->getTranslation('two_heading', 'en', false) }}</textarea>
									<br>
								</div>

								<div class="col-md-6">
									<label class="text-dark" for="two_text">{{ __('Section 2 Text :') }} <span
											class="text-danger">*</span></label>
									<textarea required name="two_text" rows="3" class="form-control" placeholder="Enter Your Text">{{ $data->getTranslation('two_text', 'en', false) }}</textarea>
									<br>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<label class="text-dark" for="two_first_title">{{ __('Section 2 first title:') }} <span
											class="text-danger">*</span></label>
									<textarea required name="two_first_title" rows="3" class="form-control" placeholder="Enter Your Text">{{ $data->getTranslation('two_first_title', 'en', false) }}</textarea>
									<br>
								</div>

								<div class="col-md-4">
									<label class="text-dark" for="two_second_title">{{ __('Section 2 secont title :') }} <span
											class="text-danger">*</span></label>
									<textarea required name="two_second_title" rows="3" class="form-control" placeholder="Enter Your Text">{{ $data->getTranslation('two_second_title', 'en', false) }}</textarea>
									<br>
								</div>

								<div class="col-md-4">
									<label class="text-dark" for="two_third_title">{{ __('Section 2 third title :') }} <span
											class="text-danger">*</span></label>
									<textarea required name="two_third_title" rows="3" class="form-control" placeholder="Enter Your Text">{{ $data->getTranslation('two_third_title', 'en', false) }}</textarea>
									<br>
								</div>
							</div>

							<div class="row">
								<div class="col-md-4">
									<label class="text-dark" for="two_first_text">{{ __('Section 2 first text:') }} <span
											class="text-danger">*</span></label>
									<textarea required name="two_first_text" rows="3" class="form-control" placeholder="Enter Your Text">{{ $data->getTranslation('two_first_text', 'en', false) }}</textarea>
									<br>
								</div>

								<div class="col-md-4">
									<label class="text-dark" for="two_second_text">{{ __('Section 2 secont text :') }} <span
											class="text-danger">*</span></label>
									<textarea required name="two_second_text" rows="3" class="form-control" placeholder="Enter Your Text">{{ $data->getTranslation('two_second_text', 'en', false) }}</textarea>
									<br>
								</div>

								<div class="col-md-4">
									<label class="text-dark" for="two_third_text">{{ __('Section 2 third text :') }} <span
											class="text-danger">*</span></label>
									<textarea required name="two_third_text" rows="3" class="form-control" placeholder="Enter Your Text">{{ $data->getTranslation('two_third_text', 'en', false) }}</textarea>
									<br>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<label class="text-dark">{{ __('section 2 first Image :') }}<span class="text-danger">*</span></label><br>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
										</div>
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="inputGroupFile01" name="two_first_image"
												aria-describedby="inputGroupFileAddon01">
											<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
										</div>
									</div>
									@if ($image = @file_get_contents('../public/images/about/' . $data['two_first_image']))
										<img src="{{ url('/images/about/' . $data['two_first_image']) }}" class="image_size" />
									@endif
								</div>

								<div class="col-md-4">

									<label class="text-dark">{{ __('section 2 second Image :') }}<span class="text-danger">*</span></label><br>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
										</div>
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="inputGroupFile01" name="two_second_image"
												aria-describedby="inputGroupFileAddon01">
											<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
										</div>
									</div>
									@if ($image = @file_get_contents('../public/images/about/' . $data['two_second_image']))
										<img src="{{ url('/images/about/' . $data['two_second_image']) }}" class="image_size" />
									@endif
									<br><br>
								</div>

								<div class="col-md-4">
									<label class="text-dark">{{ __('section 2 third Image :') }}<span class="text-danger">*</span></label><br>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
										</div>
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="inputGroupFile01" name="two_third_image"
												aria-describedby="inputGroupFileAddon01">
											<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
										</div>
									</div>
									@if ($image = @file_get_contents('../public/images/about/' . $data['two_third_image']))
										<img src="{{ url('/images/about/' . $data['two_third_image']) }}" class="image_size" />
									@endif

									<br><br>
								</div>
							</div>
						</div>
					</div>
					<br>
					<hr>

					<!-- section 2 end -->

					<!-- section 3 start -->
					<div class="row">
						<h5>{{ __('Third Section :') }}</h5>
						<br> <br>
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-6">
									<label class="text-dark" for="three_first_heading">{{ __('Section 3 first Heading :') }} <span
											class="text-danger">*</span></label>
									<textarea required name="three_first_heading" rows="3" class="form-control" placeholder="Enter Your Text">{{ $data->getTranslation('three_first_heading', 'en', false) }}</textarea>

								</div>
								<div class="col-md-6">
									<label class="text-dark" for="three_second_heading">{{ __('Section 3 second Heading :') }} <span
											class="text-danger">*</span></label>
									<textarea required name="three_second_heading" rows="3" class="form-control" placeholder="Enter Your Text">{{ $data->getTranslation('three_second_heading', 'en', false) }}</textarea>
									<br>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-6">

									<label class="text-dark" for="three_first_text">{{ __('Section 3 first text :') }} <span
											class="text-danger">*</span></label>
									<textarea required name="three_first_text" rows="3" class="form-control" placeholder="Enter Your Text">{{ $data->getTranslation('three_first_text', 'en', false) }}</textarea>
								</div>

								<div class="col-md-6">
									<label class="text-dark" for="three_second_text">{{ __('Section 3 second text :') }} <span
											class="text-danger">*</span></label>
									<textarea required name="three_second_text" rows="3" class="form-control" placeholder="Enter Your Text">{{ $data->getTranslation('three_second_text', 'en', false) }}</textarea>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-6">
									<label class="text-dark">{{ __('section 3 first Image :') }}<span class="text-danger">*</span></label><br>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
										</div>
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="inputGroupFile01" name="three_first_image"
												aria-describedby="inputGroupFileAddon01">
											<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
										</div>
									</div>
									@if ($image = @file_get_contents('../public/images/about/' . $data['three_first_image']))
										<img src="{{ url('/images/about/' . $data['three_first_image']) }}" class="image_size" />
									@endif
								</div>

								<div class="col-md-6">
									<label class="text-dark">{{ __('section 3 second Image :') }}<span class="text-danger">*</span></label><br>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
										</div>
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="inputGroupFile01" name="three_second_image"
												aria-describedby="inputGroupFileAddon01">
											<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
										</div>
									</div>
									@if ($image = @file_get_contents('../public/images/about/' . $data['three_second_image']))
										<img src="{{ url('/images/about/' . $data['three_second_image']) }}" class="image_size" />
									@endif
								</div>
							</div>
							<br>
							{{-- <div class="row">
								<div class="col-md-6">
									<label class="text-dark" for="three_third_text">{{ __('Section 3 third text :') }} <span
											class="text-danger">*</span></label>
									<input required value="{{ $data->getTranslation('three_third_text', 'en', false) }}" name="three_third_text"
										type="text" class="form-control" placeholder="Enter Count Text" />
								</div>

								<div class="col-md-6">
									<label class="text-dark" for="three_fourth_text">{{ __('Section 3 fourth text :') }} <span
											class="text-danger">*</span></label>
									<input required value="{{ $data->getTranslation('three_fourth_text', 'en', false) }}"
										name="three_fourth_text" type="text" class="form-control" placeholder="Enter Count Text" />
								</div>
							</div> --}}
						</div>
					</div>
					<br>
					<hr>
					<br>
					<!-- section 3 end -->
					<!-- section 4 start -->
					<div class="row">
						<h5>{{ __('Social media section :') }}</h5>
						<br> <br>
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-6">
									<label class="text-dark" for="facebook_link">{{ __('facebook link') }} : <span
											class="text-danger">*</span></label>
									<input value="{{ $data['facebook_link'] }}" autofocus name="facebook_link" type="text"
										class="form-control" placeholder="Enter link" />
								</div>

								<div class="col-md-6">
									<label class="text-dark" for="twitter_link">{{ __('Twitter link') }} : <span
											class="text-danger">*</span></label>
									<input value="{{ $data['twitter_link'] }}" autofocus name="twitter_link" type="text"
										class="form-control" placeholder="Enter link" />
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-6">
									<label class="text-dark" for="instagram_link">{{ __('Instagram link') }} : <span
											class="text-danger">*</span></label>
									<input value="{{ $data['instagram_link'] }}" autofocus name="instagram_link" type="text"
										class="form-control" placeholder="Enter link" />
								</div>

								<div class="col-md-6">
									<label class="text-dark" for="linkedin_link">{{ __('Linkedin link') }} : <span
											class="text-danger">*</span></label>
									<input value="{{ $data['linkedin_link'] }}" autofocus name="linkedin_link" type="text"
										class="form-control" placeholder="Enter link" />
								</div>
							</div>

							<br>
						</div>
					</div>

					<div class="form-group">
						<button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i>
							{{ __('Reset') }}</button>
						<button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
							{{ __('Update') }}</button>
					</div>
					<!-- section 4 end -->

				</form>
				<!-- form end -->
			</div>
			<!-- card body end -->
		</div>
	</div>
</div>

<!-- main content section ended -->
<!-- This section will contain javacsript start -->
{{-- @section('script')
	<script>
		(function($) {
			"use strict";

			$(function() {

				$('#customSwitch1').change(function() {
					if ($('#customSwitch1').is(':checked')) {
						$('#sec_one').show('fast');
					} else {
						$('#sec_one').hide('fast');
					}

				});

				$('#customSwitch2').change(function() {
					if ($('#customSwitch2').is(':checked')) {
						$('#sec_two').show('fast');
					} else {
						$('#sec_two').hide('fast');
					}

				});

				$('#customSwitch3').change(function() {
					if ($('#customSwitch3').is(':checked')) {
						$('#sec_three').show('fast');
					} else {
						$('#sec_three').hide('fast');
					}

				});

				$('#customSwitch4').change(function() {
					if ($('#customSwitch4').is(':checked')) {
						$('#sec_four').show('fast');
					} else {
						$('#sec_four').hide('fast');
					}

				});

				$('#customSwitch5').change(function() {
					if ($('#customSwitch5').is(':checked')) {
						$('#sec_five').show('fast');
					} else {
						$('#sec_five').hide('fast');
					}

				});

				$('#customSwitch6').change(function() {
					if ($('#customSwitch6').is(':checked')) {
						$('#sec_six').show('fast');
					} else {
						$('#sec_six').hide('fast');
					}

				});

			});
		})(jQuery);
	</script>
	<style>
		.image_size {
			height: 80px;
			width: 200px;
		}
	</style>
@endsection --}}
<!-- This section will contain javacsript end -->
