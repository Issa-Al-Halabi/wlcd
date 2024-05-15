@extends('admin.layouts.master')
@section('title', 'All Quiz Review')
@section('maincontent')
	@component('components.breadcumb', ['secondaryactive' => 'active'])
		@slot('heading')
			{{ __('User Answers') }}
		@endslot

		@slot('menu1')
			{{ __('User Answers') }}
		@endslot

		@slot('menu2')
			{{ __('Quiz report') }}
		@endslot
	@endcomponent
	<div class="contentbar">
		<div class="row">

			<div class="col-lg-12">
				<div class="card m-b-30">
					<div class="card-header">
						<div style="color: black" class="box-title"><b>{{ $user->fname }} {{ $user->lname }}</b> Answers for
							quiz: <b>{{ $topics->title ?? '-' }}</b> in course: <b>{{ $topics->courses->title }}.</b>
						</div>
					</div>
					<div class="card-body">

						<div class="table-responsive">
							<table id="datatable-buttons" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>#</th>
										<th>{{ __('adminstaticword.Question') }}</th>
										<th>{{ __('adminstaticword.A') }}</th>
										<th>{{ __('adminstaticword.B') }}</th>
										<th>{{ __('adminstaticword.C') }}</th>
										<th>{{ __('adminstaticword.D') }}</th>
										<th>{{ __('adminstaticword.CorrectAnswer') }}</th>
										<th>{{ __('adminstaticword.UserAnswer') }}</th>
										<th>{{ __('adminstaticword.Status') }}</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 0; ?>
									@foreach ($answers as $answer)
										<?php $i++; ?>

										<tr>
											<td><?php echo $i; ?></td>
											@isset($answer->quiz->question)
												<td>{!! $answer->quiz->question !!}</td>
											@endisset
											<td>
												{{ $answer->quiz->a }}
											</td>
											<td>
												{{ $answer->quiz->b }}
											</td>
											<td>
												{{ $answer->quiz->c }}
											</td>
											<td>
												{{ $answer->quiz->d }}
											</td>
											<td>
												{{ $answer->answer }}
											</td>
											<td>
												{{ $answer->user_answer }}
											</td>
											<td>
												@if ($answer->user_answer == $answer->answer)
													<i style="color: green" class="fa fa-check" aria-hidden="true"></i>
												@else
													<i style="color: red" class="fa fa-times" aria-hidden="true"></i>
												@endif
											</td>

										</tr>
									@endforeach
								</tbody>
								<tfoot>
									<tr>
										<th>{{ __('Marks Get') }}</th>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<th>{{ $correct }}/{{ $total }}</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
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
			$('.review').change(function() {
				var status = $(this).prop('checked') == true ? 1 : 0;

				var id = $(this).data('id');


				$.ajax({
					type: "POST",
					dataType: "json",
					url: "{{ url('quizreview/approve') }}",
					data: {
						'status': status,
						'id': id
					},
					success: function(data) {
						console.log(data)
					}
				});
			})
		})
	</script>


@endsection
