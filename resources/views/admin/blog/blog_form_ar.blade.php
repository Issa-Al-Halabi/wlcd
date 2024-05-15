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
					<h5 class="card-title">{{ __('Add Blog') }}</h5>
				</div>
				<div class="card-body">
					<form id="ar_create" action="{{ action('BlogController@store') }}" class="form" method="POST" novalidate
						enctype="multipart/form-data">
						@csrf
						<input type="hidden" class="form-control" name="user_id" value="{{ Auth::User()->id }}">
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<!-- card body start -->
									<div class="card-body">
										<!-- row start -->
										<div class="row">

											<div class="col-md-12">
												<!-- row start -->
												<div class="row">

													<!-- Heading -->
													<div class="col-md-6">
														<div class="form-group">
															<label class="text-dark">{{ __('adminstaticword.Heading') }} : <span class="text-danger">*</span></label>
															<input type="text" value="{{ old('heading') }}" autofocus=""
																class="form-control @error('heading') is-invalid @enderror"
																placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Heading') }}" name="heading"
																required="">
															@error('heading')
																<span class="invalid-feedback" role="alert">
																	<strong>{{ $message }}</strong>
																</span>
															@enderror
														</div>
													</div>

													<!-- Slug -->
													<div class="col-md-6">
														<div class="form-group">
															<label class="text-dark">{{ __('adminstaticword.Slug') }} : <span class="text-danger">*</span></label>
															<input type="text" pattern="[/^\S*$/]+" value="{{ old('slug') }}" autofocus=""
																class="form-control @error('slug') is-invalid @enderror"
																placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Slug') }}" name="slug"
																required="">
															@error('slug')
																<span class="invalid-feedback" role="alert">
																	<strong>{{ $message }}</strong>
																</span>
															@enderror
														</div>
													</div>


													<!-- Date -->
													<div class="col-md-6">
														<div class="form-group">
															<label class="text-dark">{{ __('adminstaticword.Date') }} : <span class="text-danger">*</span></label>
															<input type="date" class="form-control" name="date" id="inputDate"
																placeholder="{{ __('adminstaticword.Select') }} {{ __('adminstaticword.Date') }}" required>

															@error('date')
																<span class="invalid-feedback" role="alert">
																	<strong>{{ $message }}</strong>
																</span>
															@enderror
														</div>
													</div>

													<!-- Description -->
													<input type="hidden" name="detail" id="detail">

													<div class="col-md-12">
														<label class="text-dark">{{ __('adminstaticword.Detail') }}:
															<span class="text-danger">*</span></label>
														<div id="toolbar-container1"></div>
														<div class="form-group">
															<div name="detail" id="editor1" class="@error('detail') is-invalid @enderror">
																@if (old('detail'))
																{!! old('detail')  !!}
																@else
																{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Detail') }}
																@endif
															</div>
														</div>
														@error('detail')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</div>



													<!-- image -->

													@if (Auth::user()->role == 'admin')
														<div class="col-md-6">
															<label class="text-dark">{{ __('adminstaticword.Image') }}:<span
																	class="text-danger">*</span></label><br>
															<div class="input-group mb-3">
																<input type="text" class="form-control" readonly id="image1" name="image">
																<div class="input-group-append">
																	<span data-input="image1" class="midia-toggle1 btn-primary input-group-text"
																		id="basic-addon1">{{ __('Browse') }}</span>
																</div>
															</div>
														</div>
													@endif

													@if (Auth::user()->role == 'instructor')
														<div class="col-md-6">
															<label class="text-dark">{{ __('adminstaticword.Image') }}:<span
																	class="text-danger">*</span></label><br>
															<div class="input-group mb-3">
																<div class="input-group-prepend">
																	<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
																</div>
																<div class="custom-file">
																	<input type="file" class="custom-file-input" name="image" id="inputGroupFile01"
																		aria-describedby="inputGroupFileAddon01" required>
																	<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
																</div>
															</div>
													@endif

													<!-- Approved -->
													@if (Auth::user()->role == 'admin')
														<div class="form-group col-md-3">
															<label class="text-dark" for="exampleInputDetails">{{ __('adminstaticword.Approved') }} : <sup
																	class="redstar text-danger">*</sup></label><br>
															<input type="checkbox" class="custom_toggle" name="approved" checked />
															<input type="hidden" name="free" value="0" for="status" id="status">
														</div>

														<!-- status -->
														<div class="form-group col-md-3">
															<label class="text-dark" for="exampleInputDetails">{{ __('adminstaticword.Status') }} :</label><br>
															<input type="checkbox" class="custom_toggle" name="status" checked />
															<input type="hidden" name="free" value="0" for="status" id="status">
														</div>
													@endif

													<!-- create and close button -->
													<div class="col-md-12">
														<div class="form-group">
															<button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i>
																{{ __('Reset') }}</button>
															<button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
																{{ __('Create') }}</button>
														</div>
													</div>

												</div><!-- row end -->
											</div><!-- col end -->
										</div><!-- row end -->

									</div>
									<!-- card body end -->
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

{{-- <script>
	(function($) {
		"use strict";
		tinymce.init({
			selector: 'textarea'
		});
	})(jQuery);
</script> --}}

{{-- doc --}}
<script>
	DecoupledEditor
		.create(document.querySelector('#editor1'))
		.then(editor => {
			const toolbarContainer = document.querySelector('#toolbar-container1');
			toolbarContainer.appendChild(editor.ui.view.toolbar.element);
			class Base64UploadAdapter {
				constructor(loader) {
					this.loader = loader;
				}
				upload() {
					return this.loader.file
						.then(file => this.base64(file))
						.then(base64 => {
							return new Promise((resolve, reject) => {
								resolve({
									default: base64
								});
							});
						});
				}
				base64(file) {
					return new Promise((resolve, reject) => {
						const reader = new FileReader();
						reader.onloadend = () => resolve(reader.result);
						reader.onerror = reject;
						reader.readAsDataURL(file);
					});
				}
			}
			// Override createUploadAdapter to use the custom adapter
			editor.plugins.get('FileRepository').createUploadAdapter = loader => {
				return new Base64UploadAdapter(loader);
			};
			const form = document.querySelector('#ar_create');
			const editorContentInput = document.querySelector('#detail');

			form.addEventListener('submit', function(event) {
				editorContentInput.value = editor.getData();
			});
		})
		.catch(error => {
			console.error(error);
		});
</script>
