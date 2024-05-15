@extends('admin.layouts.master')
@section('title', 'Create a new bundle')
@section('breadcum')
	@component('components.breadcumb', ['secondaryactive' => 'active'])
		@slot('heading')
			{{ __('Bundle') }}
		@endslot
		@slot('menu1')
			{{ __('Bundle') }}
		@endslot

		@slot('button')
			<div class="col-md-4 col-lg-4">
				<div class="widgetbar">
					<a href="{{ url('bundle') }}" class="float-right btn btn-dark-rgba mr-2"><i
							class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
				</div>
			</div>
		@endslot
	@endcomponent
	<div class="contentbar">
		<div class="row">
			<div class="col-lg-12">
				<div class="card m-b-30">
					<div class="card-header">
						<h5 class="card-box">{{ __('Add') }} {{ __('Bundle') }}</h5>
					</div>
					<div class="card-body">

						<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
							<li class="nav-item">
								<a
									@if (Session::get('changed_language') == 'en') class="nav-link active"
                                    @else
                                    class="nav-link" @endif
									id="pills-english-tab" data-toggle="pill" href="#pills-english" role="tab" aria-controls="pills-english"
									aria-selected="true">{{ __('English') }}</a>
							</li>
							<li class="nav-item">
								<a
									@if (Session::get('changed_language') == 'en') class="nav-link"
                                    @else
                                    class="nav-link active" @endif
									id="pills-arabic-tab" data-toggle="pill" href="#pills-arabic" role="tab" aria-controls="pills-arabic"
									aria-selected="false">{{ __('Arabic') }}</a>
							</li>
						</ul>

						<div class="tab-content" id="pills-tabContent">
							<div
								@if (Session::get('changed_language') == 'en') class="tab-pane fade show active"
                                    @else
                                    class="tab-pane fade show" @endif
								id="pills-english" role="tabpanel" aria-labelledby="pills-english-tab">
								<form action="{{ url('bundle/') }}" method="post" enctype="multipart/form-data">
									{{ csrf_field() }}

									<input type="hidden" class="form-control" name="user_id" id="exampleInputTitle" value="{{ Auth::User()->id }}"
										required>
									<div class="row">
										<div class=" col-md-12">

											<div class="form-group">
												<label for="exampleInputTit1e">{{ __('adminstaticword.Title') }}: <sup class="text-danger">*</sup></label>
												<input type="title" class="form-control" name="title" id="exampleInputTitle"
													placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Title') }}" value="" required>

											</div>

											<div class="form-group">
												<label>{{ __('adminstaticword.SelectCourse') }}: <span class="text-danger">*</span></label>
												<select class="form-control select2" name="course_id[]" multiple="multiple" size="5" row="5"
													placeholder="{{ __('adminstaticword.SelectCourse') }}">


													@foreach ($courses as $cat)
														@if ($cat->status == 1)
															<option value="{{ $cat->id }}">{{ $cat->title }}
															</option>
														@endif
													@endforeach

												</select>
											</div>
											<div class="form-group">
												<label for="exampleInputTit1e">{{ __('adminstaticword.ShortDetail') }}: <sup
														class="text-danger">*</sup></label>
												<textarea id="short_detail" name="short_detail" rows="4" class="form-control"
												 placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.ShortDetail') }}"></textarea>
											</div>
											<div class="form-group">
												<label for="exampleInputTit1e">{{ __('adminstaticword.Detail') }}: <sup class="text-danger">*</sup></label>
												<textarea id="detail" name="detail" rows="5" class="form-control"
												 placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Detail') }}"></textarea>
											</div>
											<div class="form-group">
												<label>{{ __('adminstaticword.PreviewImage') }}:</label> - <p class="inline info">
													{{ __('size') }}: 250x150</p>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
													</div>
													<div class="custom-file">
														<input type="file" name="preview_image" class="custom-file-input" id="image"
															aria-describedby="inputGroupFileAddon01">
														<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
													</div>
												</div>
												<div class="row">
													<div class="col-md-4">
														<div class="form-group">
															<label for="exampleInputDetails">{{ __('adminstaticword.Paid') }}:</label>
															<input id="cb111" type="checkbox" class="custom_toggle" name="type" />

															<br>
															<div class="form-group" id="pricebox" style="display: none;">
																<label for="exampleInputSlug">{{ __('adminstaticword.Price') }}:
																	<sup class="text-danger">*</sup></label>
																<input type="number" class="form-control" name="price" id="priceMain"
																	placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Price') }}" value="">

																<label for="exampleInputSlug">{{ __('adminstaticword.DiscountPrice') }}:
																</label>
																<input type="number" class="form-control" name="discount_price" id="offerPrice"
																	placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.DiscountPrice') }}"
																	value="">
															</div>
														</div>
													</div>

													<div class="col-md-4">
														<div class="form-group">
															@if (Auth::User()->role == 'admin')
																<label for="exampleInputDetails">{{ __('adminstaticword.Featured') }}:</label>

																<input id="status_toggle" type="checkbox" name="featured" class="custom_toggle" id="cb1" />
															@endif
														</div>
													</div>

													<div class="col-md-4">
														<div class="form-group">
															@if (Auth::User()->role == 'admin')
																<label for="exampleInputDetails">{{ __('adminstaticword.Status') }}:</label>
																<input id="status_toggle" type="checkbox" name="status" class="custom_toggle" id="cb3" />
															@endif
														</div>
													</div>

													{{-- <div class="col-md-3">
														<div class="form-group">
															<label for="">{{ __('adminstaticword.Duration') }}: </label>
															<input id="duration1" type="checkbox" class="custom_toggle" name="duration_type" checked />

															<label class="tgl-btn" data-tg-off="days" data-tg-on="month" for="duration_type"></label>


															<br>
															<div class="form-group" id="duration">
																<label for="exampleInputSlug">{{ __('adminstaticword.BundleExpireDuration') }}
																</label>
																<input min="1" class="form-control" name="duration" type="number"
																	placeholder="{{ __('adminstaticword.Enter') }} Duration">
															</div>
														</div>
													</div> --}}
												</div>

											</div>
											{{-- <div class="form-group">
                                                      <label
                                                          for="cbToggleSubscription">{{ __('adminstaticword.Subscription') }}:</label>
                                                      <input id="subscription1" type="checkbox" name="is_subscription_enabled"
                                                          class="custom_toggle" />
                                                      <br>
            
                                                      <small class="text-info"><i class="fa fa-question-circle"></i>
                                                          {{ __('Subscription
                                                                                bundle works with stripe payment only') }}.</small><br>
                                                      <small class="text-info">
                                                          {{ __('Enable it only when you have setup stripe') }}.</small>
            
            
                                                      <br>
                                                      <div id="subscription" class="form-group display-none ">
            
            
                                                          <div class="form-group">
            
                                                              <label>{{ __('adminstaticword.BillingPeriod') }}</label>
                                                              <select class="form-control select2" name="billing_interval">
                                                                  <option value="day">{{ __('Daily') }}</option>
                                                                  <option value="week">{{ __('Weekly') }}</option>
                                                                  <option value="month">{{ __('Monthly') }}</option>
                                                                  <option value="year">{{ __('Yearly') }}</option>
                                                              </select>
                                                          </div>
                                                      </div>
                                                  </div> --}}

											<div class="form-group">
												<button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i>
													{{ __('Reset') }}</button>
												<button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
													{{ __('Create') }}</button>
											</div>

											<div class="clear-both"></div>
										</div>

									</div>
								</form>
							</div>
							<div
								@if (Session::get('changed_language') == 'en') class="tab-pane fade show"
                                @else
                                class="tab-pane fade show active" @endif
								id="pills-arabic" role="tabpanel" aria-labelledby="pills-arabic-tab">
								<form action="{{ url('bundle/') }}" method="post" enctype="multipart/form-data">
									{{ csrf_field() }}

									<input type="hidden" class="form-control" name="user_id" id="exampleInputTitle"
										value="{{ Auth::User()->id }}" required>
									<div class="row">
										<div class=" col-md-12">

											<div class="form-group">
												<label for="exampleInputTit1e">{{ __('adminstaticword.Title') }}: <sup class="text-danger">*</sup></label>
												<input type="title" class="form-control" name="title" id="exampleInputTitle"
													placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Title') }}" value=""
													required>

											</div>

											<div class="form-group">
												<label>{{ __('adminstaticword.SelectCourse') }}: <span class="text-danger">*</span></label>
												<select class="form-control select2" name="course_id[]" multiple="multiple" size="5"
													row="5" placeholder="{{ __('adminstaticword.SelectCourse') }}">


													@foreach ($courses as $cat)
														@if ($cat->status == 1)
															<option value="{{ $cat->id }}">{{ $cat->title }}
															</option>
														@endif
													@endforeach

												</select>
											</div>
											<div class="form-group">
												<label for="exampleInputTit1e">{{ __('adminstaticword.ShortDetail') }}: <sup
														class="text-danger">*</sup></label>
												<textarea id="short_detail" name="short_detail" rows="4" class="form-control"
												 placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.ShortDetail') }}"></textarea>
											</div>
											<div class="form-group">
												<label for="exampleInputTit1e">{{ __('adminstaticword.Detail') }}: <sup
														class="text-danger">*</sup></label>
												<textarea id="detail" name="detail" rows="5" class="form-control"
												 placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Detail') }}"></textarea>
											</div>
											<div class="form-group">
												<label>{{ __('adminstaticword.PreviewImage') }}:</label> - <p class="inline info">
													{{ __('size') }}: 250x150</p>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
													</div>
													<div class="custom-file">
														<input type="file" name="preview_image" class="custom-file-input" id="image"
															aria-describedby="inputGroupFileAddon01">
														<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
													</div>
												</div>
												<div class="row">
													<div class="col-md-3">
														<div class="form-group">
															<label for="exampleInputDetails">{{ __('adminstaticword.Paid') }}:</label>
															<input id="cb111" type="checkbox" class="custom_toggle" name="type" />

															<br>
															<div class="form-group" id="pricebox" style="display: none;">
																<label for="exampleInputSlug">{{ __('adminstaticword.Price') }}:
																	<sup class="text-danger">*</sup></label>
																<input type="number" class="form-control" name="price" id="priceMain"
																	placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Price') }}" value="">

																<label for="exampleInputSlug">{{ __('adminstaticword.DiscountPrice') }}:
																</label>
																<input type="number" class="form-control" name="discount_price" id="offerPrice"
																	placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.DiscountPrice') }}"
																	value="">
															</div>
														</div>
													</div>

													<div class="col-md-3">
														<div class="form-group">
															@if (Auth::User()->role == 'admin')
																<label for="exampleInputDetails">{{ __('adminstaticword.Featured') }}:</label>

																<input id="status_toggle" type="checkbox" name="featured" class="custom_toggle" id="cb1" />
															@endif
														</div>
													</div>

													<div class="col-md-3">
														<div class="form-group">
															@if (Auth::User()->role == 'admin')
																<label for="exampleInputDetails">{{ __('adminstaticword.Status') }}:</label>
																<input id="status_toggle" type="checkbox" name="status" class="custom_toggle" id="cb3" />
															@endif
														</div>
													</div>

													<div class="col-md-3">
														<div class="form-group">
															<label for="">{{ __('adminstaticword.Duration') }}: </label>
															<input id="duration1" type="checkbox" class="custom_toggle" name="duration_type" checked />

															<label class="tgl-btn" data-tg-off="days" data-tg-on="month" for="duration_type"></label>


															<br>
															<div class="form-group" id="duration">
																<label for="exampleInputSlug">{{ __('adminstaticword.BundleExpireDuration') }}
																</label>
																<input min="1" class="form-control" name="duration" type="number"
																	placeholder="{{ __('adminstaticword.Enter') }} Duration">
															</div>
														</div>
													</div>
												</div>

											</div>
											{{-- <div class="form-group">
                                                      <label
                                                          for="cbToggleSubscription">{{ __('adminstaticword.Subscription') }}:</label>
                                                      <input id="subscription1" type="checkbox" name="is_subscription_enabled"
                                                          class="custom_toggle" />
                                                      <br>
            
                                                      <small class="text-info"><i class="fa fa-question-circle"></i>
                                                          {{ __('Subscription
                                                                                bundle works with stripe payment only') }}.</small><br>
                                                      <small class="text-info">
                                                          {{ __('Enable it only when you have setup stripe') }}.</small>
            
            
                                                      <br>
                                                      <div id="subscription" class="form-group display-none ">
            
            
                                                          <div class="form-group">
            
                                                              <label>{{ __('adminstaticword.BillingPeriod') }}</label>
                                                              <select class="form-control select2" name="billing_interval">
                                                                  <option value="day">{{ __('Daily') }}</option>
                                                                  <option value="week">{{ __('Weekly') }}</option>
                                                                  <option value="month">{{ __('Monthly') }}</option>
                                                                  <option value="year">{{ __('Yearly') }}</option>
                                                              </select>
                                                          </div>
                                                      </div>
                                                  </div> --}}

											<div class="form-group">
												<button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i>
													{{ __('Reset') }}</button>
												<button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
													{{ __('Create') }}</button>
											</div>

											<div class="clear-both"></div>
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
					$('#j').val(+$(this).prop('checked'))
				})
			})

			$(function() {
				$('#cb3').change(function() {
					$('#test').val(+$(this).prop('checked'))
				})
			})


			$('#preview').on('change', function() {

				if ($('#preview').is(':checked')) {
					$('#document1').show('fast');
					$('#document2').hide('fast');
				} else {
					$('#document2').show('fast');
					$('#document1').hide('fast');
				}

			});

			$("#cb3").on('change', function() {
				if ($(this).is(':checked')) {
					$(this).attr('value', '1');
				} else {
					$(this).attr('value', '0');
				}
			});

			$(function() {

				$('#ms').change(function() {
					if ($('#ms').val() == 'yes') {
						$('#doabox').show();
					} else {
						$('#doabox').hide();
					}
				});

			});

			$(function() {

				$('#ms').change(function() {
					if ($('#ms').val() == 'yes') {
						$('#doaboxx').show();
					} else {
						$('#doaboxx').hide();
					}
				});

			});

			$(function() {

				$('#msd').change(function() {
					if ($('#msd').val() == 'yes') {
						$('#doa').show();
					} else {
						$('#doa').hide();
					}
				});

			});

			$(function() {
				var urlLike = '{{ url('
																                                      admin / dropdown ') }}';
				$('#category_id').change(function() {
					var up = $('#upload_id').empty();
					var cat_id = $(this).val();
					if (cat_id) {
						$.ajax({
							headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							},
							type: "GET",
							url: urlLike,
							data: {
								catId: cat_id
							},
							success: function(data) {
								console.log(data);
								up.append('<option value="0">Please Choose</option>');
								$.each(data, function(id, title) {
									up.append($('<option>', {
										value: id,
										text: title
									}));
								});
							},
							error: function(XMLHttpRequest, textStatus, errorThrown) {
								console.log(XMLHttpRequest);
							}
						});
					}
				});
			});

			$(function() {
				var urlLike = '{{ url('
																                                      admin / gcat ') }}';
				$('#upload_id').change(function() {
					var up = $('#grand').empty();
					var cat_id = $(this).val();
					if (cat_id) {
						$.ajax({
							headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							},
							type: "GET",
							url: urlLike,
							data: {
								catId: cat_id
							},
							success: function(data) {
								console.log(data);
								up.append('<option value="0">Please Choose</option>');
								$.each(data, function(id, title) {
									up.append($('<option>', {
										value: id,
										text: title
									}));
								});
							},
							error: function(XMLHttpRequest, textStatus, errorThrown) {
								console.log(XMLHttpRequest);
							}
						});
					}
				});
			});
		})(jQuery);
	</script>

	<script>
		(function($) {
			"use strict";
			$(function() {
				$('#cb111').change(function() {
					if ($('#cb111').is(':checked')) {
						$('#pricebox').show();
						console.log('uiytm,');
					} else {
						$('#pricebox').hide();
					}
				});


			});
		})(jQuery);
	</script>
	<script>
		(function($) {
			"use strict";
			$(function() {
				$('#duration1').change(function() {
					if ($('#duration1').is(':checked')) {
						$('#duration').show('fast');
					} else {
						$('#duration').hide('fast');
					}
				});


			});
		})(jQuery);
	</script>
	{{-- <script>
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
    </script> --}}

@endsection
