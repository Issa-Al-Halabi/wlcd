@extends('admin.layouts.master')
@section('title', 'Edit Bundle')
@section('maincontent')

	@component('components.breadcumb', ['thirdactive' => 'active'])
		@slot('heading')
			{{ __('Home') }}
		@endslot

		@slot('menu1')
			{{ __('Admin') }}
		@endslot

		@slot('menu2')
			{{ __('Edit Bundle') }}
		@endslot

		@slot('button')
			<div class="col-md-4 col-lg-4">
				<a href="{{ url('bundle') }}" class="float-right btn btn-primary mr-2"><i
						class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
			</div>
		@endslot
	@endcomponent

	<div class="contentbar">
		<div class="row">
			<div class="col-lg-12">
				<div class="card m-b-30">
					<div class="card-header">
						<h5 class="card-box">{{ __('adminstaticword.Edit') }} {{ __('Bundle') }}</h5>
					</div>
					<div class="card-body ml-2">
						<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
							<li class="nav-item">
								<a
									@if ($cor->getTranslation('title', 'en', false) != null) class="nav-link active"
                                    @else
                                    class="nav-link" @endif
									id="pills-english-tab" data-toggle="pill" href="#pills-english" role="tab" aria-controls="pills-english"
									aria-selected="true">{{ __('English') }}</a>
							</li>
							<li class="nav-item">
								<a
									@if ($cor->getTranslation('title', 'en', false) != null) class="nav-link"
                                    @else
                                    class="nav-link active" @endif
									id="pills-arabic-tab" data-toggle="pill" href="#pills-arabic" role="tab" aria-controls="pills-arabic"
									aria-selected="false">{{ __('Arabic') }}</a>
							</li>
						</ul>

						<div class="tab-content" id="pills-tabContent">
							<div
								@if ($cor->getTranslation('title', 'en', false) != null) class="tab-pane fade show active"
                                    @else
                                    class="tab-pane fade show" @endif
								id="pills-english" role="tabpanel" aria-labelledby="pills-english-tab">
								<form action="{{ route('bundle.update', $cor->id) }}" method="post" enctype="multipart/form-data">
									{{ csrf_field() }}
									{{ method_field('PUT') }}

									<input type="hidden" name="lang" value="en" id="lang">

									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for="exampleInputTit1e">{{ __('adminstaticword.Title') }}:<sup class="text-danger">*</sup></label>
												<input type="text" class="form-control" name="title" id="exampleInputTitle" required
													value="{{ $cor->getTranslation('title', 'en', false) }}">
											</div>

											<div class="form-group">
												<label for="exampleInputDetails">{{ __('adminstaticword.ShortDetail') }}:<sup
														class="text-danger">*</sup></label>
												<textarea id="short_detail" name="short_detail" rows="3" class="form-control" required>{{ $cor->getTranslation('short_detail', 'en', false) }}</textarea>
											</div>
											<div class="form-group">
												<label for="exampleInputDetails">{{ __('adminstaticword.Detail') }}:<sup class="text-danger">*</sup></label>
												<textarea id="detail" name="detail" rows="3" class="form-control" required>{!! $cor->getTranslation('detail', 'en', false) !!}</textarea>
											</div>
											<div class="form-group">
												<label>{{ __('adminstaticword.SelectCourse') }}: <span class="text-danger">*</span></label>
												<select class="form-control select2" name="course_id[]" multiple="multiple" size="5" row="5"
													placeholder="{{ __('adminstaticword.SelectCourse') }}">

													@foreach ($courses as $cat)
														@if ($cat->status == 1)
															<option value="{{ $cat->id }}" {{ in_array($cat->id, $cor['course_id'] ?: []) ? 'selected' : '' }}>
																{{ $cat->getTranslation('title', 'en', false) }}
															</option>
														@endif
													@endforeach

												</select>
											</div>
											<div class="form-group">
												<label>{{ __('adminstaticword.Image') }}:<sup class="redstar">*</sup></label>
												<small class="text-muted"><i class="fa fa-question-circle"></i>
													{{ __('adminstaticword.Recommendedsize') }} (1375 x 409px)</small>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
													</div>
													<div class="custom-file">
														<input type="file" class="custom-file-input" id="image" name="image"
															aria-describedby="inputGroupFileAddon01">
														<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
													</div>
												</div>
												@if ($cor['preview_image'] !== null && $cor['preview_image'] !== '')
													<img src="{{ url('/images/bundle/' . $cor->preview_image) }}" height="70px;" width="70px;" />
												@else
													<img src="{{ Avatar::create($cor->title)->toBase64() }}" alt="course" class="img-fluid">
												@endif
											</div>
											<div class="row">
												<div class="col-md-4">
													<div class="form-group">
														<label for="exampleInputDetails">{{ __('adminstaticword.Paid') }}:</label>
														<input id="cb111" type="checkbox" class="custom_toggle" name="type"
															{{ $cor->type == '1' ? 'checked' : '' }} />
														<br>

													</div>

													<div @class(['d-none' => $cor->type == '0']) id="doabox">
														<div>
															<label for="exampleInputSlug">{{ __('adminstaticword.Price') }}: <sup
																	class="text-danger">*</sup></label>
															<input {{ $cor->type == '1' ? 'required' : '' }} type="number" min="1" class="form-control"
																name="price" id="exampleInputPassword1"
																placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Price') }}"
																value="{{ $cor->price }}">
														</div>

														<div>
															<br>
															<label for="exampleInputSlug">{{ __('adminstaticword.DiscountPrice') }}:
																<sup class="text-danger">*</sup></label>
															<input type="number" min="1" class="form-control" name="discount_price"
																id="exampleInputPassword1"
																placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.DiscountPrice') }}"
																value="{{ $cor->discount_price }}">
														</div>
													</div>
												</div>

												<div class="col-md-4">
													<div class="form-group">
														@if (Auth::User()->role == 'admin')
															<label for="exampleInputTit1e">{{ __('adminstaticword.Featured') }}:</label>
															<input id="status" type="checkbox" class="custom_toggle" name="featured"
																{{ $cor->featured == 1 ? 'checked' : '' }} />
														@endif
													</div>
												</div>

												<div class="col-md-4">
														@if (Auth::User()->role == 'admin')
															<label for="exampleInputTit1e">{{ __('adminstaticword.Status') }}:</label>
															<input id="status" type="checkbox" class="custom_toggle" name="status"
																{{ $cor->status == 1 ? 'checked' : '' }} />
														@endif
												</div>

												{{-- <div class="col-md-3">
													<div class="form-group">
                                                            <label
                                                                for="cbToggleSubscription">{{ __('adminstaticword.Subscription') }}:</label>
                                                            <input id="subscription1" type="checkbox" name="is_subscription_enabled"
                                                                class="custom_toggle"
                                                                {{ $cor->is_subscription_enabled ? 'checked' : '' }} />
            
            
            
                                                            <small class="text-muted"><i
                                                                    class="fa fa-question-circle"></i>{{ __('Subscription
                                                                                                            bundle works with stripe payment only') }}
                                                                .</small><br>
                                                            <small
                                                                class="text-muted">{{ __('Enable it only when you have setup stripe') }}
                                                                .</small>
            
            
                                                            <br>
                                                            <div id="subscription"
                                                                style="{{ $cor['is_subscription_enabled'] ? '' : 'display:none' }}">
            
                                                                @php
                                                                    $selectedPeriod = $cor->billing_interval;
                                                                @endphp
                                                                <label>{{ __('adminstaticword.BillingPeriod') }}</label>
                                                                <select class="form-control" name="billing_interval">
                                                                    <option value="day"
                                                                        {{ $selectedPeriod == 'day' ? 'selected' : '' }}>
                                                                        {{ __('Daily') }}</option>
                                                                    <option value="week"
                                                                        {{ $selectedPeriod == 'week' ? 'selected' : '' }}>
                                                                        {{ __('Weekly') }}</option>
                                                                    <option value="month"
                                                                        {{ $selectedPeriod == 'month' ? 'selected' : '' }}>
                                                                        {{ __('Monthly') }}</option>
                                                                    <option value="year"
                                                                        {{ $selectedPeriod == 'year' ? 'selected' : '' }}>
                                                                        {{ __('Yearly') }}</option>
                                                                </select>
            
                                                            </div>
                                                        </div>
												</div> --}}

												{{-- <div class="col-md-3">
													<div class="form-group">
														<label for="">{{ __('adminstaticword.Duration') }}: </label>
														<input id="duration1" type="checkbox" class="custom_toggle" name="duration_type"
															{{ $cor->duration_type == 'm' ? 'checked' : '' }} />
														<div @class(['d-none' => $cor->duration_type == 'd']) id="duration">
															<label for="exampleInputSlug">{{ __('adminstaticword.BundleExpireDuration') }}</label>
															<input min="1" class="form-control" name="duration" type="number" id="duration2"
																value="{{ $cor->duration }}" placeholder="{{ __('adminstaticword.Enter') }} Duration">
														</div>
													</div>
												</div> --}}
											</div>
										</div>
										
										<div class="form-group col-md-12">
											<button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i>
												{{ __('Reset') }}</button>
											<button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
												{{ __('Update') }}</button>
										</div>
									</div>
								</form>
							</div>

							<div
								@if ($cor->getTranslation('title', 'en', false) != null) class="tab-pane fade show"
                                @else
                                class="tab-pane fade show active" @endif
								id="pills-arabic" role="tabpanel" aria-labelledby="pills-arabic-tab">
								<form action="{{ route('bundle.update', $cor->id) }}" method="post" enctype="multipart/form-data">
									{{ csrf_field() }}
									{{ method_field('PUT') }}

									<input type="hidden" name="lang" value="ar" id="lang">

									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for="exampleInputTit1e">{{ __('adminstaticword.Title') }}:<sup class="text-danger">*</sup></label>
												<input type="text" class="form-control" name="title" id="exampleInputTitle" required
													value="{{ $cor->getTranslation('title', 'ar', false) }}">
											</div>

											<div class="form-group">
												<label for="exampleInputDetails">{{ __('adminstaticword.ShortDetail') }}:<sup
														class="text-danger">*</sup></label>
												<textarea id="short_detail" name="short_detail" rows="3" class="form-control" required>{{ $cor->getTranslation('short_detail', 'ar', false) }}</textarea>
											</div>
											<div class="form-group">
												<label for="exampleInputDetails">{{ __('adminstaticword.Detail') }}:<sup
														class="text-danger">*</sup></label>
												<textarea id="detail" name="detail" rows="3" class="form-control" required>{!! $cor->getTranslation('detail', 'ar', false) !!}</textarea>
											</div>
											<div class="form-group">
												<label>{{ __('adminstaticword.SelectCourse') }}: <span class="text-danger">*</span></label>
												<select class="form-control select2" name="course_id[]" multiple="multiple" size="5"
													row="5" placeholder="{{ __('adminstaticword.SelectCourse') }}">


													@foreach ($courses as $cat)
														@if ($cat->status == 1)
															<option value="{{ $cat->id }}"
																{{ in_array($cat->id, $cor['course_id'] ?: []) ? 'selected' : '' }}>
																{{ $cat->getTranslation('title', 'ar', false) }}
															</option>
														@endif
													@endforeach

												</select>
											</div>
											<div class="form-group">
												<label>{{ __('adminstaticword.Image') }}:<sup class="redstar">*</sup></label>
												<small class="text-muted"><i class="fa fa-question-circle"></i>
													{{ __('adminstaticword.Recommendedsize') }} (1375 x 409px)</small>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
													</div>
													<div class="custom-file">
														<input type="file" class="custom-file-input" id="image" name="image"
															aria-describedby="inputGroupFileAddon01">
														<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
													</div>
												</div>
												@if ($cor['preview_image'] !== null && $cor['preview_image'] !== '')
													<img src="{{ url('/images/bundle/' . $cor->preview_image) }}" height="70px;" width="70px;" />
												@else
													<img src="{{ Avatar::create($cor->title)->toBase64() }}" alt="course" class="img-fluid">
												@endif
											</div>
											<div class="row">
												<div class="col-md-4">
													<div class="form-group">
														<label for="exampleInputDetails">{{ __('adminstaticword.Paid') }}:</label>
														<input id="cb111" type="checkbox" class="custom_toggle" name="type"
															{{ $cor->type == '1' ? 'checked' : '' }} />
														<br>

													</div>

													<div @class(['d-none' => $cor->type == '0']) id="doabox">
														<div>
															<label for="exampleInputSlug">{{ __('adminstaticword.Price') }}: <sup
																	class="text-danger">*</sup></label>
															<input {{ $cor->type == '1' ? 'required' : '' }} type="number" min="1" class="form-control"
																name="price" id="exampleInputPassword1"
																placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Price') }}"
																value="{{ $cor->price }}">
														</div>

														<div>
															<br>
															<label for="exampleInputSlug">{{ __('adminstaticword.DiscountPrice') }}:
																<sup class="text-danger">*</sup></label>
															<input type="number" min="1" class="form-control" name="discount_price"
																id="exampleInputPassword1"
																placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.DiscountPrice') }}"
																value="{{ $cor->discount_price }}">
														</div>
													</div>

												</div>

												<div class="col-md-4">
													<div class="form-group">
														@if (Auth::User()->role == 'admin')
															<label for="exampleInputTit1e">{{ __('adminstaticword.Featured') }}:</label>
															<input id="status" type="checkbox" class="custom_toggle" name="featured"
																{{ $cor->featured == 1 ? 'checked' : '' }} />
														@endif
													</div>
												</div>

												<div class="col-md-4">
													<div class="form-group">
														@if (Auth::User()->role == 'admin')
														<label for="exampleInputTit1e">{{ __('adminstaticword.Status') }}:</label>
														<input id="status" type="checkbox" class="custom_toggle" name="status"
															{{ $cor->status == 1 ? 'checked' : '' }} />
													@endif
													</div>
												</div>

												{{-- <div class="col-md-3">
													<div class="form-group">
                                                        <label
                                                            for="cbToggleSubscription">{{ __('adminstaticword.Subscription') }}:</label>
                                                        <input id="subscription1" type="checkbox" name="is_subscription_enabled"
                                                            class="custom_toggle"
                                                            {{ $cor->is_subscription_enabled ? 'checked' : '' }} />
        
        
        
                                                        <small class="text-muted"><i
                                                                class="fa fa-question-circle"></i>{{ __('Subscription
                                                                                                        bundle works with stripe payment only') }}
                                                            .</small><br>
                                                        <small
                                                            class="text-muted">{{ __('Enable it only when you have setup stripe') }}
                                                            .</small>
        
        
                                                        <br>
                                                        <div id="subscription"
                                                            style="{{ $cor['is_subscription_enabled'] ? '' : 'display:none' }}">
        
                                                            @php
                                                                $selectedPeriod = $cor->billing_interval;
                                                            @endphp
                                                            <label>{{ __('adminstaticword.BillingPeriod') }}</label>
                                                            <select class="form-control" name="billing_interval">
                                                                <option value="day"
                                                                    {{ $selectedPeriod == 'day' ? 'selected' : '' }}>
                                                                    {{ __('Daily') }}</option>
                                                                <option value="week"
                                                                    {{ $selectedPeriod == 'week' ? 'selected' : '' }}>
                                                                    {{ __('Weekly') }}</option>
                                                                <option value="month"
                                                                    {{ $selectedPeriod == 'month' ? 'selected' : '' }}>
                                                                    {{ __('Monthly') }}</option>
                                                                <option value="year"
                                                                    {{ $selectedPeriod == 'year' ? 'selected' : '' }}>
                                                                    {{ __('Yearly') }}</option>
                                                            </select>
        
                                                        </div>
                                                    </div>
												</div> --}}

												{{-- <div class="col-md-3">
													<div class="form-group">
														<label for="">{{ __('adminstaticword.Duration') }}: </label>
														<input id="duration1" type="checkbox" class="custom_toggle" name="duration_type"
															{{ $cor->duration_type == 'm' ? 'checked' : '' }} />
														<div @class(['d-none' => $cor->duration_type == 'd']) id="duration">
															<label for="exampleInputSlug">{{ __('adminstaticword.BundleExpireDuration') }}</label>
															<input min="1" class="form-control" name="duration" type="number" id="duration2"
																value="{{ $cor->duration }}" placeholder="{{ __('adminstaticword.Enter') }} Duration">
														</div>
													</div>
												</div> --}}
											</div>
										</div>
										
										<div class="form-group col-md-12">
											<button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i>
												{{ __('Reset') }}</button>
											<button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
												{{ __('Update') }}</button>
										</div>
									</div>
								</form>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('scripts')

	<script>
		(function($) {
			"use strict";


			$(function() {
				$('.js-example-basic-single').select2();
			});

			$(function() {
				$('#cb1').change(function() {
					$('#f').val(+$(this).prop('checked'))
				})
			})

			$(function() {
				$('#cb3').change(function() {
					$('#test').val(+$(this).prop('checked'))
				})
			})

			$(function() {

				$('#murl').change(function() {
					if ($('#murl').val() == 'yes') {
						$('#doab').show();
					} else {
						$('#doab').hide();
					}
				});

			});

			$(function() {

				$('#murll').change(function() {
					if ($('#murll').val() == 'yes') {
						$('#doabb').show();
					} else {
						$('#doab').hide();
					}
				});

			});

			$('#preview').on('change', function() {

				if ($('#preview').is(':checked')) {
					$('#document1').show('fast');
					$('#document2').hide('fast');

				} else {
					$('#document2').show('fast');
					$('#document1').hide('fast');
				}

			});

		})(jQuery);
	</script>



	<script>
		(function($) {
			"use strict";
			$(function() {
				$('#subscription1').change(function() {
					if ($('#subscription1').is(':checked')) {
						$('#subscription').show('fast');
					} else {
						$('#subscription').hide('fast');
					}
				});


			});
		})(jQuery);
	</script>



	<script>
		$('#cb111').on('change', function() {
			if ($('#cb111').is(':checked')) {
				$('#doabox').addClass('d-block').removeClass('d-none');
				$('#priceMain').prop('required', 'required');
			} else {
				$('#doabox').addClass('d-none').removeClass('d-block');
				$('#priceMain').removeAttr('required');
			}
		});



		$('#duration1').on('change', function() {
			if ($('#duration1').is(':checked')) {
				$('#duration').addClass('d-block').removeClass('d-none');
				$('#duration2').prop('required', 'required');
			} else {
				$('#duration').addClass('d-none').removeClass('d-block');
				$('#duration2').removeAttr('required');
			}
		});
	</script>

@endsection
