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
					<h5 class="card-title">{{ __('Edit Blog') }}</h5>
				</div>
				<div class="card-body">
					<!-- form start -->
					<form action="{{ route('blog.update', $show->id) }}" class="form" method="POST" novalidate
						enctype="multipart/form-data">
						{{ csrf_field() }}
						{{ method_field('PUT') }}
						<input type="hidden" name="lang" value="ar" id="lang">
						<!-- row start -->
						<div class="row">
							<div class="col-md-12">
								<!-- card start -->
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
															<label class="text-dark">{{ __('adminstaticword.Heading') }}
																: <span class="text-danger">*</span></label>
															<input type="text" value="{{ $show->getTranslation('heading', 'ar', false) }}" autofocus=""
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

													<!-- slug -->
													<div class="col-md-6">
														<div class="form-group">
															<label class="text-dark">{{ __('adminstaticword.Slug') }} :
																<span class="text-danger">*</span></label>
															<input type="text" pattern="[/^\S*$/]+" value="{{ $show->slug }}" autofocus=""
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

													<!-- ButtonText -->
													{{-- <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="text-dark">{{ __('adminstaticword.ButtonText') }} : <span class="text-danger">*</span></label>
                                                        <input type="text" value="{{ $show->text }}" autofocus="" class="form-control @error('title') is-invalid @enderror" placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.ButtonText') }}" name="text" required="">
                                                        @error('text')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div> --}}

													<!-- Date -->
													<div class="col-md-6">
														<div class="form-group">
															<label class="text-dark">{{ __('adminstaticword.Date') }} :
																<span class="text-danger">*</span></label>
															<input type="date" class="form-control" value="{{ $show->date }}" name="date" id="inputDate"
																placeholder="{{ __('adminstaticword.Select') }} {{ __('adminstaticword.Date') }}" required>

															@error('date')
																<span class="invalid-feedback" role="alert">
																	<strong>{{ $message }}</strong>
																</span>
															@enderror
														</div>
													</div>

													<!-- detail -->
													{{-- <div class="col-md-12">
														<div id="toolbar-container"></div>
														<div id="editor">
															<div class="form-group">
																<label class="text-dark">{{ __('adminstaticword.Detail') }}:
																	<span class="text-danger">*</span></label>
																<textarea name="detail" class="@error('detail') is-invalid @enderror"
																 placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Detail') }}" required="">{{ $show->getTranslation('detail', 'ar', false) }}</textarea>
																@error('detail')
																	<span class="invalid-feedback" role="alert">
																		<strong>{{ $message }}</strong>
																	</span>
																@enderror
															</div>
														</div>
													</div> --}}

                                                    <div class="col-md-12">
														<label class="text-dark">{{ __('adminstaticword.Detail') }}:
															<span class="text-danger">*</span></label>
														<div id="toolbar-container1"></div>
														<div class="form-group">
															<div name="detail" id="editor1" class="@error('detail') is-invalid @enderror">
																@if ($show->getTranslation('detail', 'ar', false))
																{{ $show->getTranslation('detail', 'ar', false) }}
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
													@if (Auth::user()->role == 'instructor')
														<div class="form-group col-md-6">
															<label class="text-dark">{{ __('adminstaticword.Image') }}:<span
																	class="text-danger">*</span></label><br>
															<div class="input-group mb-3">
																<div class="input-group-prepend">
																	<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
																</div>
																<div class="custom-file">
																	<input type="file" class="custom-file-input" id="inputGroupFile01" name="image"
																		aria-describedby="inputGroupFileAddon01">
																	<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
																</div>
															</div>
															<img src="{{ url('/images/blog/' . $show->image) }}" class="image_size" />
														</div>
													@endif

													@if (Auth::user()->role == 'admin')
														<div class="form-group">
															<label class="control-label" for="first-name">{{ __('Image') }} <span class="required">*</span>
															</label>

															<div class="input-group">

																<input required readonly id="image" name="image" type="text" class="form-control">
																<div class="input-group-append">
																	<span data-input="image"
																		class="bg-primary text-light midia-toggle input-group-text">{{ __('Browse') }}</span>
																</div>
															</div>

															<small class="text-info"> <i
																	class="text-dark feather icon-help-circle"></i>({{ __('Choose Image for blog
																																																																																																						                                                                                                            post') }})</small>
															<br>
															<img src=" {{ url('images/blog/' . $show->image) }}" class="pro-img" />
														</div>
													@endif


													@if (Auth::user()->role == 'admin')
														<!-- Approved -->
														<div class="form-group col-md-3">
															<label class="text-dark" for="exampleInputDetails">{{ __('adminstaticword.Approved') }}:<sup
																	class="redstar text-danger">*</sup></label><br>
															<input type="checkbox" class="custom_toggle"
																name="approved"{{ $show->approved == '1' ? 'checked' : '' }} />
															<input type="hidden" name="free" value="0" for="status" id="status">
														</div>

														<!-- status -->
														<div class="form-group col-md-3">
															<label class="text-dark" for="exampleInputDetails">{{ __('adminstaticword.Status') }}
																:</label><br>
															<input type="checkbox" class="custom_toggle" name="status"
																{{ $show->status == '1' ? 'checked' : '' }} />
															<input type="hidden" name="free" value="0" for="status" id="status">
														</div>
													@endif

													<!-- update and reset button -->
													<div class="col-md-12">
														<button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i>
															{{ __('Reset') }}</button>
														<button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
															{{ __('Update') }}</button>
													</div>

												</div><!-- row end -->
											</div><!-- col end -->
										</div><!-- row end -->

									</div><!-- card body end -->
								</div><!-- card end -->
							</div><!-- col end -->
						</div><!-- row end -->
					</form>
					<!-- form end -->
				</div><!-- card body end -->
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
		.create(document.querySelector('#editor'))
		.then(editor => {
			const toolbarContainer = document.querySelector('#toolbar-container');

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
		})
		.catch(error => {
			console.error(error);
		});
</script>
