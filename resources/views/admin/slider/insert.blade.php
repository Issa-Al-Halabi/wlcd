@extends('admin.layouts.master')
@section('title', 'Add Slider - Admin')
@section('maincontent')


	@component('components.breadcumb', ['fourthactive' => 'active'])
		@slot('heading')
			{{ __('Add Slider') }}
		@endslot
		@slot('menu1')
			{{ __('Front Settings') }}
		@endslot
		@slot('menu2')
			{{ __('Slider') }}
		@endslot
		@slot('menu3')
			{{ __('Add Slider') }}
		@endslot
		@slot('button')
			<div class="col-md-4 col-lg-4">
				<div class="widgetbar">
					<a href="{{ url('slider') }}" class="btn btn-primary-rgba"><i
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
						<h5 class="card-title">{{ __('Add Slider') }}</h5>
					</div>
					<div class="card-body">

						<form id="demo-form2" method="post" action="{{ url('slider/') }}" data-parsley-validate
							class="form-horizontal form-label-left" enctype="multipart/form-data">
							{{ csrf_field() }}

							<div class="row">
								<div class="form-group col-md-6">
									<label for="exampleInputTit1e">{{ __('adminstaticword.Heading') }}:<sup
											class="redstar text-danger">*</sup></label>
									<input class="form-control" type="text" name="heading"
										placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Heading') }}">

								</div>
								<div class="form-group col-md-6">
									<label for="exampleInputSlug">{{ __('adminstaticword.SubHeading') }}:<sup
											class="redstar text-danger">*</sup></label>
									<input type="slug" class="form-control" name="sub_heading" id="exampleInputPassword1"
										placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.SubHeading') }}">
								</div>

								<div class="d-none">
									<label for="exampleInputTit1e d-none">{{ __('adminstaticword.SearchText') }}:<sup
											class="redstar text-danger">*</sup></label>
									<input type="text" class="form-control display-none" name="search_text" id="exampleInputTitle"
										value="0">
								</div>
								<div class="form-group col-md-12">
									<label for="exampleInputDetails">{{ __('adminstaticword.Detail') }}:<sup
											class="redstar text-danger">*</sup></label>
									<textarea name="detail" rows="3" class="form-control"
									 placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Detail') }}"></textarea>
								</div>


								@if (Auth::user()->role == 'instructor')
									<div class="form-group col-md-6">
										<label for="exampleInputSlug"> {{ __('adminstaticword.Image') }}:<sup
												class="redstar text-danger">*</sup></label><br>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
											</div>
											<div class="custom-file">
												<input type="file" name="image" class="custom-file-input" id="inputGroupFile01"
													aria-describedby="inputGroupFileAddon01">
												<label class="custom-file-label" for="inputGroupFile01">Choose file</label>
											</div>
										</div>
									</div>
								@endif

								@if (Auth::user()->role == 'admin')
									<div class="col-md-6">
										<label class="text-dark">{{ __('adminstaticword.Image') }}:<sup
												class="redstar text-danger">*</sup></label><br>
										<div class="input-group mb-3">
											<input type="text" class="form-control" readonly id="image" name="image">
											<div class="input-group-append">
												<span data-input="image" class="midia-toggle btn-primary  input-group-text" id="basic-addon2">Browse</span>
											</div>
										</div>
									</div>
								@endif




								<div class="form-group col-md-2">
									<label for="exampleInputDetails">{{ __('adminstaticword.Status') }}:</label><br>
									<input type="checkbox" class="custom_toggle" name="status" checked />
									<input type="hidden" name="free" value="0" for="status" id="status">
								</div>


								<div class="form-group col-md-2">
									<label for="exampleInputDetails">{{ __('adminstaticword.TextPosition') }}:</label><br>
									<input id="pay" class="custom_toggle" type="checkbox" name="left" checked />

									<input type="hidden" name="free" value="0" for="left" id="left">


								</div>
								<div class="form-group col-md-2">
									<label for="exampleInputDetails">{{ __(' Enable Search on Slider') }}:</label><br>
									<input type="checkbox" name="search_enable" class="custom_toggle" checked />
									<input type="hidden" name="free" value="0" for="search_enable" id="search_enable">

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

@endsection


@section('script')
	<script>
		$(".midia-toggle").midia({
			base_url: '{{ url('') }}',
			title: 'Choose Slider Image',
			dropzone: {
				acceptedFiles: '.jpg,.png,.jpeg,.webp,.bmp,.gif'
			},
			directory_name: 'slider'
		});
	</script>
@endsection
