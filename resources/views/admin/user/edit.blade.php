@extends('admin.layouts.master')
@section('title', 'Edit User')
@section('maincontent')

	@component('components.breadcumb', ['thirdactive' => 'active'])
		@slot('heading')
			{{ __('Home') }}
		@endslot

		@slot('menu1')
			{{ __('Admin') }}
		@endslot

		@slot('menu2')
			{{ __(' Edit User') }}
		@endslot

		@slot('button')
			<div class="col-md-4 col-lg-4">
				<a href="{{ route('user.index') }}" class="float-right btn btn-primary-rgba mr-2"><i
						class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
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
			<div class="col-lg-12">
				<div class="card m-b-30">
					<div class="card-header">
						<h5 class="box-title">{{ __('adminstaticword.Edit') }} {{ __('adminstaticword.User') }}</h5>
					</div>
					<div class="card-body ml-2">
						<form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
							{{ csrf_field() }}
							{{ method_field('PUT') }}
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="fname">
											{{ __('adminstaticword.FirstName') }}:
											<sup class="text-danger">*</sup>
										</label>
										<input value="{{ $user->fname }}" autofocus required name="fname" type="text" class="form-control"
											placeholder="{{ __('adminstaticword.Please') }} {{ __('adminstaticword.Enter') }} {{ __('adminstaticword.FirstName') }}" />
									</div>
									<div class="form-group">
										<label for="lname">
											{{ __('adminstaticword.LastName') }}:
											<sup class="text-danger">*</sup>
										</label>
										<input value="{{ $user->lname }}" required name="lname" type="text" class="form-control"
											placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.LastName') }}" />
									</div>

									<div class="form-group">
										<label for="mobile"> {{ __('adminstaticword.Mobile') }}:</label>
										<input value="{{ $user->mobile }}" type="text" name="mobile"
											placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Mobile') }}" class="form-control">
									</div>
									<div class="form-group">
										<label for="mobile">{{ __('adminstaticword.Email') }}:<sup class="text-danger">*</sup> </label>
										<input value="{{ $user->email }}" required type="email" name="email"
											placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Email') }}" class="form-control">
									</div>
									<div class="form-group">
										<label for="address">{{ __('adminstaticword.Address') }}: </label>
										<textarea name="address" class="form-control" rows="1" placeholder="{{ __('adminstaticword.Enter') }} adderss"
										 value="">{{ $user->address }}</textarea>
									</div>

									<div class="form-group">
										<label class="text-dark" for="dob">{{ __('adminstaticword.DateofBirth') }}:
										</label>
										<input value="{{ $user->dob }}" type="text" id="default-date" class="form-control" name="dob"
											placeholder="yyyy/mm/dd" aria-describedby="basic-addon2" />
										<div class="input-group-append">
											<span class="input-group-text" id="basic-addon2"><i class="feather icon-calendar"></i></span>
										</div>
									</div>

									<div @if ($user->role != 'admin' && $user->role != 'instructor') style="display: none;" @endif id="instructor-info">
										<div class="form-group">
											<label for="exampleInputSlug">{{ __('adminstaticword.practical_experience') }}</label>
											<select class="select2-multi-select form-control" id="practical_experience" name="practical_experience[]" multiple="multiple">
												@if (is_array($user['practical_experience']) || is_object($user['practical_experience']))

													@foreach ($user['practical_experience'] as $cat)
														<option value="{{ $cat }}"
															{{ in_array($cat, $user['practical_experience'] ?: []) ? 'selected' : '' }}>
															{{ $cat }}
														</option>
													@endforeach
												@endif
											</select>
										</div>

										<div class="form-group">
											<label for="exampleInputSlug">{{ __('adminstaticword.professional_summary') }}</label>
											<select class="select2-multi-select form-control" id="professional_summary" name="professional_summary[]" multiple="multiple">
												@if (is_array($user['professional_summary']) || is_object($user['professional_summary']))

													@foreach ($user['professional_summary'] as $cat)
														<option value="{{ $cat }}"
															{{ in_array($cat, $user['professional_summary'] ?: []) ? 'selected' : '' }}>
															{{ $cat }}
														</option>
													@endforeach
												@endif
											</select>
										</div>
									</div>

									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<div class="update-password">
													<label for="box1">
														{{ __('adminstaticword.UpdatePassword') }}:</label>
													<input type="checkbox" id="myCheck" name="update_pass" class="custom_toggle" onclick="myFunction()">
												</div>
											</div>
										</div>

										<div style="display: none" id="update-password">
											<div class="form-group">
												<label>{{ __('adminstaticword.Password') }}</label>
												<input type="password" name="password" class="form-control"
													placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Password') }}">
											</div>


											<div class="form-group">
												<label>{{ __('adminstaticword.ConfirmPassword') }}</label>
												<input type="password" name="confirmpassword" class="form-control"
													placeholder="{{ __('adminstaticword.ConfirmPassword') }}">
											</div>
										</div>
									</div>

								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="role">{{ __('adminstaticword.SelectRole') }}:</label>
										@if (Auth::User()->role == 'admin')
											<select class="form-control select2" id="role" name="role">
												<option value="">{{ __('Please select role') }}</option>
												@foreach ($roles as $role)
													<option {{ $user->getRoleNames()->contains($role->name) ? 'selected' : '' }} value="{{ $role->name }}">
														{{ $role->name }}</option>
												@endforeach
											</select>
										@endif
										@if (Auth::User()->role == 'instructor')
											<select class="form-control select2" name="role">
												<option {{ $user->role == 'user' ? 'selected' : '' }} value="user">
													{{ __('adminstaticword.User') }}
												</option>
												<option {{ $user->role == 'instructor' ? 'selected' : '' }} value="instructor">
													{{ __('adminstaticword.Instructor') }}</option>
											</select>
										@endif
									</div>
									<div class="form-group">
										<label for="city_id">{{ __('adminstaticword.Country') }}:</label>
										<select id="country_id" class="form-control select2" name="country_id">
											<option value="none" selected disabled hidden>
												{{ __('adminstaticword.SelectanOption') }}
											</option>

											@foreach ($countries as $coun)
												<option value="{{ $coun->country_id }}" {{ $user->country_id == $coun->country_id ? 'selected' : '' }}>
													{{ $coun->nicename }}
												</option>
											@endforeach
										</select>
									</div>
									<div class="form-group">
										<label for="city_id">{{ __('adminstaticword.State') }}:</label>
										<select id="upload_id" class="form-control select2" name="state_id">
											<option value="none" selected disabled hidden>
												{{ __('adminstaticword.SelectanOption') }}
											</option>
											@foreach ($states as $s)
												<option value="{{ $s->state_id }}" {{ $user->state_id == $s->state_id ? 'selected' : '' }}>
													{{ $s->name }}
												</option>
											@endforeach

										</select>
									</div>
									<div class="form-group">
										<label for="city_id">{{ __('adminstaticword.City') }}:</label>
										<select id="grand" class="form-control select2" name="city_id">
											<option value="none" selected disabled hidden>
												{{ __('adminstaticword.SelectanOption') }}
											</option>
											@foreach ($cities as $c)
												<option value="{{ $c->id }}" {{ $user->city_id == $c->id ? 'selected' : '' }}>{{ $c->name }}
												</option>
											@endforeach
										</select>
									</div>
									{{-- <div class="form-group">
                                        <label for="pin_code">{{ __('adminstaticword.Pincode') }}:</label>
                                        <input value="{{ $user->pin_code }}"
                                            placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Pincode') }}"
                                            type="text" name="pin_code" class="form-control">
                                    </div> --}}



									<div class="form-group">
										<label>{{ __('adminstaticword.Image') }}:<sup class="redstar">*</sup></label>
										<small class="text-muted"><i class="fa fa-question-circle"></i>
											{{ __('adminstaticword.Recommendedsize') }} (410 x 410px)</small>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
											</div>
											<div class="custom-file">
												<input type="file" class="custom-file-input" id="inputGroupFile01" name="user_img"
													aria-describedby="inputGroupFileAddon01">
												<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
											</div>
										</div>
										@if ($user->user_img != null || $user->user_img != '')
											<div class="edit-user-img">
												<img src="{{ url('/images/user_img/' . $user->user_img) }}" alt="User Image"
													class="img-responsive image_size">
											</div>
										@else
											<div class="edit-user-img">
												<img src="{{ asset('images/default/user.jpg') }}" alt="User Image" class="img-responsive img-circle">
											</div>
										@endif
									</div>

									<div @if ($user->role != 'admin' && $user->role != 'instructor') style="display: none;" @endif id="instructor-info2">
										<div class="form-group">
											<label for="exampleInputSlug">{{ __('adminstaticword.basic_skills') }}</label>
											<select class="select2-multi-select form-control" id="basic_skills" name="basic_skills[]" multiple="multiple">
												@if (is_array($user['basic_skills']) || is_object($user['basic_skills']))

													@foreach ($user['basic_skills'] as $cat)
														<option value="{{ $cat }}" {{ in_array($cat, $user['basic_skills'] ?: []) ? 'selected' : '' }}>
															{{ $cat }}
														</option>
													@endforeach
												@endif
											</select>
										</div>

										<div class="form-group">
											<label for="exampleInputSlug">{{ __('adminstaticword.scientific_background') }}</label>
											<select class="select2-multi-select form-control" id="scientific_background" name="scientific_background[]" multiple="multiple">
												@if (is_array($user['scientific_background']) || is_object($user['scientific_background']))

													@foreach ($user['scientific_background'] as $cat)
														<option value="{{ $cat }}"
															{{ in_array($cat, $user['scientific_background'] ?: []) ? 'selected' : '' }}>
															{{ $cat }}
														</option>
													@endforeach
												@endif
											</select>
										</div>

										<div class="form-group">
											<label for="exampleInputSlug">{{ __('adminstaticword.Courses') }}</label>
											<select class="select2-multi-select form-control" id="courses" name="courses[]" multiple="multiple">
												@if (is_array($user['courses']) || is_object($user['courses']))

													@foreach ($user['courses'] as $cat)
														<option value="{{ $cat }}" {{ in_array($cat, $user['courses'] ?: []) ? 'selected' : '' }}>
															{{ $cat }}
														</option>
													@endforeach
												@endif
											</select>
										</div>
									</div>


								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label for="detail">{{ __('adminstaticword.Detail') }}:<sup class="text-danger">*</sup></label>
										<textarea id="detail" name="detail" class="form-control" rows="5"
										 placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Detail') }}" value="">{{ $user->detail }}</textarea>
									</div>
								</div>
							</div>

							<div class="row">
								{{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fb_url">
                                            {{ __('adminstaticword.FacebookUrl') }}:
                                        </label>
                                        <input autofocus name="fb_url" value="{{ $user->fb_url }}" type="text"
                                            class="form-control" placeholder="Facebook.com/" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="youtube_url">
                                            {{ __('adminstaticword.YoutubeUrl') }}:
                                        </label>
                                        <input autofocus name="youtube_url" value="{{ $user->youtube_url }}"
                                            type="text" class="form-control" placeholder="youtube.com/" />

                                    </div>
                                </div> --}}
								{{-- <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="twitter_url">
                                            {{ __('adminstaticword.TwitterUrl') }}:
                                        </label>
                                        <input autofocus name="twitter_url" value="{{ $user->twitter_url }}"
                                            type="text" class="form-control" placeholder="Twitter.com/" />
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="linkedin_url">
                                            {{ __('adminstaticword.LinkedInUrl') }}:
                                        </label>
                                        <input autofocus name="linkedin_url" value="{{ $user->linkedin_url }}"
                                            type="text" class="form-control" placeholder="Linkedin.com/" />
                                    </div> --}}
							</div>
							<div class="row">

								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputDetails">{{ __('adminstaticword.Verified') }}:<sup
												class="redstar text-danger">*</sup></label><br>
										<input id="verified" type="checkbox" class="custom_toggle" name="verified"
											{{ $user->email_verified_at != null ? 'checked' : '' }} />


									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputTit1e">{{ __('adminstaticword.Status') }}:<sup
												class="text-danger">*</sup></label><br>
										<input type="checkbox" class="custom_toggle" name="status" {{ $user->status == '1' ? 'checked' : '' }} />

									</div>
								</div>
							</div>


							<div class="row">
								<div class="col-md-12 form-group">
									<button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i>
										{{ __('Reset') }}</button>
									<button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
										{{ __('Update') }}</button>
								</div>
							</div>
					</div>

					<div class="clear-both"></div>

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

			// $(function() {
			//     $("#dob,#doa").datepicker({
			//         changeYear: true,
			//         yearRange: "-100:+0",
			//         dateFormat: 'yy/mm/dd',
			//     });
			// });
			$(function() {
				$("#dob").datepicker({
					language: 'en',
					// changeYear: true,
					// yearRange: "-100:+0",
					dateFormat: 'yyyy-mm-dd',
				});
			});


			$('#married_status').change(function() {

				if ($(this).val() == 'Married') {
					$('#doaboxxx').show();
				} else {
					$('#doaboxxx').hide();
				}
			});

			$(function() {
				var urlLike =
					'{{ url('
																																													                                                                                                                                      country / dropdown ') }}';
				$('#country_id').change(function() {
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
				var urlLike =
					'{{ url('
																																													                                                                                                                                      country / gcity ') }}';
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
				$('#myCheck').change(function() {
					if ($('#myCheck').is(':checked')) {
						$('#update-password').show('fast');
					} else {
						$('#update-password').hide('fast');
					}
				});

			});
			$(function() {
				$('#role').on('change', function() {
					var opt = $(this).val();

					if (opt == 'admin' || opt == 'instructor') {
						$('#instructor-info').show();
						$('#instructor-info2').show();
					} else {
						$('#instructor-info').hide('fast');
						$('#instructor-info2').hide('fast');
					}
				});
			});

			$(function() {
				$("#professional_summary").select2({
					// placeHolder: "Select One",
					// allowClear: true,
					tags: true,
					tokenSeparators: [',']
				});
			})
			$(function() {
				$("#practical_experience").select2({
					tags: true,
					tokenSeparators: [',']
				});
			})
			$(function() {
				$("#basic_skills").select2({
					tags: true,
					tokenSeparators: [',']
				});
			})
			$(function() {
				$("#scientific_background").select2({
					tags: true,
					tokenSeparators: [',']
				});
			})
			$(function() {
				$("#courses").select2({
					tags: true,
					tokenSeparators: [',']
				});
			})

		})(jQuery);
	</script>

@endsection
