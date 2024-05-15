@extends('admin.layouts.master')
@section('title', 'All Quiz')
@section('maincontent')
	@component('components.breadcumb', ['secondaryactive' => 'active'])
		@slot('heading')
			{{ __('Quiz') }}
		@endslot

		@slot('menu1')
			{{ __('Quiz') }}
		@endslot
		@slot('button')
			<div class="col-md-4 col-lg-4">
				<div class="widgetbar">
					@if ($topic->type == null)
						{{-- <a href="{{ route('import.quiz',$topic->id) }}"  class="float-right btn btn-primary-rgba mr-2"><i class="feather icon-plus mr-2"></i>{{ __('Import Questions') }}</a> --}}
						<a data-toggle="modal" data-target="#myModalquiz" href="#" class="float-right btn btn-primary-rgba mr-2"><i
								class="feather icon-plus mr-2"></i>{{ __('Add Question') }}</a>
					@endif

					@if ($topic->type == '1')
						<a data-toggle="modal" data-target="#myModalquizsubject" class="float-right btn btn-primary-rgba mr-2"><i
								class="feather icon-plus mr-2"></i>{{ __('Add Question') }}</a>
					@endif


					<a href="{{ url('course/create/' . $topic->courses->id) }}" class="float-right btn btn-primary-rgba mr-2"><i
							class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>

				</div>
			</div>
		@endslot
	@endcomponent
	<div class="contentbar">
		<div class="row">
			@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			<div class="col-lg-12">
				<div class="card m-b-30">
					<div class="card-header">
						<h5 class="box-title">{{ __('All Quiz') }}</h5>
					</div>
					<div class="card-body">

						<div class="table-responsive">
							<table id="datatable-buttons" class="table table-striped table-bordered">
								<thead>
									<tr>

										<th>#</th>
										<th>{{ __('adminstaticword.Course') }}</th>
										<th>{{ __('adminstaticword.Topic') }}</th>
										<th>{{ __('adminstaticword.Question') }}</th>
										@if ($topic->type == null)
											<th>{{ __('adminstaticword.A') }}</th>
											<th>{{ __('adminstaticword.B') }}</th>
											<th>{{ __('adminstaticword.C') }}</th>
											<th>{{ __('adminstaticword.D') }}</th>
											<th>{{ __('adminstaticword.Answer') }}</th>
										@endif

										<th>{{ __('adminstaticword.Action') }}</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 0; ?>
									@foreach ($quizes as $quiz)
										<?php $i++; ?>
										<tr>
											<td><?php echo $i; ?></td>
											<td>{{ $quiz->courses->getTranslation('title', Session::get('changed_language'), false) }}</td>
											<td>{{ $quiz->topic->getTranslation('title', Session::get('changed_language'), false) }}</td>
											<td>{{ $quiz->getTranslation('question', Session::get('changed_language'), false) }}</td>
											@if ($topic->type == null)
												<td>{{ $quiz->getTranslation('a', Session::get('changed_language'), false) }}</td>
												<td>{{ $quiz->getTranslation('b', Session::get('changed_language'), false) }}</td>
												<td>{{ $quiz->getTranslation('c', Session::get('changed_language'), false) }}</td>
												<td>{{ $quiz->getTranslation('d', Session::get('changed_language'), false) }}</td>
												<td>{{ $quiz->answer }}</td>
											@endif
											<td>
												<div class="dropdown">
													<button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1"
														data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
															class="feather icon-more-vertical-"></i></button>
													<div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
														@if ($topic->type == null)
															<a class="dropdown-item" data-toggle="modal" data-target="#myModaledit{{ $quiz->id }}"><i
																	class="feather icon-edit mr-2"></i>{{ __('Edit') }}</a>
														@endif
														@if ($topic->type == '1')
															<a class="dropdown-item" data-toggle="modal" data-target="#myModaleditsub{{ $quiz->id }}"
																href="#"><i class="feather icon-edit mr-2"></i>{{ __('Edit') }}</a>
														@endif
														<a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $quiz->id }}">
															<i class="feather icon-delete mr-2"></i>{{ __('Delete') }}</a>
														</a>
													</div>
												</div>

												<!-- delete Modal start -->
												<div class="modal fade bd-example-modal-sm" id="delete{{ $quiz->id }}" tabindex="-1" role="dialog"
													aria-hidden="true">
													<div class="modal-dialog modal-sm">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<h4>{{ __('Are You Sure ?') }}</h4>
																<p>{{ __('Do you really want to delete') }} ? {{ __('This process cannot be undone.') }}</p>
															</div>
															<div class="modal-footer">
																<form method="post" action="{{ url('admin/questions/' . $quiz->id) }}" class="pull-right">
																	{{ csrf_field() }}
																	{{ method_field('DELETE') }}
																	<button type="reset" class="btn btn-secondary" data-dismiss="modal">{{ __('No') }}</button>
																	<button type="submit" class="btn btn-primary">{{ __('Yes') }}</button>
																</form>
															</div>
														</div>
													</div>
												</div>
												<!-- delete Model ended -->

											</td>


										</tr>

										<!--Model for edit question-->
										<div class="modal fade" id="myModaledit{{ $quiz->id }}" tabindex="-1" role="dialog"
											aria-labelledby="myModalLabel">
											<div class="modal-dialog modal-lg" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="my-modal-title">
															<b>{{ __('Edit Question') }}</b>
														</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
																aria-hidden="true">&times;</span></button>

													</div>
													<div class="box box-primary">
														<div class="panel panel-sum">
															<div class="modal-body">

																<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
																	<li class="nav-item">
																		<a
																			@if ($quiz->getTranslation('question', 'en', false) != null) class="nav-link active"
																				@else
																				class="nav-link" @endif
																			id="pills-english1-tab" data-toggle="pill" href="#pills-english1" role="tab"
																			aria-controls="pills-english1" aria-selected="true">{{ __('English') }}</a>
																	</li>
																	<li class="nav-item">
																		<a
																			@if ($quiz->getTranslation('question', 'en', false) != null) class="nav-link"
																				@else
																				class="nav-link active" @endif
																			id="pills-arabic1-tab" data-toggle="pill" href="#pills-arabic1" role="tab"
																			aria-controls="pills-arabic1" aria-selected="false">{{ __('Arabic') }}</a>
																	</li>
																</ul>

																<div class="tab-content" id="pills-tabContent">
																	<div
																		@if ($quiz->getTranslation('question', 'en', false) != null) class="tab-pane fade show active"
																			@else
																			class="tab-pane fade show" @endif
																		id="pills-english1" role="tabpanel" aria-labelledby="pills-english1-tab">

																		<form id="demo-form2" method="POST" action="{{ route('questions.update', $quiz->id) }}"
																			data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
																			{{ csrf_field() }}
																			{{ method_field('PUT') }}

																			<input type="hidden" name="lang" value="en" id="lang">

																			<input type="hidden" name="course_id" value="{{ $topic->course_id }}" />

																			<input type="hidden" name="topic_id" value="{{ $topic->id }}" />
																			<div class="row">
																				<div class="col-md-6">
																					<div class="col-md-12">
																						<label for="exampleInputTit1e">{{ __('adminstaticword.Question') }}</label>
																						<textarea name="question" rows="6" class="form-control" placeholder="Enter Your Question">{{ $quiz->getTranslation('question', 'en', false) }}</textarea>
																						<br>
																					</div>
																					<div class="col-md-12">
																						<label for="exampleInputDetails">{{ __('adminstaticword.Answer') }}:<sup
																								class="redstar">*</sup></label>
																						<select style="width: 100%" name="answer" class="form-control select2">
																							<option {{ $quiz->answer == 'A' ? 'selected' : '' }} value="A">
																								{{ __('adminstaticword.A') }}</option>
																							<option {{ $quiz->answer == 'B' ? 'selected' : '' }} value="B">
																								{{ __('adminstaticword.B') }}</option>
																							<option {{ $quiz->answer == 'C' ? 'selected' : '' }} value="C">
																								{{ __('adminstaticword.C') }}</option>
																							<option {{ $quiz->answer == 'D' ? 'selected' : '' }} value="D">
																								{{ __('adminstaticword.D') }}</option>
																						</select>
																					</div>
																					<br>
																					<h4 class="extras-heading">{{ __('Video And Image For Question') }}</h4>
																					<div class="form-group{{ $errors->has('question_video_link') ? ' has-error' : '' }}">


																						<label for="exampleInputDetails">{{ __('Add Video To Question') }} :<sup
																								class="redstar">*</sup></label>
																						<input type="text" name="question_video_link" class="form-control"
																							placeholder="https://myvideolink.com/embed/.." />
																						<small class="text-danger">{{ $errors->first('question_video_link') }}</small>
																						<small class="text-muted text-info"> <i class="text-dark feather icon-help-circle"></i>
																							{{ __('YouTube And Vimeo Video Support (Only Embed Code Link)') }}</small>
																					</div>
																				</div>
																				<div class="col-md-6">
																					<div class="col-md-12">

																						<label for="exampleInputDetails">{{ __('adminstaticword.AOption') }} :<sup
																								class="redstar">*</sup></label>
																						<input type="text" name="a" value="{{ $quiz->getTranslation('a', 'en', false) }}"
																							class="form-control" placeholder="Enter Option A">
																					</div>

																					<div class="col-md-12">
																						<label for="exampleInputDetails">{{ __('adminstaticword.BOption') }} :<sup
																								class="redstar">*</sup></label>
																						<input type="text" name="b" value="{{ $quiz->getTranslation('b', 'en', false) }}"
																							class="form-control" placeholder="Enter Option B" />
																					</div>

																					<div class="col-md-12">

																						<label for="exampleInputDetails">{{ __('adminstaticword.COption') }} :<sup
																								class="redstar">*</sup></label>
																						<input type="text" name="c" value="{{ $quiz->getTranslation('c', 'en', false) }}"
																							class="form-control" placeholder="Enter Option C" />
																					</div>

																					<div class="col-md-12">

																						<label for="exampleInputDetails">{{ __('adminstaticword.DOption') }} :<sup
																								class="redstar">*</sup></label>
																						<input type="text" name="d" value="{{ $quiz->getTranslation('d', 'en', false) }}"
																							class="form-control" placeholder="Enter Option D" />
																					</div>
																				</div>
																				<div class="form-group col-md-12">
																					<label class="text-dark" for="exampleInputSlug">{{ __('adminstaticword.Image') }}: </label>

																					<div class="input-group mb-3">

																						<div class="input-group-prepend">
																							<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
																						</div>


																						<div class="custom-file">

																							<input type="file" name="question_img" class="custom-file-input" id="question_img"
																								aria-describedby="inputGroupFileAddon01">
																							<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
																						</div>
																					</div>

																				</div>
																			</div>
																			<div class="form-group">
																				<button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i>
																					{{ __('Reset') }}</button>
																				<button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
																					{{ __('Update') }}</button>
																			</div>

																			<div class="clear-both"></div>


																		</form>

																	</div>

																	<div
																		@if ($quiz->getTranslation('question', 'en', false) != null) class="tab-pane fade show"
																			@else
																			class="tab-pane fade show active" @endif
																		id="pills-arabic1" role="tabpanel" aria-labelledby="pills-arabic1-tab">

																		<form id="demo-form2" method="POST" action="{{ route('questions.update', $quiz->id) }}"
																			data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
																			{{ csrf_field() }}
																			{{ method_field('PUT') }}

																			<input type="hidden" name="lang" value="ar" id="lang">


																			<input type="hidden" name="course_id" value="{{ $topic->course_id }}" />

																			<input type="hidden" name="topic_id" value="{{ $topic->id }}" />
																			<div class="row">
																				<div class="col-md-6">
																					<div class="col-md-12">
																						<label for="exampleInputTit1e">{{ __('adminstaticword.Question') }}</label>
																						<textarea name="question" rows="6" class="form-control" placeholder="Enter Your Question">{{ $quiz->getTranslation('question', 'ar', false) }}</textarea>
																						<br>
																					</div>
																					<div class="col-md-12">
																						<label for="exampleInputDetails">{{ __('adminstaticword.Answer') }}:<sup
																								class="redstar">*</sup></label>
																						<select style="width: 100%" name="answer" class="form-control select2">
																							<option {{ $quiz->answer == 'A' ? 'selected' : '' }} value="A">
																								{{ __('adminstaticword.A') }}</option>
																							<option {{ $quiz->answer == 'B' ? 'selected' : '' }} value="B">
																								{{ __('adminstaticword.B') }}</option>
																							<option {{ $quiz->answer == 'C' ? 'selected' : '' }} value="C">
																								{{ __('adminstaticword.C') }}</option>
																							<option {{ $quiz->answer == 'D' ? 'selected' : '' }} value="D">
																								{{ __('adminstaticword.D') }}</option>
																						</select>
																					</div>
																					<br>
																					<h4 class="extras-heading">{{ __('Video And Image For Question') }}</h4>
																					<div class="form-group{{ $errors->has('question_video_link') ? ' has-error' : '' }}">


																						<label for="exampleInputDetails">{{ __('Add Video To Question') }} :<sup
																								class="redstar">*</sup></label>
																						<input type="text" name="question_video_link" class="form-control"
																							placeholder="https://myvideolink.com/embed/.." />
																						<small class="text-danger">{{ $errors->first('question_video_link') }}</small>
																						<small class="text-muted text-info"> <i class="text-dark feather icon-help-circle"></i>
																							{{ __('YouTube And Vimeo Video Support (Only Embed Code Link)') }}</small>
																					</div>
																				</div>
																				<div class="col-md-6">
																					<div class="col-md-12">

																						<label for="exampleInputDetails">{{ __('adminstaticword.AOption') }} :<sup
																								class="redstar">*</sup></label>
																						<input type="text" name="a" value="{{ $quiz->getTranslation('a', 'ar', false) }}"
																							class="form-control" placeholder="Enter Option A">
																					</div>

																					<div class="col-md-12">
																						<label for="exampleInputDetails">{{ __('adminstaticword.BOption') }} :<sup
																								class="redstar">*</sup></label>
																						<input type="text" name="b" value="{{ $quiz->getTranslation('b', 'ar', false) }}"
																							class="form-control" placeholder="Enter Option B" />
																					</div>

																					<div class="col-md-12">

																						<label for="exampleInputDetails">{{ __('adminstaticword.COption') }} :<sup
																								class="redstar">*</sup></label>
																						<input type="text" name="c" value="{{ $quiz->getTranslation('c', 'ar', false) }}"
																							class="form-control" placeholder="Enter Option C" />
																					</div>

																					<div class="col-md-12">

																						<label for="exampleInputDetails">{{ __('adminstaticword.DOption') }} :<sup
																								class="redstar">*</sup></label>
																						<input type="text" name="d" value="{{ $quiz->getTranslation('d', 'ar', false) }}"
																							class="form-control" placeholder="Enter Option D" />
																					</div>
																				</div>
																				<div class="form-group col-md-12">
																					<label class="text-dark" for="exampleInputSlug">{{ __('adminstaticword.Image') }}: </label>

																					<div class="input-group mb-3">

																						<div class="input-group-prepend">
																							<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
																						</div>


																						<div class="custom-file">

																							<input type="file" name="question_img" class="custom-file-input" id="question_img"
																								aria-describedby="inputGroupFileAddon01">
																							<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
																						</div>
																					</div>

																				</div>
																			</div>
																			<div class="form-group">
																				<button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i>
																					{{ __('Reset') }}</button>
																				<button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
																					{{ __('Update') }}</button>
																			</div>

																			<div class="clear-both"></div>


																		</form>

																	</div>

																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!--Model close -->

										<!--Model for edit question-->
										{{-- <div class="modal fade" id="myModaleditsub{{ $quiz->id }}" tabindex="-1" role="dialog"
											aria-labelledby="myModalLabel">
											<div class="modal-dialog modal-lg" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
																aria-hidden="true">&times;</span></button>
														{{ __('adminstaticword.Question') }}</h4>
													</div>
													<div class="box box-primary">
														<div class="panel panel-sum">
															<div class="modal-body">
																<form id="demo-form2" method="POST" action="{{ route('questions.update', $quiz->id) }}"
																	data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
																	{{ csrf_field() }}
																	{{ method_field('PUT') }}

																	<input type="hidden" name="course_id" value="{{ $topic->course_id }}" />

																	<input type="hidden" name="topic_id" value="{{ $topic->id }}" />

																	<input type="hidden" name="type" value="1" />

																	<div class="row">
																		<div class="col-md-12">
																			<label for="exampleInputTit1e">{{ __('adminstaticword.Question') }}</label>
																			<textarea name="question" rows="6" class="form-control" placeholder="Enter Your Question">{{ $quiz->question }}</textarea>
																			<br>
																		</div>


																	</div>
																	<br>



																	<div class="col-md-12">
																		<div class="extras-block">
																			<h4 class="extras-heading">{{ __('Images And Video For Question') }}</h4>
																			<div class="row">
																				<div class="col-md-6">
																					<div class="form-group{{ $errors->has('question_video_link') ? ' has-error' : '' }}">


																						<label for="exampleInputDetails">{{ __('Add Video To Question') }} :<sup
																								class="redstar">*</sup></label>
																						<input type="text" name="question_video_link" value="{{ $quiz->question_video_link }}"
																							class="form-control" placeholder="https://myvideolink.com/embed/.." />

																						<small class="text-danger">{{ $errors->first('question_video_link') }}</small>
																						<small class="text-muted text-info"> <i
																								class="text-dark feather icon-help-circle"></i>{{ __('YouTube Video Support (Only Embed Code LinkG') }}</small>

																					</div>
																				</div>
																				<div class="col-md-6">
																					<div class="form-group{{ $errors->has('question_img') ? ' has-error' : '' }}">


																						<label for="exampleInputDetails">{{ __('Add Image To Question') }} :<sup
																								class="redstar">*</sup></label>
																						<input type="file" name="question_img" class="form-control" />


																						<small class="text-danger">{{ $errors->first('question_img') }}</small>
																						<small class="text-muted text-info"> <i class="text-dark feather icon-help-circle"></i>
																							{{ __('Please Choose Only .JPG, .JPEG and .PNG') }}</small>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>


																	<div class="form-group">
																		<button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i>
																			{{ __('Reset') }} </button>
																		<button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
																			{{ __('Update') }}</button>
																	</div>

																	<div class="clear-both"></div>
																</form>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div> --}}
										<!--Model close -->
									@endforeach

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>



		<div class="modal fade" id="myModalquiz" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel"> {{ __('adminstaticword.Add') }}
							{{ __('adminstaticword.Question') }}
						</h4>
					</div>
					<div class="box box-primary">
						<div class="panel panel-sum">

							<div class="modal-body">

								<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
									<li class="nav-item">
										<a
											@if (Session::get('changed_language') == 'en') class="nav-link active"
												@else
												class="nav-link" @endif
											id="pills-english-tab" data-toggle="pill" href="#pills-english" role="tab"
											aria-controls="pills-english" aria-selected="true">{{ __('English') }}</a>
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

										<form id="demo-form2" method="post" action="{{ route('questions.store') }}" data-parsley-validate
											class="form-horizontal form-label-left" enctype="multipart/form-data">
											{{ csrf_field() }}

											<input type="hidden" name="lang" value="en" id="lang">

											<input type="hidden" name="course_id" value="{{ $topic->course_id }}" />

											<input type="hidden" name="topic_id" value="{{ $topic->id }}" />


											<div class="row">
												<div class="col-md-6">
													<div class="col-md-12">
														<label for="exampleInputTit1e">{{ __('adminstaticword.Question') }}</label>
														<textarea name="question" rows="6" class="form-control" placeholder="Enter Your Question"></textarea>
														<br>
													</div>
													<div class="col-md-12">
														<label for="exampleInputDetails">{{ __('adminstaticword.Answer') }}:<sup
																class="redstar">*</sup></label>
														<select style="width: 100%" name="answer" class="form-control select2">
															<option value="none" selected disabled hidden>
																{{ __('adminstaticword.SelectanOption') }}
															</option>
															<option value="A">{{ __('adminstaticword.A') }}</option>
															<option value="B">{{ __('adminstaticword.B') }}</option>
															<option value="C">{{ __('adminstaticword.C') }}</option>
															<option value="D">{{ __('adminstaticword.D') }}</option>
														</select>
													</div>
													<br>
													<h4 class="extras-heading">{{ __('Video And Image For Question') }}</h4>
													<div class="form-group{{ $errors->has('question_video_link') ? ' has-error' : '' }}">


														<label for="exampleInputDetails">{{ __('Add Video To Question') }} :<sup
																class="redstar">*</sup></label>
														<input type="text" name="question_video_link" class="form-control"
															placeholder="https://myvideolink.com/embed/.." />
														<small class="text-danger">{{ $errors->first('question_video_link') }}</small>
														<small class="text-muted text-info"> <i class="text-dark feather icon-help-circle"></i>
															{{ __('Back') }}YouTube Video Support (Only Embed Code Link)</small>
													</div>
												</div>
												<div class="col-md-6">
													<div class="col-md-6">

														<label for="exampleInputDetails">{{ __('adminstaticword.AOption') }} :<sup
																class="redstar">*</sup></label>
														<input type="text" name="a" class="form-control" placeholder="Enter Option A">
													</div>

													<div class="col-md-6">
														<label for="exampleInputDetails">{{ __('adminstaticword.BOption') }} :<sup
																class="redstar">*</sup></label>
														<input type="text" name="b" class="form-control" placeholder="Enter Option B" />
													</div>

													<div class="col-md-6">

														<label for="exampleInputDetails">{{ __('adminstaticword.COption') }} :<sup
																class="redstar">*</sup></label>
														<input type="text" name="c" class="form-control" placeholder="Enter Option C" />
													</div>

													<div class="col-md-6">

														<label for="exampleInputDetails">{{ __('adminstaticword.DOption') }} :<sup
																class="redstar">*</sup></label>
														<input type="text" name="d" class="form-control" placeholder="Enter Option D" />
													</div>
												</div>
												<div class="form-group col-md-6">
													<label class="text-dark" for="exampleInputSlug">{{ __('adminstaticword.Image') }}: </label>

													<div class="input-group mb-3">

														<div class="input-group-prepend">
															<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Back') }}Upload</span>
														</div>


														<div class="custom-file">

															<input type="file" name="question_img" class="custom-file-input" id="question_img"
																aria-describedby="inputGroupFileAddon01">
															<label class="custom-file-label" for="inputGroupFile01">{{ __('Back') }}Choose file</label>
														</div>
													</div>

												</div>
											</div>

											<div class="form-group">
												<button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i>
													{{ __('Back') }}Reset</button>
												<button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
													{{ __('Back') }}Create</button>
											</div>

											<div class="clear-both"></div>

										</form>

									</div>

									<div
										@if (Session::get('changed_language') == 'en') class="tab-pane fade show"
                        @else
                        class="tab-pane fade show active" @endif
										id="pills-arabic" role="tabpanel" aria-labelledby="pills-arabic-tab">

										<form id="demo-form2" method="post" action="{{ route('questions.store') }}" data-parsley-validate
											class="form-horizontal form-label-left" enctype="multipart/form-data">
											{{ csrf_field() }}

											<input type="hidden" name="lang" value="ar" id="lang">

											<input type="hidden" name="course_id" value="{{ $topic->course_id }}" />

											<input type="hidden" name="topic_id" value="{{ $topic->id }}" />


											<div class="row">
												<div class="col-md-6">
													<div class="col-md-12">
														<label for="exampleInputTit1e">{{ __('adminstaticword.Question') }}</label>
														<textarea name="question" rows="6" class="form-control" placeholder="Enter Your Question"></textarea>
														<br>
													</div>
													<div class="col-md-12">
														<label for="exampleInputDetails">{{ __('adminstaticword.Answer') }}:<sup
																class="redstar">*</sup></label>
														<select style="width: 100%" name="answer" class="form-control select2">
															<option value="none" selected disabled hidden>
																{{ __('adminstaticword.SelectanOption') }}
															</option>
															<option value="A">{{ __('adminstaticword.A') }}</option>
															<option value="B">{{ __('adminstaticword.B') }}</option>
															<option value="C">{{ __('adminstaticword.C') }}</option>
															<option value="D">{{ __('adminstaticword.D') }}</option>
														</select>
													</div>
													<br>
													<h4 class="extras-heading">{{ __('Video And Image For Question') }}</h4>
													<div class="form-group{{ $errors->has('question_video_link') ? ' has-error' : '' }}">


														<label for="exampleInputDetails">{{ __('Add Video To Question') }} :<sup
																class="redstar">*</sup></label>
														<input type="text" name="question_video_link" class="form-control"
															placeholder="https://myvideolink.com/embed/.." />
														<small class="text-danger">{{ $errors->first('question_video_link') }}</small>
														<small class="text-muted text-info"> <i class="text-dark feather icon-help-circle"></i>
															{{ __('Back') }}YouTube Video Support (Only Embed Code Link)</small>
													</div>
												</div>
												<div class="col-md-6">
													<div class="col-md-6">

														<label for="exampleInputDetails">{{ __('adminstaticword.AOption') }} :<sup
																class="redstar">*</sup></label>
														<input type="text" name="a" class="form-control" placeholder="Enter Option A">
													</div>

													<div class="col-md-6">
														<label for="exampleInputDetails">{{ __('adminstaticword.BOption') }} :<sup
																class="redstar">*</sup></label>
														<input type="text" name="b" class="form-control" placeholder="Enter Option B" />
													</div>

													<div class="col-md-6">

														<label for="exampleInputDetails">{{ __('adminstaticword.COption') }} :<sup
																class="redstar">*</sup></label>
														<input type="text" name="c" class="form-control" placeholder="Enter Option C" />
													</div>

													<div class="col-md-6">

														<label for="exampleInputDetails">{{ __('adminstaticword.DOption') }} :<sup
																class="redstar">*</sup></label>
														<input type="text" name="d" class="form-control" placeholder="Enter Option D" />
													</div>
												</div>
												<div class="form-group col-md-6">
													<label class="text-dark" for="exampleInputSlug">{{ __('adminstaticword.Image') }}: </label>

													<div class="input-group mb-3">

														<div class="input-group-prepend">
															<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Back') }}Upload</span>
														</div>


														<div class="custom-file">

															<input type="file" name="question_img" class="custom-file-input" id="question_img"
																aria-describedby="inputGroupFileAddon01">
															<label class="custom-file-label" for="inputGroupFile01">{{ __('Back') }}Choose file</label>
														</div>
													</div>

												</div>
											</div>

											<div class="form-group">
												<button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i>
													{{ __('Back') }}Reset</button>
												<button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
													{{ __('Back') }}Create</button>
											</div>

											<div class="clear-both"></div>

										</form>

									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--Model close -->


		<!--Model for add question -->
		{{-- <div class="modal fade" id="myModalquizsubject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">&times;</span></button>
					</div>
					<div class="box box-primary">
						<div class="panel panel-sum">
							<div class="modal-body">
								<form id="demo-form2" method="post" action="{{ route('questions.store') }}" data-parsley-validate
									class="form-horizontal form-label-left" enctype="multipart/form-data">
									{{ csrf_field() }}

									<input type="hidden" name="course_id" value="{{ $topic->course_id }}" />

									<input type="hidden" name="topic_id" value="{{ $topic->id }}" />

									<input type="hidden" name="type" value="1" />

									<div class="row">
										<div class="col-md-12">
											<label for="exampleInputTit1e">{{ __('adminstaticword.Question') }}</label>
											<textarea name="question" rows="6" class="form-control" placeholder="Enter Your Question"></textarea>
											<br>
										</div>


									</div>
									<br>

									<div class="col-md-12">
										<div class="extras-block">
											<h4 class="extras-heading">{{ __('Back') }}Video And Image For Question</h4>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group{{ $errors->has('question_video_link') ? ' has-error' : '' }}">


														<label for="exampleInputDetails">{{ __('Back') }}Add Video To Question :<sup
																class="redstar">*</sup></label>
														<input type="text" name="question_video_link" class="form-control"
															placeholder="https://myvideolink.com/embed/.." />
														<small class="text-danger">{{ $errors->first('question_video_link') }}</small>
														<small class="text-muted text-info"> <i class="text-dark feather icon-help-circle"></i>
															{{ __('Back') }}YouTube Video Support (Only Embed Code Link)</small>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group{{ $errors->has('question_img') ? ' has-error' : '' }}">

														<label for="exampleInputDetails">{{ __('Back') }}Add Image To Question :<sup
																class="redstar">*</sup></label>
														<input type="file" name="question_img" class="form-control" />
														<small class="text-danger">{{ $errors->first('question_img') }}</small>
														<small class="text-muted text-info"> <i class="text-dark feather icon-help-circle"></i>
															{{ __('Back') }}Please Choose Only .JPG, .JPEG and .PNG</small>


													</div>
												</div>
												<br>

												<br>
											</div>
										</div>
									</div>

									<div class="form-group">
										<button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i> {{ __('Back') }}Reset</button>
										<button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
											{{ __('Back') }}Create</button>
									</div>

									<div class="clear-both"></div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> --}}
	</div>
@endsection
