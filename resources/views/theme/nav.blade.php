@if ($gsetting->promo_enable == 1)
	<div id="promo-outer">
		<div id="promo-inner">
			<a href="{{ $gsetting['promo_link'] }}">{{ $gsetting['promo_text'] }}</a>
			<span id="close">x</span>
		</div>
	</div>
	<div id="promo-tab" class="display-none">SHOW</div>
@endif
<?php
$language = Session::get('changed_language'); //or 'english' //set the system language
$rtl = ['ar', 'he', 'ur', 'arc', 'az', 'dv', 'ku', 'fa']; //make a list of rtl languages
?>

<section id="nav-bar" class="main-content nav-bar-main-block">
	<nav class="main-navigation">
		{{-- <div class="row top-menu">
            <div class="container">
                <div class="numbers">
                    <a href="mailto: info@asasco.ae">info@wlcd.sy</a>
                    <a class="ltr" href="tel: +97143422010">+96312345679</a>
                </div>
                <div class="social text-white">
                    @if ($about->four_btntext == !null)
                        <li>
                    <a href="#" target="_blank" title="facebook"><i class="fab fa-facebook-f"></i></a>
                    </li>
                    @endif
                    @if ($about->five_btntext == !null)
                        <li>
                    <a href="#" target="_blank" title="instagram"><i class="fab fa-instagram"
                            aria-hidden="true"></i></a>
                    </li>
                    @endif
                    @if ($about->linkedin == !null)
                    <li>
                    <a href="#" target="_blank" title="linkedin"><i class="fab fa-linkedin"
                            aria-hidden="true"></i></a>
                    </li>
                    @endif
                    @if ($about->twitter == !null)
                    <li>
                    <a href="#" target="_blank" title="twitter"><i class="fab fa-twitter"
                            aria-hidden="true"></i></a>
                    </li>
                    @endif
                </div>
            </div>
        </div> --}}
		<div class="container-fluid query-size">
			<!-- start navigation -->
			<div class="navigation fullscreen-search-block">
				<span style="font-size:30px;cursor:pointer" onclick="openNav()" class="hamburger">&#9776; </span>
				<div class="logo">
					@if ($gsetting->logo_type == 'L')
						{{-- <a href="{{ url('/') }}"><img src="{{ asset('images/logo/' . $gsetting->logo) }}"
                            class="img-fluid" alt="logo"></a> --}}
						<a href="{{ url('/') }}"><img src="{{ asset('images/logo/logo w.png') }}" class="img-fluid white"
								alt="logo"></a>
						<a href="{{ url('/') }}"><img src="{{ asset('images/logo/logo_green.png') }}" class="img-fluid green"
								alt="logo"></a>
						{{-- <a href="{{ url('/') }}"><img src="{{ asset('images/logo/horizental_logo.png') }}"
                                class="img-fluid" alt="logo"></a> --}}
					@else()
						<a href="{{ url('/') }}"><b>
								<div class="logotext">{{ $gsetting->project_title }}</div>
							</b></a>
					@endif
				</div>
				<div class="nav-search nav-wishlist">

					<a href="#find"><i data-feather="search"></i></a>
				</div>
				@auth
					<div class="shopping-cart">
						<a href="{{ route('cart.show') }}" title="Cart"><i data-feather="shopping-cart"></i></a>
						<span class="red-menu-badge red-bg-success">
							@php
								$item = App\Cart::where('user_id', Auth::User()->id)->count();
								if ($item > 0) {
								    echo $item;
								} else {
								    echo '0';
								}
							@endphp
						</span>
					</div>
					<div class="nav-wishlist">
						<div id="notification_li">
							<a href="{{ url('send') }}" id="notificationLinkk" title="Notification"><i data-feather="bell"></i></a>
							<span class="red-menu-badge red-bg-success">
								{{ Auth()->user()->unreadNotifications->where('type', 'App\Notifications\UserEnroll')->count() }}
							</span>
							<div id="notificationContainerr">
								<div id="notificationTitle">{{ __('frontstaticword.Notifications') }}</div>
								<div id="notificationsBody" class="notifications">
									<ul>
										@foreach (Auth()->user()->unreadNotifications->where('type', 'App\Notifications\UserEnroll') as $notification)
											<li class="unread-notification">
												<a href="{{ url('notifications/' . $notification->id) }}">
													<div class="notification-image">
														@if ($notification->data['image'] !== null)
															<img src="{{ asset('images/course/' . $notification->data['image']) }}" alt="course" class="img-fluid">
														@else
															<img src="{{ Avatar::create($notification->data['id'])->toBase64() }}" alt="course" class="img-fluid">
														@endif
													</div>
													<div class="notification-data">
														In
														{{ str_limit($notification->data['id'], $limit = 20, $end = '...') }}
														<br>
														{{ str_limit($notification->data['data'], $limit = 20, $end = '...') }}
													</div>
												</a>
											</li>
										@endforeach

										@foreach (Auth()->user()->readNotifications->where('type', 'App\Notifications\UserEnroll') as $notification)
											<li>
												<a href="{{ route('mycourse.show') }}">
													<div class="notification-image">
														@if ($notification->data['image'] !== null)
															<img src="{{ asset('images/course/' . $notification->data['image']) }}" alt="course" class="img-fluid">
														@else
															<img src="{{ Avatar::create($notification->data['id'])->toBase64() }}" alt="course" class="img-fluid">
														@endif
													</div>
													<div class="notification-data">
														In
														{{ str_limit($notification->data['id'], $limit = 20, $end = '...') }}
														<br>
														{{ str_limit($notification->data['data'], $limit = 20, $end = '...') }}
													</div>
												</a>
											</li>
										@endforeach
									</ul>
								</div>
								<div id="notificationFooter"><a
										href="{{ route('deleteNotification') }}">{{ __('frontstaticword.ClearAll') }}</a>
								</div>
							</div>
						</div>
					</div>
				@endauth


				<div id="mySidenav" class="sidenav">
					<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
					@guest
						<div class="login-block">
							<a href="{{ route('register') }}" class="btn btn-primary"
								title="register">{{ __('frontstaticword.Signup') }}</a>
							<a href="{{ route('login') }}" class="btn btn-secondary" title="login">{{ __('frontstaticword.Login') }}</a>
						</div>
					@endguest
					@auth

						<div id="notificationTitle">
							@if (Auth::User()['user_img'] != null &&
									Auth::User()['user_img'] != '' &&
									@file_get_contents('images/user_img/' . Auth::user()['user_img']))
								<img src="{{ url('/images/user_img/' . Auth::User()->user_img) }}" class="dropdown-user-circle" alt="">
							@else
								<img src="{{ asset('images/default/user.jpg') }}" class="dropdown-user-circle" alt="">
							@endif
							<div class="user-detailss">
								Hi, {{ Auth::User()->fname }}

							</div>

						</div>

						<div class="login-block">

							<a href="{{ route('logout') }}"
								onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
								<div id="notificationFooter">
									{{ __('frontstaticword.Logout') }}

									<form id="logout-form" action="{{ route('logout') }}" method="POST" class="display-none">
										@csrf
									</form>
								</div>
							</a>
						</div>

					@endauth

					@php
						$categories = App\Categories::orderBy('position', 'ASC')
						    ->with(['subcategory', 'subcategory.childcategory'])
						    ->get();
					@endphp

					<div class="wrapper center-block">

						<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
							@foreach ($categories->where('status', '1') as $cate)
								<div class="panel panel-default">
									<div class="panel-heading active" role="tab" id="headingOne">
										<h4 class="panel-title">
											<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{ $cate->id }}"
												aria-expanded="true" aria-controls="collapseOne">
												<i class="fa {{ $cate->icon }} rgt-10"></i> <label class="prime-cat"
													data-url="{{ route('category.page', ['id' => $cate->id, 'category' => str_slug(str_replace('-', '&', $cate->slug))]) }}">{{ str_limit($cate->title, $limit = 20, $end = '..') }}</label>
											</a>
										</h4>
									</div>


									<div id="collapseOne{{ $cate->id }}" class="subcate-collapse panel-collapse collapse in"
										role="tabpanel" aria-labelledby="headingOne">
										@foreach ($cate->subcategory as $sub)
											@if ($sub->status == 1)
												<div class="panel-body">
													<div class="panel panel-default">
														<div class="panel-heading" role="tab" id="headingeleven">
															<h4 class="panel-title">
																<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
																	href="#collapseeleven{{ $sub->id }}" aria-expanded="false" aria-controls="collapseeleven">
																	<i class="fa {{ $sub->icon }} rgt-10"></i>
																	<label class="sub-cate"
																		data-url="{{ route('subcategory.page', ['id' => $sub->id, 'category' => str_slug(str_replace('-', '&', $sub->slug))]) }}">{{ str_limit($sub->title, $limit = 15, $end = '..') }}</label>

																</a>
															</h4>
														</div>

														<div id="collapseeleven{{ $sub->id }}" class="panel-collapse collapse" role="tabpanel"
															aria-labelledby="headingeleven">
															@foreach ($sub->childcategory as $child)
																@if ($child->status == 1)
																	<div class="panel-body sub-cat">
																		<i class="fa {{ $child->icon }} rgt-10"></i>
																		<label class="child-cate"
																			data-url="{{ route('childcategory.page', ['id' => $child->id, 'category' => str_slug(str_replace('-', '&', $child->slug))]) }}">{{ $child->title }}
																		</label>
																	</div>
																@endif
															@endforeach
														</div>

													</div>
												</div>
											@endif
										@endforeach
									</div>

								</div>
							@endforeach
							<ul>
								<a href="{{ route('allinstructor/view') }}" title="All Instructor">
									<li>{{ __('Instructors') }}
									</li>
								</a>
								<a href="{{ route('blog.all') }}" title="{{ __('Blog') }}">
									<li>{{ __('Blog') }}</li>
								</a>
								<a href="{{ route('about.show') }}" title="{{ __('About us') }}">
									<li>{{ __('About us') }}
									</li>
								</a>
								<a href="{{ url('user_contact') }}" title="{{ __('Contact us') }}">
									<li>{{ __('Contact us') }}
									</li>
								</a>
							</ul>
						</div>

					</div>

					@auth
						<div class="sidebar-nav-icon">
							<ul>
								@if (Auth::User()->role == 'admin')
									<a target="_blank" href="{{ url('/admins') }}">
										<li><i data-feather="pie-chart"></i>{{ __('frontstaticword.AdminDashboard') }}
										</li>
									</a>
								@endif
								@if (Auth::User()->role == 'instructor')
									<a target="_blank" href="{{ url('/instructor') }}">
										<li><i data-feather="pie-chart"></i>{{ __('frontstaticword.InstructorDashboard') }}
										</li>
									</a>
								@endif


								<a href="{{ route('mycourse.show') }}">
									<li><i data-feather="book-open"></i>{{ __('frontstaticword.MyCourses') }}</li>
								</a>
								<a href="{{ route('wishlist.show') }}">
									<li><i data-feather="heart"></i>{{ __('frontstaticword.MyWishlist') }}</li>
								</a>
								<a href="{{ route('purchase.show') }}">
									<li><i data-feather="shopping-cart"></i>{{ __('frontstaticword.PurchaseHistory') }}
									</li>
								</a>
								<a href="{{ route('profile.show', Auth::User()->id) }}">
									<li><i data-feather="user"></i>{{ __('frontstaticword.UserProfile') }}</li>
								</a>
								@if (Auth::User()->role == 'user')
									@if ($gsetting->instructor_enable == 1)
										<a href="#" data-toggle="modal" data-target="#myModalinstructor" title="Become An Instructor">
											<li><i data-feather="shield"></i>{{ __('frontstaticword.BecomeAnInstructor') }}
											</li>
										</a>
									@endif
								@endif

								<a href="{{ route('flash.deals') }}">
									<li><i data-feather="battery-charging"></i>{{ __('Flash Deals') }}</li>
								</a>


								@if (env('ENABLE_INSTRUCTOR_SUBS_SYSTEM') == 1)
									@if (Auth::User()->role == 'instructor')
										<a href="{{ route('plan.page') }}">
											<li><i data-feather="tag"></i>{{ __('frontstaticword.InstructorPlan') }}
											</li>
										</a>
									@endif
								@endif


								@if (Auth::User()->role == 'user' || Auth::User()->role == 'instructor')
									@if ($gsetting->device_control == 1)
										<a href="{{ route('active.courses') }}" title="Watchlist">
											<li><i data-feather="framer"></i>{{ __('frontstaticword.Watchlist') }}
											</li>
										</a>
									@endif
								@endif


								@if ($gsetting->donation_enable == 1)
									<a target="__blank" href="{{ $gsetting->donation_link }}" title="Donation">
										<li><i data-feather="framer"></i>{{ __('frontstaticword.Donation') }}</li>
									</a>
								@endif



								@if (Schema::hasTable('affiliate') && Schema::hasTable('wallet_settings'))
									@php
										$affiliate = App\Affiliate::first();
										$wallet_settings = App\WalletSettings::first();
									@endphp


									@if (isset($wallet_settings) && $wallet_settings->status == 1)
										<a href="{{ url('/wallet') }}">
											<li><i class="icon-wallet icons"></i>{{ __('frontstaticword.MyWallet') }}
											</li>
										</a>
									@endif

									@if (isset($affiliate) && $affiliate->status == 1)
										<a href="{{ route('get.affiliate') }}">
											<li><i data-feather="users"></i>{{ __('frontstaticword.Affiliate') }}</li>
										</a>
									@endif
								@endif

								{{-- <a href="{{ route('compare.index') }}"><li><i data-feather="bar-chart"></i>{{ __("Compare") }}</li></a> --}}

								@if (Module::has('Resume') && Module::find('Resume')->isEnabled())
									@include('resume::front.searchresume')
								@endif
								@if (Module::has('Resume') && Module::find('Resume')->isEnabled())
									@include('resume::front.job.icon')
								@endif


								@if (Module::find('Forum') && Module::find('Forum')->isEnabled())
									@if ($gsetting->forum_enable == 1)
										@include('forum::layouts.sidebar_menu')
									@endif
								@endif





								<a href="{{ route('my.leaderboard') }}">
									<li><i class="icon-chart icons"></i>{{ __('frontstaticword.MyLeaderboard') }}</li>
								</a>
								@if (Auth::User()->role == 'user')
									<a href="{{ route('studentprofile') }}">
										<li><i data-feather="share"></i>{{ __('Share profile') }}</li>
									</a>
								@endif
							</ul>
						</div>


					@endauth
				</div>
			</div>

			<!-- end navigation -->
			<div class="row smallscreen-search-block">
				<div class="col-lg-7">
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-12" style="text-align: center">
							<div class="logo" style="text-align: center;">


								@if ($gsetting->logo_type == 'L')
									<a href="{{ url('/') }}"><img src="{{ asset('images/logo/logo w.png') }}" class="img-fluid white"
											alt="logo"></a>
									<a href="{{ url('/') }}"><img src="{{ asset('images/logo/logo_green.png') }}" class="img-fluid green"
											alt="logo"></a>
								@else()
									<a href="{{ url('/') }}"><b>
											<div class="logotext">{{ $gsetting->project_title }}</div>
										</b></a>
								@endif
							</div>
						</div>
						<div class="col-lg-10 col-md-10 col-sm-12"
							style="display: flex;
                                 align-items: center;">
							<div class="navigation">
								<div id="cssmenu">
									<ul>
										<li><a href="#" title="Categories">{{ __('frontstaticword.Categories') }}</a>

											<ul>
												@foreach ($categories as $cate)
													@if ($cate->status == 1)
														<li><a href="{{ route('category.page', ['id' => $cate->id, 'category' => $cate->title]) }}"
																title="{{ $cate->title }}">
																{{-- <i class="fa {{ $cate->icon }} rgt-20"></i> --}}
																{{ str_limit($cate->title, $limit = 25, $end = '..') }}
																@if (in_array($language, $rtl))
																	<i data-feather="chevron-left" class="float-left"></i>
																@else
																	<i data-feather="chevron-right" class="float-right"></i>
																@endif
															</a>
															<ul>
																@foreach ($cate->subcategory as $sub)
																	@if ($sub->status == 1)
																		<li><a href="{{ route('subcategory.page', ['id' => $sub->id, 'category' => $sub->title]) }}"
																				title="{{ $sub->title }}">
																				{{-- <i class="fa {{ $sub->icon }} rgt-20"></i> --}}
																				{{ str_limit($sub->title, $limit = 25, $end = '..') }}
																				@if (in_array($language, $rtl))
																					<i data-feather="chevron-left" class="float-left"></i>
																				@else
																					<i data-feather="chevron-right" class="float-right"></i>
																				@endif
																			</a>
																			<ul>
																				@foreach ($sub->childcategory as $child)
																					@if ($child->status == 1)
																						<li>
																							<a href="{{ route('childcategory.page', ['id' => $child->id, 'category' => $child->title]) }}"
																								title="{{ $child->title }}"><i
																									class="fa {{ $child->icon }} rgt-20"></i>{{ str_limit($child->title, $limit = 25, $end = '..') }}</a>
																						</li>
																					@endif
																				@endforeach
																			</ul>
																		</li>
																	@endif
																@endforeach
															</ul>
														</li>
													@endif
												@endforeach
											</ul>
										</li>
										{{-- <li style="margin-left: 30px;"><a href="#"
                                                title="All Courses">{{ __('Courses') }}</a>
                                        </li> --}}
										<li style="margin-left: 30px;"><a href="{{ route('allinstructor/view') }}"
												title="All Instructor">{{ __('Instructors') }}
											</a>
										</li>
										<li style="margin-left: 30px;"><a href="{{ route('blog.all') }}"
												title="{{ __('Blog') }}">{{ __('Blog') }}</a></li>
										<li style="margin-left: 30px;"> <a href="{{ route('about.show') }}"
												title="{{ __('About us') }}">{{ __('About us') }}</a>
										</li>
										<li style="margin-left: 30px;"> <a href="{{ url('user_contact') }}"
												title="{{ __('Contact us') }}">{{ __('Contact us') }}</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-5" style="display: grid;
                        align-items: center;">
					@guest
						<div class="row">
							<div class="col-lg-3 col-md-3">
								<div class="learning-business">

								</div>
							</div>
							<div class="col-lg-1">
								<div class="shopping-cart">
									<a href="{{ route('cart.show') }}" title="Cart"><i data-feather="shopping-cart"></i></a>
									<span class="red-menu-badge red-bg-success">
										@php
											$item = session()->get('cart.add_to_cart');
											
											if (isset($item) && count($item) > 0) {
											    echo count(array_unique($item));
											} else {
											    echo '0';
											}
										@endphp
									</span>
								</div>
							</div>
							<div class="col-lg-1">
								<div class="search search-one" id="search">
									<form method="GET" id="searchform" action="{{ route('search') }}">
										<div class="search-input-wrap">
											<input class="search-input" name="searchTerm" placeholder="Search in Site" type="text"
												id="course_name" autocomplete="off" />
										</div>
										<input class="search-submit" type="submit" id="go" value="">
										<div class="icon"><i data-feather="search"></i></div>
										<div id="course_data"></div>
									</form>
								</div>
							</div>
							<div class="col-lg-2 col-md-2 lang">

								@php
									$languages = App\Language::get();
								@endphp
								@if (isset($languages) && count($languages) > 0)
									<div class="footer-dropdown">
										<a href="#" class="a" data-toggle="dropdown"><i
												data-feather="globe"></i> {{ Session::has('changed_language') ? ucfirst(Session::get('changed_language')) : '' }}<i
												class="fa fa-angle-down lft-10"></i></a>


										<ul class="dropdown-menu">

											@foreach ($languages as $language)
												<a href="{{ route('languageSwitch', $language->local) }}">
													<li>{{ $language->name }}</li>
												</a>
											@endforeach
										</ul>
									</div>
								@endif


								@php
									$currencies = DB::table('currencies')->get();
								@endphp
								@if (isset($currencies) && count($currencies) > 1)
									<div class="footer-dropdown footer-dropdown-two">
										<a href="#" class="a" data-toggle="dropdown"><i data-feather="credit-card"></i>
											{{ Session::has('changed_currency') ? ucfirst(Session::get('changed_currency')) : $currency->code }}<i
												class="fa fa-angle-up lft-10"></i></a>


										<ul class="dropdown-menu">

											@foreach ($currencies as $currency)
												<a href="{{ route('CurrencySwitch', $currency->code) }}">
													<li>{{ $currency->code }}</li>
												</a>
											@endforeach
										</ul>
									</div>
								@endif

							</div>
							<div class="col-lg-5">
								<div class="Login-btn">
									<a href="{{ route('login') }}" class="btn secondary" title="login">{{ __('frontstaticword.Login') }}</a>
									<a href="{{ route('register') }}" class="btn secondary"
										title="register">{{ __('frontstaticword.Signup') }}</a>

								</div>
							</div>
						@endguest

						@auth
							<div class="row">


								<div class="col-lg-1 col-md-1 col-6">
									<div class="learning-business learning-business-two">

									</div>
								</div>
								<div class="col-lg-2 col-md-2 col-6">
									<div class="learning-business">

									</div>
								</div>
								<div class="col-lg-1 col-md-1 col-sm-2 col-2">
									<div class="nav-wishlist">
										<ul id="nav">
											<li id="notification_li">
												<a href="{{ url('send') }}" id="notificationLink" title="Notification"><i
														data-feather="bell"></i></a>
												<span class="red-menu-badge red-bg-success">
													{{ Auth()->user()->unreadNotifications->where('type', 'App\Notifications\UserEnroll')->count() }}
												</span>
												<div id="notificationContainer">
													<div id="notificationTitle">
														{{ __('frontstaticword.Notifications') }}
													</div>
													<div id="notificationsBody" class="notifications">
														<ul>
															@foreach (Auth()->user()->unreadNotifications->where('type', 'App\Notifications\UserEnroll') as $notification)
																<li class="unread-notification">
																	<a href="{{ url('notifications/' . $notification->id) }}">
																		<div class="notification-image">
																			@if ($notification->data['image'] !== null)
																				<img src="{{ asset('images/course/' . $notification->data['image']) }}" alt="course"
																					class="img-fluid">
																			@else
																				<img src="{{ Avatar::create($notification->data['id'])->toBase64() }}" alt="course"
																					class="img-fluid">
																			@endif
																		</div>
																		<div class="notification-data">
																			In
																			{{ str_limit($notification->data['id'], $limit = 20, $end = '...') }}
																			<br>
																			{{ str_limit($notification->data['data'], $limit = 20, $end = '...') }}
																		</div>
																	</a>
																</li>
															@endforeach

															@foreach (Auth()->user()->readNotifications->where('type', 'App\Notifications\UserEnroll') as $notification)
																<li>
																	<a href="{{ route('mycourse.show') }}">
																		<div class="notification-image">
																			@if ($notification->data['image'] !== null)
																				<img src="{{ asset('images/course/' . $notification->data['image']) }}" alt="course"
																					class="img-fluid">
																			@else
																				<img src="{{ Avatar::create($notification->data['id'])->toBase64() }}" alt="course"
																					class="img-fluid">
																			@endif
																		</div>
																		<div class="notification-data">
																			In
																			{{ str_limit($notification->data['id'], $limit = 20, $end = '...') }}
																			<br>
																			{{ str_limit($notification->data['data'], $limit = 20, $end = '...') }}
																		</div>
																	</a>
																</li>
															@endforeach
														</ul>
													</div>
													<div id="notificationFooter"><a
															href="{{ route('deleteNotification') }}">{{ __('frontstaticword.ClearAll') }}</a>
													</div>
												</div>
											</li>
										</ul>
									</div>
								</div>
								<div class="col-lg-1 col-md-1 col-sm-2 col-2">
									<div class="nav-wishlist">
										<a href="{{ route('wishlist.show') }}" title="Go to Wishlist"><i data-feather="heart"></i></a>
										<span class="red-menu-badge red-bg-success">
											@php
												$wishlist = App\Wishlist::where('user_id', Auth::User()->id)->get();
												
											@endphp



											@php
												$counter = 0;
												foreach ($wishlist as $item) {
												    if ($item->courses->status == '1') {
												        $counter++;
												    }
												}
												
												echo $counter;
											@endphp
										</span>
									</div>
								</div>
								<div class="col-lg-1 col-md-1 col-sm-2 col-2">
									<div class="shopping-cart">
										<a href="{{ route('cart.show') }}" title="Cart"><i data-feather="shopping-cart"></i></a>
										<span class="red-menu-badge red-bg-success">
											@php
												$item = App\Cart::where('user_id', Auth::User()->id)->count();
												if ($item > 0) {
												    echo $item;
												} else {
												    echo '0';
												}
											@endphp
										</span>
									</div>
								</div>
								<div class="col-lg-1 col-md-1 col-sm-2 col-2">
									<div class="search search-one" id="search">
										<form method="GET" id="searchform" action="{{ route('search') }}">
											<div class="search-input-wrap">
												<input class="search-input" name="searchTerm" placeholder="Search in Site" type="text"
													id="course_name" autocomplete="off" />
											</div>
											<input class="search-submit" type="submit" id="go" value="">
											<div class="icon"><i data-feather="search"></i></div>
											<div id="course_data"></div>
										</form>
									</div>

								</div>
								<div class="col-lg-2 col-md-2 lang">

									@php
										$languages = App\Language::get();
									@endphp
									@if (isset($languages) && count($languages) > 0)
										<div class="footer-dropdown">
											<a href="#" class="a" data-toggle="dropdown"><i
													data-feather="globe"></i>{{ Session::has('changed_language') ? ucfirst(Session::get('changed_language')) : '' }}<i
													class="fa fa-angle-down lft-10"></i></a>


											<ul class="dropdown-menu">

												@foreach ($languages as $language)
													<a href="{{ route('languageSwitch', $language->local) }}">
														<li>{{ $language->name }}</li>
													</a>
												@endforeach
											</ul>
										</div>
									@endif


									@php
										$currencies = DB::table('currencies')->get();
									@endphp
									@if (isset($currencies) && count($currencies) > 1)
										<div class="footer-dropdown footer-dropdown-two">
											<a href="#" class="a" data-toggle="dropdown"><i data-feather="credit-card"></i>
												{{ Session::has('changed_currency') ? ucfirst(Session::get('changed_currency')) : $currency->code }}<i
													class="fa fa-angle-up lft-10"></i></a>


											<ul class="dropdown-menu">

												@foreach ($currencies as $currency)
													<a href="{{ route('CurrencySwitch', $currency->code) }}">
														<li>{{ $currency->code }}</li>
													</a>
												@endforeach
											</ul>
										</div>
									@endif

								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-6">
									<div class="my-container">
										<div class="dropdown">
											<button class="btn btn-default dropdown-toggle  my-dropdown" type="button" id="dropdownMenu1"
												data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
												@if (Auth::User()['user_img'] != null &&
														Auth::User()['user_img'] != '' &&
														@file_get_contents('images/user_img/' . Auth::user()['user_img']))
													<img src="{{ url('/images/user_img/' . Auth::User()->user_img) }}" class="circle" alt="">
												@else
													<img src="{{ asset('images/default/user.jpg') }}" class="circle" alt="">
												@endif
												<span class="dropdown__item name"
													id="name">{{ str_limit(Auth::User()->fname, $limit = 10, $end = '..') }}</span>
												<span class="dropdown__item caret"></span>
											</button>
											<ul class="dropdown-menu dropdown-menu-right User-Dropdown U-open" aria-labelledby="dropdownMenu1">
												<div id="notificationTitle">
													@if (Auth::User()['user_img'] != null &&
															Auth::User()['user_img'] != '' &&
															@file_get_contents('images/user_img/' . Auth::user()['user_img']))
														<img src="{{ url('/images/user_img/' . Auth::User()->user_img) }}" class="dropdown-user-circle"
															alt="">
													@else
														<img src="{{ asset('images/default/user.jpg') }}" class="dropdown-user-circle" alt="">
													@endif
													<div class="user-detailss">
														{{ Auth::User()->fname }}
														<br>
														{{ Auth::User()->email }}
													</div>

												</div>

												<div class="scroll-down">

													@if (Auth::User()->role == 'admin')
														<a target="_blank" href="{{ url('/admins') }}">
															<li><i data-feather="pie-chart"></i>{{ __('frontstaticword.AdminDashboard') }}
															</li>
														</a>
													@endif
													@if (Auth::User()->role == 'instructor')
														<a target="_blank" href="{{ url('/instructor') }}">
															<li><i data-feather="pie-chart"></i>{{ __('frontstaticword.InstructorDashboard') }}
															</li>
														</a>
													@endif



													<a href="{{ route('mycourse.show') }}">
														<li><i data-feather="book-open"></i>{{ __('frontstaticword.MyCourses') }}
														</li>
													</a>
													<a href="{{ route('wishlist.show') }}">
														<li><i data-feather="heart"></i>{{ __('frontstaticword.MyWishlist') }}
														</li>
													</a>
													<a href="{{ route('purchase.show') }}">
														<li><i data-feather="shopping-cart"></i>{{ __('frontstaticword.PurchaseHistory') }}
														</li>
													</a>
													<a href="{{ route('profile.show', Auth::User()->id) }}">
														<li><i data-feather="user"></i>{{ __('frontstaticword.UserProfile') }}
														</li>
													</a>
													@if (Auth::User()->role == 'user')
														@if ($gsetting->instructor_enable == 1)
															<a href="#" data-toggle="modal" data-target="#myModalinstructor" title="Become An Instructor">
																<li><i data-feather="shield"></i>{{ __('frontstaticword.BecomeAnInstructor') }}
																</li>
															</a>
														@endif
													@endif

													<a href="{{ route('flash.deals') }}">
														<li><i data-feather="battery-charging"></i>{{ __('Flash Deals') }}
														</li>
													</a>


													@if (env('ENABLE_INSTRUCTOR_SUBS_SYSTEM') == 1)
														@if (Auth::User()->role == 'instructor')
															<a href="{{ route('plan.page') }}">
																<li><i data-feather="tag"></i>{{ __('frontstaticword.InstructorPlan') }}
																</li>
															</a>
														@endif
													@endif


													@if (Auth::User()->role == 'user' || Auth::User()->role == 'instructor')
														@if ($gsetting->device_control == 1)
															<a href="{{ route('active.courses') }}" title="Watchlist">
																<li><i data-feather="framer"></i>{{ __('frontstaticword.Watchlist') }}
																</li>
															</a>
														@endif
													@endif


													@if ($gsetting->donation_enable == 1)
														<a target="__blank" href="{{ $gsetting->donation_link }}" title="Donation">
															<li><i data-feather="framer"></i>{{ __('frontstaticword.Donation') }}
															</li>
														</a>
													@endif

													@if (Schema::hasTable('affiliate') && Schema::hasTable('wallet_settings'))
														@if (isset($wallet_settings) && $wallet_settings->status == 1)
															<a href="{{ url('/wallet') }}">
																<li><i class="icon-wallet icons"></i>{{ __('frontstaticword.MyWallet') }}
																</li>
															</a>
														@endif

														@if (isset($affiliate) && $affiliate->status == 1)
															<a href="{{ route('get.affiliate') }}">
																<li><i data-feather="users"></i>{{ __('frontstaticword.Affiliate') }}
																</li>
															</a>
														@endif
													@endif

													{{-- <a href="{{ route('compare.index') }}"><li><i data-feather="bar-chart"></i>{{ __("Compare") }}</li></a> --}}

													@if (Module::has('Resume') && Module::find('Resume')->isEnabled())
														@include('resume::front.searchresume')
													@endif
													@if (Module::has('Resume') && Module::find('Resume')->isEnabled())
														@include('resume::front.job.icon')
													@endif


													@if (Module::find('Forum') && Module::find('Forum')->isEnabled())
														@if ($gsetting->forum_enable == 1)
															@include('forum::layouts.sidebar_menu')
														@endif
													@endif
													<a href="{{ route('my.leaderboard') }}">
														<li><i class="icon-chart icons"></i>{{ __('frontstaticword.MyLeaderboard') }}
														</li>
													</a>
													@if (Auth::User()->role == 'user')
														<a href="{{ route('studentprofile') }}">
															<li><i data-feather="share"></i>{{ __('Share profile') }}
															</li>
														</a>
													@endif
												</div>


												<a href="{{ route('logout') }}"
													onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
													<div id="notificationFooter">
														{{ __('frontstaticword.Logout') }}

														<form id="logout-form" action="{{ route('logout') }}" method="POST" class="display-none">
															@csrf
														</form>
													</div>
												</a>
											</ul>
										</div>
									</div>
								</div>
							</div>
						@endauth
					</div>
				</div>
			</div>
		</div>
	</nav>
</section>

<!-- start search -->
<div id="find" class="small-screen-navigation">
	<button type="button" class="close">×</button>
	<form action="{{ route('search') }}" class="form-inline search-form" method="GET">
		<input type="find" name="searchTerm" class="form-control" id="search"
			placeholder="{{ __('frontstaticword.Searchforcourses') }}" value="{{ isset($searchTerm) ? $searchTerm : '' }}">
		<button type="submit" class="btn btn-outline-info btn_sm">Search</button>
	</form>
</div>
<!-- start end -->


<!-- side navigation  -->
<script>
	const navigation = document.querySelector('.main-navigation');
	const offset = 300;

	function toggleNavigation() {
		if (window.scrollY >= offset) {
			navigation.classList.add('fixed');
			navigation.style.transition = 'all 0.7s ease-in'; // Add transition effect to navigation
		} else {
			navigation.classList.remove('fixed');
			navigation.style.transition = 'all 0.5s ease-out'; // Add transition effect to navigation
		}
	}

	function throttle(callback, delay) { // Throttle function to limit scroll event firing rate
		let timeout = null;
		return function() {
			if (!timeout) {
				timeout = setTimeout(() => {
					callback();
					timeout = null;
				}, delay);
			}
		}
	}
	window.addEventListener('scroll', throttle(toggleNavigation,
		10)); // Use throttle function to limit scroll event firing rate
	window.addEventListener('scroll', toggleNavigation);

	function openNav() {
		document.getElementById("mySidenav").style.width = "250px";
	}

	function closeNav() {
		document.getElementById("mySidenav").style.width = "0";
	}
</script>

@include('instructormodel')

<style>
	/* body {
								overflow-x: hidden
				} */
	#nav-bar {
		max-width: 100% !important;
		/* padding: 60px; */
		overflow-x: visible !important;
	}

	.secondary {
		padding: 7px 15px;
		border-radius: 3px;
		font-weight: 500;
		font-size: 15px;
		background: #dde5d9 !important;
		color: #007b4e !important;
	}

	.secondary:hover {
		background-color: #007b4e !important;
		border: 1px solid #007b4e !important;
		box-shadow: 0px 0px 6px 6px #dde5d938 !important;
		color: #dde5d9 !important;
	}

	.main-navigation {
		position: absolute;
		top: 0;
		width: 100%;
		left: 0;
		right: 0;
		margin: 0;
		padding-bottom: 10px;
		background-color: transparent;
		/* box-shadow: 0 2px 4px rgba(0,0,0,0.1); */
		z-index: 9999;
		/* transform: translateY(0); */
		animation: main_navigation 0.5s ease-out;
		/* transition: transform 0.7s ease-out;  */
	}

	.scroll-down svg.feather {
		color: #007b4e !important;
	}

	@keyframes main_navigation {
		0% {
			transform: translateY(-100%);
		}

		100% {
			transform: translateY(0);
		}
	}

	.main-navigation.fixed {
		position: fixed;
		top: 0;
		left: 0;
		right: 0;
		margin: 0;
		background: #ffffff73;
		backdrop-filter: blur(15px);
		padding-bottom: 10px;
		/* opacity: 0.7; */
		/* color: #141d46 !important; */
		box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
		/* transition: transform 0.7s ease-out; /* Add transition property to transform */
		/* transform: translateY(0); */
		animation: main_fixed 0.7s ease-in;
		max-width: 100% !important;
		overflow-x: visible !important;
	}

	@media screen and (max-width: 768px) {
		.top-menu {
			margin-bottom: 10px;
		}

		.query-size {
			margin-top: 30px
		}

		/* .main-navigation.fixed{
												padding: 70px
								} */
	}

	@keyframes main_fixed {
		0% {
			transform: translateY(-100%);
		}

		100% {
			transform: translateY(0);
		}
	}

	.main-navigation.fixed #cssmenu>ul>li>a {
		color: #2E384D !important;
	}

	.main-navigation.fixed #cssmenu>ul>li:hover>a {
		border-bottom: 2px solid #2E384D !important;
	}

	.main-navigation.fixed .footer-dropdown .a {

		color: #007b4e !important;
	}

	.main-navigation.fixed .footer-dropdown .a>i {

		color: #007b4e !important;
	}

	.main-navigation.fixed svg.feather {
		color: #007b4e !important;
	}

	/* .dropdown ul li:hover svg.feather{
								color: #ffffff !important;
				} */
	.main-navigation.fixed .my-dropdown {
		display: flex;
		justify-content: center;
		align-content: center;
		align-items: center;
		border-radius: 30px;
		background-color: #007b4ea6;
		box-shadow: 0 5px 5px 0 rgb(0 0 0 / 5%);
		width: 110px;
	}

	.main-navigation.fixed .dropdown-toggle::after {
		color: #fff;
	}

	.main-navigation.fixed .green {
		display: block;
	}

	.main-navigation.fixed .white {
		display: none;
	}

	.green {
		display: none;
		margin-left: 20%;
	}

	/* .top-menu>div {
								height: 4vh;
								display: flex;
								justify-content: space-between;
								align-items: center;
				}

				.top-menu .numbers {
								display: flex;
								align-items: center;
				}

				.top-menu .social {
								display: flex;
								align-items: center;

				}

				.social a {
								margin: 5px;
								color: #fff !important;
				}

				.ltr {
								display: inline-block;
								direction: ltr !important;
				} */

	/* .top-menu {
								background-color: #2380c4;
								margin-bottom: 5px;
								margin: 0;
								max-width: 100%;
								width: 100%;
				}

				.top-menu .numbers a {
								display: block;
								margin-inline-end: 20px;
								color: #fff;
				} */

	.sidebar-nav-icon svg.feather {
		color: #007b4e !important
	}

	.lang {
		display: grid;
		align-items: center;
	}

	/* .main-navigation ul {
		display: flex;
		list-style: none;
		margin: 0;
		padding: 0;
}

.main-navigation li {
		margin: 0 10px;
}

.main-navigation a {
		color: #333;
		text-decoration: none;
		font-weight: bold;
		text-transform: uppercase;
		transition: color 0.2s ease-in-out;
}

.main-navigation a:hover {
		color: #0077cc;
} */
</style>
