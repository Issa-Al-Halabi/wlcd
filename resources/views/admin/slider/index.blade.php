@extends('admin.layouts.master')
@section('title', 'Slider - Admin')
@section('maincontent')
	@component('components.breadcumb', ['thirdactive' => 'active'])
		@slot('heading')
			{{ __('Slider') }}
		@endslot
		@slot('menu1')
			{{ __('Front Settings') }}
		@endslot
		@slot('menu2')
			{{ __('Slider') }}
		@endslot

		@slot('button')
			<div class="col-md-4 col-lg-4">
				<div class="widgetbar">
					<!--@can('front-settings.sliders.create')
				-->
						<!--  <a href="{{ url('slider/create') }}" class="btn btn-primary-rgba"><i class="feather icon-plus mr-2"></i>{{ __('Add Slider') }}</a>-->
						<!--
			@endcan-->
					<!--@can('front-settings.sliders.delete')
				-->
						<!--<a href="page-product-detail.html" class="btn btn-danger-rgba"  data-toggle="modal" data-target=".bd-example-modal-sm1"><i class="feather icon-trash mr-2"></i>{{ __('Delete Selected') }}</a>-->
						<!--
			@endcan                     -->
					<div class="modal fade bd-example-modal-sm1" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">{{ __('Delete') }}</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body text-center">
									<p class="text-muted">{{ __('Do you really want to delete these records? This process cannot be undone.') }}</p>
								</div>
								<div class="modal-footer">


									<form method="post" action="{{ action('BulkdeleteController@sliderdeleteAll') }}
                      "
										id="bulk_delete_form" data-parsley-validate class="form-horizontal form-label-left">
										{{ csrf_field() }}

										<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('No') }}</button>
										<button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
									</form>
								</div>
							</div>
						</div>
					</div>
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
		<!-- Start row -->
		<div class="row">

			<div class="col-lg-12">
				<div class="card m-b-30">
					<div class="card-header">
						<h5 class="card-title">{{ __('Sliders') }}</h5>
					</div>
					<div class="card-body">

						<div class="table-responsive">
							<table id="datatable-buttons" class="table table-striped table-bordered">
								<thead>
									<tr>

										<!-- <th>-->
										<!--   <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]" value="all" id="checkboxAll">-->
										<!--   <label for="checkboxAll" class="material-checkbox"></label>-->
										<!--    #-->
										<!--</th>-->
										<!--<th>{{ __('adminstaticword.Image') }}</th>-->
										<th>{{ __('adminstaticword.Heading') }}</th>
										<th>{{ __('adminstaticword.Detail') }}</th>
										<!--<th>{{ __('adminstaticword.Status') }}</th>-->
										<th>{{ __('adminstaticword.Action') }}</th>

									</tr>
								</thead>
								<tbody>
									<?php $i = 0; ?>
									@foreach ($sliders as $cat)
										<?php $i++; ?>
										<tr>
											<!--<td> -->
											<!--<input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="{{ $cat->id }}" id="checkbox{{ $cat->id }}">-->
											<!--<label for="checkbox{{ $cat->id }}" class="material-checkbox"></label>-->
											<!-- <?php echo $i; ?> -->
											<!-- </td> -->
											<!--<td>-->
											<!--  <img src="{{ asset('images/slider/' . $cat->image) }}" class="img-responsive img-circle" >-->
											<!--</td>-->
											<td>{{ $cat->getTranslation('heading', app()->getlocale()) }}</td>
											<td>{{ $cat->getTranslation('detail', app()->getlocale()) }}</td>
											<!-- <td>-->
											<!--  <button type="button" class="btn btn-rounded {{ ($cat->status == '1' ? 'checked' : '') ? 'btn-success-rgba' : 'btn-danger-rgba' }}" data-toggle="modal" data-target="#myModal">-->
											<!--    @if ($cat->status)
	-->
											<!--      {{ __('adminstaticword.Active') }}-->
										<!--      @else-->
											<!--      {{ __('adminstaticword.Deactive') }}-->
											<!--
	@endif -->
											<!--</button>-->
											<!-- </td>-->
											{{-- <td>
                                  <label class="switch">
                                    <input class="slider" type="checkbox"  data-id="{{$cat->id}}" name="status" {{ $cat->status == '1' ? 'checked' : '' }}>
                                    <span class="knob"></span>
                                  </label>
                                 
                                </td> --}}

											<td>
												<div class="dropdown">
													<button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3"
														data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
															class="feather icon-more-vertical-"></i></button>
													<div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
														@can('front-settings.sliders.edit')
															<a class="dropdown-item" href="{{ url('slider/' . $cat->id) }}"><i
																	class="feather icon-edit mr-2"></i>{{ __('Edit') }}</a>
														@endcan
														<!--@can('front-settings.sliders.delete')
		-->
															<!--<a class="dropdown-item" data-toggle="modal" data-target=".bd-example-modal-sm"><i class="feather icon-delete mr-2"></i>{{ __('Delete') }}</a>-->
															<!--
	@endcan-->
													</div>
												</div>
											</td>
											<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
												<div class="modal-dialog modal-sm">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															<p class="text-muted">
																{{ __('Do you really want to delete these records? This process cannot be undone.') }}</p>
														</div>
														<div class="modal-footer">
															<form method="post"
																action="{{ url('slider/' . $cat->id) }}
                                                      "data-parsley-validate
																class="form-horizontal form-label-left">
																{{ csrf_field() }}
																{{ method_field('DELETE') }}
																<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('No') }}</button>
																<button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
															</form>
														</div>
													</div>
												</div>
											</div>




										</tr>
									@endforeach


								</tbody>

							</table>
						</div>
					</div>
				</div>
			</div>
			<!-- End col -->
		</div>
		<!-- End row -->
	</div>


@endsection



@section('scripts')



	<script>
		"use Strict";

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$(function() {
			$(document).on("change", ".slider", function() {

				$.ajax({
					type: "GET",
					dataType: "json",
					url: '{{ url('quickupdate/slider') }}',
					data: {
						'status': $(this).is(':checked') ? 1 : 0,
						'id': $(this).data('id')
					},
					success: function(data) {
						var warning = new PNotify({
							title: 'success',
							text: 'Status Update Successfully',
							type: 'success',
							desktop: {
								desktop: true,
								icon: 'feather icon-thumbs-down'
							}
						});
						warning.get().click(function() {
							warning.remove();
						});
					}
				});
			})


		})
	</script>


@endsection
