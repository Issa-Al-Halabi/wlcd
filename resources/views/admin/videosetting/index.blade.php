@extends('admin.layouts.master')
@section('title', 'Videosetting - Admin')
@section('maincontent')
	@component('components.breadcumb', ['thirdactive' => 'active'])
		@slot('heading')
			{{ __('Videosetting') }}
		@endslot
		@slot('menu1')
			{{ __('Settings') }}
		@endslot
		@slot('menu2')
			{{ __('Videosetting') }}
		@endslot
	@endcomponent
	<div class="contentbar">
		@if ($errors->any())
			<div class="alert alert-danger" role="alert">
				@foreach ($errors->all() as $error)
					<p>{{ $error }}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true" class="text-danger">&times;</span></button></p>
				@endforeach
			</div>
		@endif
		<div class="row">
			<div class="col-lg-12">
				<div class="card m-b-30">
					<div class="card-header">
						<h5 class="card-title">{{ __('VideoSetting') }}</h5>
					</div>
					<div class="card-body">
						<form class="form" action="{{ route('videosetting.update') }}" method="POST" novalidate
							enctype="multipart/form-data">
							@csrf
							<div class="row">
								<div class="form-group col-md-12">
									<label class="text-dark">{{ __('Url') }}:</label>
									<input name="url" value="{{ $videosetting->url }}" autofocus="" type="url"
										class="{{ $errors->has('url') ? ' is-invalid' : '' }} form-control" placeholder="Enter Url" required="">
									<div class="invalid-feedback">
										{{ __('Please enter Url!') }}.
									</div>
								</div>
								{{-- <div class="form-group col-md-12">
                            <label class="text-dark">{{ __('Tittle') }}:</label>
                            <input name="tittle" value="{{ $videosetting->tittle }}" autofocus="" type="text"
                                class="{{ $errors->has('text') ? ' is-invalid' : '' }} form-control"
                                placeholder="Enter Tittle" required="">
                            <div class="invalid-feedback">
                                {{ __('Please enter tittle!') }}.
                            </div>
                        </div> --}}
								{{-- <div class="form-group col-md-12">
                            <label class="text-dark">{{ __('Description') }}:</label>
                            <input name="description" value="{{ $videosetting->description }}" autofocus="" type="text"
                                class="{{ $errors->has('description') ? ' is-invalid' : '' }} form-control"
                                placeholder="Enter description" required="">
                            <div class="invalid-feedback">
                                {{ __('Please enter description!') }}.
                            </div>
                        </div> --}}
								<div class="form-group col-md-12">
									<label class="text-dark" for="exampleInputSlug">{{ __('adminstaticword.Image') }} : (16:4)
										
									</label>
									<div class="input-group mb-3">

										<div class="input-group-prepend">
											<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
										</div>
										<div class="custom-file">

											<input type="file" name="image" class="custom-file-input" id="img"
												aria-describedby="inputGroupFileAddon01">
											<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
										</div>
									</div>
									@if ($videosetting['image'] !== null && $videosetting['image'] !== '')
										<img src="{{ url('/images/videosetting/' . $videosetting->image) }}" height="100px;" width="100px;" />
									@else
										<img src="{{ Avatar::create($videosetting->tittle)->toBase64() }}" alt="course" class="img-fluid">
									@endif
								</div>
							</div>
							<div class="form-group">
								<button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i>
									{{ __('Reset') }}</button>
								<button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
									{{ __('Update') }}</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
