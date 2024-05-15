@extends('admin.layouts.master')
@section('title', 'Database Backup - Admin')
@section('maincontent')
@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
{{ __('Database Backup') }}
@endslot
@slot('menu1')
{{ __('Database Backup') }}
@endslot
@endcomponent
<div class="contentbar">
	<div class="row">
		@if ($errors->any())
		<div class="alert alert-danger" role="alert">
			@foreach($errors->all() as $error)
			<p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true" style="color:red;">&times;</span></button></p>
			@endforeach
		</div>
		@endif
		<div class="col-lg-12">
			<div class="card m-b-30">
				<div class="card-header">
					<h5 class="box-title">{{ __('Backup Manager') }}</h5>
				</div>
				<div class="card-body ml-2">
					<form action="{{ action('DatabaseController@update') }}" method="POST">
						@csrf

						<div class="col-md-12">
							<label for="">MySQL Dump Path:</label>
							<div class="input-group">
								<input name="DUMP_BINARY_PATH" required type="text" class="form-control"
									placeholder="MY SQL DUMP PATH" value="{{ $dump }}" aria-describedby="basic-addon2">
								<span class="input-group-addon" id="basic-addon2">
									<button type="submit" class="btn btn-primary-rgba btn-block">Save!</button>
								</span>

							</div>
							<br>
							<div class="card bg-primary-rgba m-b-30">
								<div class="card-body">
									<div class="row align-items-center">
										<small class="text-primary process-fonts"><i class="fa fa-primary-circle"></i>
											{{ __('adminstaticword.ImportantNote') }}

											<ul class="process-font">
												<li>
													Usually in all hosting dump path for MYSQL is /usr/bin
												</li>

												<li>
													If that path not work than contact your hosting provider with
													subject "What is my
													MYSQL DUMP Binary path ?"
												</li>
												<li>
													Enter the path without <b>mysqldump</b> in path
												</li>
											</ul>


										</small>
									</div>
								</div>
							</div>
						</div>

					</form>
					<div class="card-body">
						<div class="row">
							<div class="col-md-12 p-1 mb-2 bg-success text-white rounded">
								<i class="fa fa-info-circle"></i> Note:
								<ul>
									<li>
										{{ __('It will generate only database backup of your site.') }}
									</li>

									<li>
										<b>{{ __('Download URL is valid only for 1 (minute).') }}</b>
									</li>

									<li>
										Make sure <b>mysql dump is enabled on your server</b> for database backup and
										before run
										this or
										run only database backup command make sure you save the mysql dump path in
										<b>config/database.php</b>.
									</li>
								</ul>
							</div>
						</div>

						<div class="col-md-6">
							<br>
							<a @if(env('DUMP_BINARY_PATH') != '' ) href="{{ url('database/genrate?type=onlydb') }}"
								@else href="#" disabled @endif class="btn btn-md btn-primary-rgba">
								<i class="fa fa-refresh"></i> {{ __('Generate database backup') }}
							</a>
						</div>

					</div>
					<div class="row">
						<div class="text-center col-md-8">
							{{-- {!! $html !!} --}}
						</div>

						<div class="col-md-4">
							<div class="well">
								<p class="text-success"> <b>Download the latest backup</b> </p>

								@php

								$dir17 = storage_path() . '/app/'.config('app.name');
								@endphp

								<ul>

									@foreach (array_reverse(glob("$dir17/*")) as $key=> $file)

									@if($loop->first)
									<li><a
											href="{{ URL::temporarySignedRoute('database.download', now()->addMinutes(1), ['filename' => basename($file)]) }}"><b>{{ basename($file)  }}
												(Latest)</b></a></li>
									@else
									<li><a href="<a href="
											{{ URL::temporarySignedRoute('database.download', now()->addMinutes(1), ['filename' => basename($file)]) }}">{{ basename($file)  }}</a>
									</li>
									@endif

									@endforeach

								</ul>

							</div>
						</div>

					</div>

				</div>
			</div>
		</div>
	</div>
	@endsection	