<div>
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
					<h5 class="card-title">{{ __('Add Testimonial') }}</h5>
				</div>
				<div class="card-body">
					<form id="demo-form2" method="post" action="{{ url('testimonial/') }}" data-parsley-validate
						class="form-horizontal form-label-left" enctype="multipart/form-data">
						{{ csrf_field() }}
						<div class="row">

							<input type="hidden" name="lang" value="en" id="lang">

							<div class="form-group col-md-6">
								<label for="exampleInputTit1e">{{ __('adminstaticword.Name') }}:<sup class="text-danger">*</sup></label>
								<input type="text" class="form-control" name="client_name" id="exampleInputTitle"
									placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Name') }}" value="">
							</div>
							<div class="form-group col-md-6">
								<label for="exampleInputSlug">{{ __('adminstaticword.Image') }}:<sup class="text-danger">*</sup></label><br>
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
									</div>
									<div class="custom-file">
										<input type="file" name="image" class="custom-file-input" id="inputGroupFile01"
											aria-describedby="inputGroupFileAddon01">
										<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
									</div>
								</div>
							</div>
							<div class="form-group col-md-12">
								<label for="exampleInputDetails">{{ __('adminstaticword.Detail') }}:<sup class=" text-danger">*</sup></label>
								<textarea name="details" rows="3" class="form-control"
								 placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Detail') }}">{{ old('details') }}</textarea>
							</div>
							<div class="col-md-12">
								<div class="form-group{{ $errors->has('rating') ? ' has-error' : '' }}">
									<label for="exampleInputSlug">{{ __('Rating') }}</label>

									<div class="col-md-12">
										<div class="rating">
											<label>
												<input type="radio" name="rating" value="1" />
												<span class="icon"><i class="fa fa-star" style='color:orange' aria-hidden="true"></i></span>
											</label>
											<label>
												<input type="radio" name="rating" value="2" />
												<span class="icon"><i class="fa fa-star" style='color:orange' aria-hidden="true"></i></span>
												<span class="icon"><i class="fa fa-star" style='color:orange' aria-hidden="true"></i></span>
											</label>
											<label>
												<input type="radio" name="rating" value="3" />
												<span class="icon"><i class="fa fa-star" style='color:orange' aria-hidden="true"></i></span>
												<span class="icon"><i class="fa fa-star" style='color:orange' aria-hidden="true"></i></span>
												<span class="icon"><i class="fa fa-star" style='color:orange' aria-hidden="true"></i></span>
											</label>
											<label>
												<input type="radio" name="rating" value="4" />
												<span class="icon"><i class="fa fa-star" style='color:orange' aria-hidden="true"></i></span>
												<span class="icon"><i class="fa fa-star" style='color:orange' aria-hidden="true"></i></span>
												<span class="icon"><i class="fa fa-star" style='color:orange' aria-hidden="true"></i></span>
												<span class="icon"><i class="fa fa-star" style='color:orange' aria-hidden="true"></i></span>
											</label>
											<label>
												<input type="radio" name="rating" value="5" />
												<span class="icon"><i class="fa fa-star" style='color:orange' aria-hidden="true"></i></span>
												<span class="icon"><i class="fa fa-star" style='color:orange' aria-hidden="true"></i></span>
												<span class="icon"><i class="fa fa-star" style='color:orange' aria-hidden="true"></i></span>
												<span class="icon"><i class="fa fa-star" style='color:orange' aria-hidden="true"></i></span>
												<span class="icon"><i class="fa fa-star" style='color:orange' aria-hidden="true"></i></span>
											</label>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group col-md-6">
								<label for="exampleInputTit1e">{{ __('Designation') }}:<sup class="text-danger">*</sup></label>
								<input type="text" class="form-control" name="designation" id="exampleInputTitle"
									placeholder="{{ __('adminstaticword.Enter') }} {{ __('Designation') }}" value="">
							</div>
							<div class="form-group col-md-12">
								<label for="exampleInputDetails" class="mr-3">{{ __('adminstaticword.Status') }}:</label>
								<input id="status_toggle" type="checkbox" class="custom_toggle" name="status" checked />
								<input type="hidden" name="free" value="0" for="status" id="status">
							</div>
						</div>
						<div class="form-group">
							<button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i>
								{{ __('Reset') }}</button>
							<button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
								{{ __('Create') }}</button>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	(function($) {
		"use strict";
		tinymce.init({
			selector: 'textarea'
		});
	})(jQuery);
</script>
