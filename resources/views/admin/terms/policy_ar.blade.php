<div class="row">

	<div class="col-lg-12">
		@if ($errors->any())
			<div class="alert alert-danger" role="alert">
				@foreach ($errors->all() as $error)
					<p>{{ $error }}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true" style="color:red;">&times;</span></button></p>
				@endforeach
			</div>
		@endif
		<div class="card m-b-30">
			<!-- Card header will display you the heading -->
			<div class="card-header">
				<h5 class="card-box">{{ __('adminstaticword.PrivacyPolicy') }}</h5>
			</div>

			<div class="card-body">
				<form action="{{ action('TermsController@updatepolicy') }}" class="form" method="POST" novalidate
					enctype="multipart/form-data">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-body">
									<div class="row">

										<div class="col-md-12">
											<div class="row">
												
												<input type="hidden" name="lang" value="ar" id="lang">

												<div class="col-md-12">
													<div class="form-group">
														<label class="text-dark">{{ __('adminstaticword.PrivacyPolicy') }} : <span
																class="text-danger">*</span></label>
														<textarea id="detail" name="policy" class="@error('policy') is-invalid @enderror" required="">{{ $items->getTranslation('policy', 'ar', false) }}</textarea>
														@error('policy')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</div>
												</div>

												<!-- create and close button -->
												<div class="col-md-12">
													<div class="form-group">
														<button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i>
															{{ __('Reset') }}</button>
														<button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
															{{ __('Update') }}</button>
													</div>
												</div>

											</div>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- main content section ended -->

<!-- This section will contain javacsript start -->
@section('script')
@endsection
<!-- This section will contain javacsript end -->
