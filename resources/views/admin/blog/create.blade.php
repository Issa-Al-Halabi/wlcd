@extends('admin.layouts.master')
@section('title', 'Add Blog - Admin')
@section('maincontent')
	@component('components.breadcumb', ['fourthactive' => 'active'])
		@slot('heading')
			{{ __('Add Blog') }}
		@endslot
		@slot('menu1')
			{{ __('Blog') }}
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
						<h5 class="card-box"> {{ __('adminstaticword.AddBlog') }}</h5>
					</div>

					<!-- card body started -->
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
								@include('admin.blog.blog_form_en')
							</div>
							<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
								@include('admin.blog.blog_form_ar')
							</div>

						</div>
					</div>

					<!-- card body end -->

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
		
		$(".midia-toggle1").midia({
			base_url: '{{ url('') }}',
			title: 'Choose Blog Image',
			dropzone: {
				acceptedFiles: '.jpg,.png,.jpeg,.webp,.bmp,.gif'
			},
			directory_name: 'blog'
		});
	</script>

	{{-- doc --}}
	{{-- <script>
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
	</script> --}}
	
@endsection
<!-- This section will contain javacsript end -->
