@extends('admin.layouts.master')
@section('title', 'Create a new course')
@section('breadcum')
	@component('components.breadcumb', ['secondaryactive' => 'active'])
		@slot('heading')
			{{ __('Course') }}
		@endslot

		@slot('menu1')
			{{ __('Course') }}
		@endslot

		@slot('button')
			<div class="col-md-4 col-lg-4">
				<div class="widgetbar">
					<a href="{{ route('course.index') }}" class="float-right btn btn-primary-rgba mr-2"><i
							class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
				</div>
			</div>
		@endslot
	@endcomponent
	<div class="contentbar">
		<div class="row">
			<div class="col-md-12">
				<div class="card m-b-30">
					<div class="card-header">
						<div class="row">
							<div class="col-md-6">
								<h5 class="box-tittle">{{ __('adminstaticword.Add') }} {{ __('adminstaticword.Course') }}</h5>
							</div>
						</div>
					</div>
					<div class="card-body">
						<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="pills-english-tab" data-toggle="pill" href="#pills-english" role="tab"
									aria-controls="pills-english" aria-selected="true">{{ __('English') }}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="pills-arabic-tab" data-toggle="pill" href="#pills-arabic" role="tab"
									aria-controls="pills-arabic" aria-selected="false">{{ __('Arabic') }}</a>
							</li>
						</ul>
						<div class="tab-content" id="pills-tabContent">
							<div class="tab-pane fade show active" id="pills-english" role="tabpanel" aria-labelledby="pills-english-tab">
								@include('admin.course.insert_en')
							</div>
							<div class="tab-pane fade" id="pills-arabic" role="tabpanel" aria-labelledby="pills-arabic-tab">
								@include('admin.course.insert_ar')
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
