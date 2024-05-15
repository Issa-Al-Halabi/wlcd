<!-- Start Topbar Mobile -->
<div class="topbar-mobile">
	<div class="row align-items-center">
		<div class="col-md-12">
			<div class="mobile-logobar">
				<a href="{{ url('/') }}" class="mobile-logo"><img src="{{ url('images/favicon/' . $gsetting->favicon) }}"
						class="img-fluid" alt="logo"></a>
			</div>
			<div class="mobile-togglebar">
				<ul class="list-inline mb-0">

					<li class="list-inline-item">
						<div class="topbar-toggle-icon">
							<a class="topbar-toggle-hamburger" href="javascript:void();">
								<img src="{{ url('admin_assets/assets/images/svg-icon/horizontal.svg') }}"
									class="img-fluid menu-hamburger-horizontal" alt="horizontal">
								<img src="{{ url('admin_assets/assets/images/svg-icon/verticle.svg') }}"
									class="img-fluid menu-hamburger-vertical" alt="verticle">
							</a>
						</div>
					</li>
					<li class="list-inline-item">
						<div class="menubar">
							<a class="menu-hamburger" href="javascript:void();">
								<img src="{{ url('admin_assets/assets/images/svg-icon/menu.svg') }}" class="img-fluid menu-hamburger-collapse"
									alt="collapse">
								<img src="{{ url('admin_assets/assets/images/svg-icon/close.svg') }}" class="img-fluid menu-hamburger-close"
									alt="close">
							</a>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- Start Topbar -->
<div class="topbar">
	<!-- Start row -->
	<div class="row align-items-center">
		<!-- Start col -->
		<div class="col-md-12 align-self-center">
			<div class="togglebar">


				<!-- - site visit start -->
				<li class="mt-2 list-inline-item">
					<div class="languagebar">
						<a href="{{ url('/') }}" target="_blank"><span class="live-icon">{{ __('Visit Site') }}</span>&nbsp;<i
								class="feather icon-external-link" aria-hidden="true"></i></a>
					</div>

				</li>
				<!-- = site visit end -->

			</div>
			<div class="infobar">
				@include('sweetalert::alert')
				<ul class="list-inline mb-0">
					<!-- notification start -->
					@if (Auth()->user()->role == 'admin')
						<li class="list-inline-item">
							<div class="notifybar">
								<div class="dropdown" id="notification-dropdown">
									<a class="dropdown-toggle infobar-icon" href="#" role="button" id="notoficationlink"
										data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
											src="{{ url('admin_assets/assets/images/svg-icon/notifications.svg') }}" class="img-fluid"
											alt="notifications">
										<span
											class="live-icon notification-count">{{ Auth()->user()->newNotifications()->where('status', 0)->count() }}</span></a>
									<div id="notification-dropdown-menu" class="dropdown-menu dropdown-menu-right"
										aria-labelledby="notoficationlink">
										<div class="notification-dropdown-title">
											<h6 class="notification-count-text">{{ __('You have') }}
												{{ Auth()->user()->newNotifications()->where('status', 0)->count() }}
												{{ __('unread notifications') }}</h6>
										</div>

										<ul class="list-unstyled scroll-dropdown">

											<?php $i = 0;
											$newNotifications = Auth()
											    ->user()
											    ->newNotifications()
											    ->orderBy('created_at', 'desc')
											    ->get();
											?>
											@foreach ($newNotifications as $notification)
												<?php $i++; ?>

												<li class="media dropdown-item">

													<span class="mr-3 action-icon badge badge-warning-inverse"><?php echo $i; ?></span>
													<div class="notification-body media-body" data-toggle="tooltip" data-placement="top"
														title="{{ $notification->body }}">
														@if ($notification->pivot->status == 0)
															<a href="#">
																<p><span class="timing"
																		style="color: black">{{ str_limit($notification->body, $limit = 50, $end = '...') }}</span></p>
															</a>
														@else
															<a href="#">
																<p><span class="timing"
																		style="color: gray">{{ str_limit($notification->body, $limit = 50, $end = '...') }}</span></p>
															</a>
														@endif
													</div>
													<div class="delete-notification">
														<form id="delete-form-{{ $notification->id }}"
															action="{{ route('notifications.delete', $notification->id) }}"
															data-notification-status="{{ $notification->pivot->status }}" method="POST">
															@csrf
															@method('DELETE')
															<button type="submit" class="btn btn-link delete-notification-btn"
																data-notification-id="{{ $notification->id }}"
																data-notification-status="{{ $notification->pivot->status }}">
																<i style="color: red" class="feather icon-trash mn-2"></i>
															</button>
														</form>
													</div>
												</li>
											@endforeach

										</ul>

										<div class="notification-dropdown-title">
											<a href="{{ route('notifications.deleteAll') }}">
												<p>{{ __('Clear all') }}</p>
											</a>
										</div>
									</div>
								</div>
							</div>
						</li>
					@endif
					<!-- notification end -->

					<!-- language start -->
					@php
						$languages = App\Language::all();
					@endphp
					<li class="list-inline-item">
						<div class="languagebar">
							<div class="dropdown">
								<a class="dropdown-toggle" href="#" role="button" id="languagelink" data-toggle="dropdown"
									aria-haspopup="true" aria-expanded="false"><span
										class="live-icon">{{ Session::has('changed_language') ? Session::get('changed_language') : '' }}</span><span
										class="feather icon-chevron-down live-icon"></span></a>
								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="languagelink">
									@if (isset($languages) && count($languages) > 0)
										@foreach ($languages as $language)
											<a class="dropdown-item" href="{{ route('languageSwitch', $language->local) }}">
												<i class="feather icon-globe"></i>
												{{ $language->name }} ({{ $language->local }})</a>
										@endforeach
									@endif

								</div>
							</div>
						</div>
					</li>
					<!-- language end -->



					<li class="list-inline-item">
						<div class="profilebar">
							<div class="dropdown">
								<a class="dropdown-toggle" href="#" role="button" id="profilelink" data-toggle="dropdown"
									aria-haspopup="true" aria-expanded="false">

									@if (Auth()->User()['user_img'] != null &&
											Auth()->User()['user_img'] != '' &&
											@file_get_contents('images/user_img/' . Auth::user()['user_img']))
										<img src="{{ url('images/user_img/' . Auth()->User()['user_img']) }}" alt="profilephoto"
											class="rounded img-fluid">
									@else
										<img @error('photo') is-invalid @enderror src="{{ Avatar::create(Auth::user()->fname)->toBase64() }}"
											alt="profilephoto" class="rounded img-fluid">
									@endif

									<span class="live-icon">{{ __('Hi') }} {{ Auth::user()->fname }}</span><span
										class="feather icon-chevron-down live-icon"></span>
								</a>
								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="profilelink">
									<div class="dropdown-item">
										<div class="profilename">
											<h5>{{ Auth::user()->fname }}</h5>
										</div>
									</div>
									<div class="userbox">
										<ul class="list-unstyled mb-0">
											<li class="media dropdown-item">
												<a href="{{ url('user/edit/' . Auth()->User()->id) }}" class="profile-icon"><img
														src="{{ url('admin_assets/assets/images/svg-icon/crm.svg') }}" class="img-fluid"
														alt="user">{{ __('My Profile') }}</a>
											</li>

											<li class="media dropdown-item">
												<a href="{{ route('logout') }}" class="profile-icon"
													onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();"><img
														src="{{ url('admin_assets/assets/images/svg-icon/logout.svg') }}" class="img-fluid"
														alt="logout">{{ __('Logout') }}</a>

												<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
													@csrf
												</form>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
		<!-- End col -->
	</div>
	<!-- End row -->
</div>
<!-- End Topbar -->
<!-- Start Breadcrumbbar -->
@yield('breadcum')
<!-- End Breadcrumbbar -->


<style>
	.notification-body {
		max-width: 300px;
		white-space: nowrap;
		/* overflow: hidden; */
		text-overflow: ellipsis;
	}

	.scroll-dropdown {
		height: 300px;
		overflow-y: auto;
		overflow-x: hidden;
	}

	.delete-notification {
		margin-left: auto;
	}

	
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
	$(document).ready(function() {
		$('.delete-notification-btn').on('click', function(event) {
			event.preventDefault();
			event.stopPropagation(); // prevent event from bubbling up to dropdown parent
			var notificationId = $(this).data('notification-id');
			var deleteForm = $('#delete-form-' + notificationId);
			var notificationStatus = deleteForm.attr('data-notification-status');
			$(`#delete-form-${notificationId}`).closest('.dropdown-item').remove();
			if (notificationStatus == 0) {

				// Update the notification count only if the deleted notification status was 0 (unread)
				var notificationCount = $('.notification-count');
				var notificationCountText = $('.notification-count-text');
				var currentCount = parseInt(notificationCount.text());
				if (currentCount > 3) {
					notificationCount.text(currentCount - 1);
					notificationCountText.html('{{ __('You have') }} ' + (currentCount -
						1) + ' {{ __('unread notifications') }}');
				}
				if (currentCount > 2) {
					notificationCount.text(currentCount - 1);
					notificationCountText.html('{{ __('You have') }} ' + (currentCount -
						1) + ' {{ __('unread notification') }}');
				} else {
					notificationCount.text(0);
					notificationCountText.html('{{ __('You have') }} ' + 0 +
						' {{ __('unread notification') }}');
				}
			}
			$.ajax({
				url: deleteForm.attr('action'),
				method: deleteForm.attr('method'),
				data: deleteForm.serialize(),
				success: function(response) {},
				error: function(xhr, status, error) {
					// Handle error response, such as displaying an error message
				}
			});
		});
	});

	$(document).ready(function() {
		$('#notification-dropdown').on('hide.bs.dropdown', function() {

			// Update the notification count
			$('.notification-count').text(0);
			var notificationCountText = $('.notification-count-text');
			notificationCountText.html('{{ __('You have') }} ' + 0 +
				' {{ __('unread notification') }}');
			$('.timing').css('color', 'gray');

			$.ajax({
				url: "{{ route('notifications.read') }}",
				method: 'GET',
				data: {
					_token: "{{ csrf_token() }}",
				},
				success: function(response) {},
				error: function(xhr, status, error) {
					// Handle error response, such as displaying an error message
				}
			});
		});

	});
</script>



{{-- $(document).ready(function() {
	$('#notification-dropdown').on('hide.bs.dropdown', function() {
		$.ajax({
			url: "{{ route('notifications.read') }}",
			method: 'GET',
			data: {
				_token: "{{ csrf_token() }}",
			},
			success: function(response) {
				// Update the notification count
				$('.notification-count').text(0);
				var notificationCountText = $('.notification-count-text');
				notificationCountText.html('{{ __('You have') }} ' + 0 +
					' {{ __('unread notification') }}');

				// Update the dropdown with new notifications
				var notificationDropdown = $('#notification-dropdown-menu');
				notificationDropdown.empty();
				var newNotifications = response.new_notifications;
				console.log(newNotifications);
				$.each(newNotifications, function(key, notification) {
					var notificationBody = notification.body.substring(0, 50) +
						'...';
					var link = $('<a>').attr('href', '#');
					var timing = $('<span>').addClass('timing').css('color',
						'gray').text(notificationBody);
					var p = $('<p>').append(timing);
					link.append(p);
					link.wrap(
					'<div class="dropdown-item"></div>'); // wrap link with div to add dropdown-item class
					notificationDropdown.append(link
				.parent()); // append the parent div of the link
				});
				console.log(newNotifications);
			},
			error: function(xhr, status, error) {
				// Handle error response, such as displaying an error message
			}
		});
	});

}); --}}
