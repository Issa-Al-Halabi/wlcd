@extends('admin.layouts.master')
@section('title', 'Edit Blog - Admin')
@section('maincontent')
	@component('components.breadcumb', ['fourthactive' => 'active'])
		@slot('heading')
			{{ __('Update Blog') }}
		@endslot
		@slot('menu1')
			{{ __('Update Blog') }}
		@endslot
		@slot('button')
			<div class="col-md-4 col-lg-4">
				<div class="widgetbar">
					<a href="{{ url('blog') }}" class="btn btn-primary-rgba"><i
							class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
				</div>
			</div>
		@endslot
	@endcomponent
	<div class="contentbar">
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
						<h5 class="card-box"> {{ __('adminstaticword.UpdateBlog') }}</h5>
					</div>

					<!-- card body started -->
					<div class="card-body">
						<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
							<li class="nav-item">
								<a @if ($show->getTranslation('heading', 'en', false) != null) class="nav-link active"
								@else
								class="nav-link" @endif
									id="pills-home1-tab" data-toggle="pill" href="#pills-home1" role="tab" aria-controls="pills-home"
									aria-selected="true">{{ __('English') }}</a>
							</li>
							<li class="nav-item">
								<a @if ($show->getTranslation('heading', 'en', false) != null) class="nav-link"
									@else
									class="nav-link active" @endif
									id="pills-profile1-tab" data-toggle="pill" href="#pills-profile1" role="tab" aria-controls="pills-profile"
									aria-selected="false">{{ __('Arabic') }}</a>
							</li>
						</ul>
						<div class="tab-content" id="pills-tabContent">
							<div
								@if ($show->getTranslation('heading', 'en', false) != null) class="tab-pane fade show active"
								@else
								class="tab-pane fade show" @endif
								id="pills-home1" role="tabpanel" aria-labelledby="pills-home1-tab">

								<form id="en_update" action="{{ route('blog.update', $show->id) }}" class="form" method="POST" novalidate
									enctype="multipart/form-data">
									{{ csrf_field() }}
									{{ method_field('PUT') }}
									<input type="hidden" name="lang" value="en" id="lang">
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
																		<input type="text" value="{{ $show->getTranslation('heading', 'en', false) }}" autofocus=""
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
																		<label class="text-dark">{{ __('adminstaticword.Slug') }}
																			: <span class="text-danger">*</span></label>
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
																		<label class="text-dark">{{ __('adminstaticword.Date') }}
																			: <span class="text-danger">*</span></label>
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
																			 placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Detail') }}" required="">{{ $show->getTranslation('detail', 'en', false) }}</textarea>
																			@error('detail')
																				<span class="invalid-feedback" role="alert">
																					<strong>{{ $message }}</strong>
																				</span>
																			@enderror
																		</div>
																	</div>
																</div> --}}

																<input type="hidden" name="detail" id="detail"
																	value="{{ $show->getTranslation('detail', 'en', false) }}">

																<div class="col-md-12">
																	<label class="text-dark">{{ __('adminstaticword.Detail') }}:
																		<span class="text-danger">*</span></label>
																	<div id="toolbar-container"></div>
																	<div class="form-group">
																		<div name="detail" id="editor" class="@error('detail') is-invalid @enderror">
																			@if ($show->getTranslation('detail', 'en', false))
																				{!! $show->getTranslation('detail', 'en', false) !!}
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
																				class="text-dark feather icon-help-circle"></i>({{ __('Choose Image for blog post') }})</small>
																		<br>
																		<img src=" {{ url('images/blog/' . $show->image) }}" class="pro-img" style="width:20%" />
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
							</div>
							<div
								@if ($show->getTranslation('heading', 'en', false) != null) class="tab-pane fade show"
								@else
								class="tab-pane fade show active" @endif
								id="pills-profile1" role="tabpanel" aria-labelledby="pills-profile-tab">
								<form id="ar_update" action="{{ route('blog.update', $show->id) }}" class="form" method="POST" novalidate
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
																		<label class="text-dark">{{ __('adminstaticword.Slug') }}
																			:
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
																		<label class="text-dark">{{ __('adminstaticword.Date') }}
																			:
																			<span class="text-danger">*</span></label>
																		<input type="date" class="form-control" value="{{ $show->date }}" name="date"
																			id="inputDate" placeholder="{{ __('adminstaticword.Select') }} {{ __('adminstaticword.Date') }}"
																			required>

																		@error('date')
																			<span class="invalid-feedback" role="alert">
																				<strong>{{ $message }}</strong>
																			</span>
																		@enderror
																	</div>
																</div>

																<!-- detail -->
																{{-- <div class="col-md-12">
																	<div id="toolbar-container1"></div>
																	<div id="editor1">
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

																<input type="hidden" name="detail" id="detail1"
																	value="{{ $show->getTranslation('detail', 'ar', false) }}">

																<div class="col-md-12">
																	<label class="text-dark">{{ __('adminstaticword.Detail') }}:
																		<span class="text-danger">*</span></label>
																	<div id="toolbar-container1"></div>
																	<div class="form-group">
																		<div name="detail" id="editor1" class="@error('detail') is-invalid @enderror">
																			@if ($show->getTranslation('detail', 'ar', false))
																				{!! $show->getTranslation('detail', 'ar', false) !!}
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
																{{-- <div class="col-md-12">
																<div class="form-group">
																		<label class="text-dark">{{ __('adminstaticword.Detail') }}:
																			<span class="text-danger">*</span></label>
																		<textarea id="detail" name="detail" class="@error('detail') is-invalid @enderror"
																		 placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Detail') }}" required="">{{ $show->getTranslation('detail', 'ar', false) }}</textarea>
																		@error('detail')
																			<span class="invalid-feedback" role="alert">
																				<strong>{{ $message }}</strong>
																			</span>
																		@enderror
																	</div>	
																</div> --}}

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

																			<input required readonly id="image1" name="image" type="text" class="form-control">
																			<div class="input-group-append">
																				<span data-input="image1"
																					class="bg-primary text-light midia-toggle1 input-group-text">{{ __('Browse') }}</span>
																			</div>
																		</div>

																		<small class="text-info"> <i
																				class="text-dark feather icon-help-circle"></i>({{ __('Choose Image for blog post') }})</small>
																		<br>
																		<img src=" {{ url('images/blog/' . $show->image) }}" class="pro-img" style="width:20%" />
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
							</div>

						</div>
					</div>

				</div><!-- col end -->
			</div>
		</div>
	</div><!-- row end -->
	<br><br>
@endsection
<!-- main content section ended -->
<!-- This section will contain javacsript start -->
@section('script')

	<script>
		$(".midia-toggle").midia({
			base_url: '{{ url('') }}',
			title: 'Choose Blog Image',
			dropzone: {
				acceptedFiles: '.jpg,.png,.jpeg,.webp,.bmp,.gif'
			},
			directory_name: 'blog'
		});
	</script>
	<script>
		$(".midia-toggle1").midia({
			base_url: '{{ url('') }}',
			title: 'Choose Blog Image',
			dropzone: {
				acceptedFiles: '.jpg,.png,.jpeg,.webp,.bmp,.gif'
			},
			directory_name: 'blog'
		});
	</script>

	<style>
		.image_size {
			height: 80px;
			width: 200px;
		}
	</style>

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
				const form = document.querySelector('#en_update');
				const editorContentInput = document.querySelector('#detail');

				form.addEventListener('submit', function(event) {
					editorContentInput.value = editor.getData();
				});
			})
			.catch(error => {
				console.error(error);
			});
	</script>

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
				const form = document.querySelector('#ar_update');
				const editorContentInput = document.querySelector('#detail1');

				form.addEventListener('submit', function(event) {
					editorContentInput.value = editor.getData();
				});
			})
			.catch(error => {
				console.error(error);
			});
	</script>

@endsection
<!-- This section will contain javacsript end -->
