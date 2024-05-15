@extends('theme.master')
@section('title', 'Purchase History')
@section('content')

    @include('admin.message')

    <!-- about-home start -->
    @php
        $gets = App\Breadcum::first();
    @endphp
    @if (isset($gets))
        <section id="business-home" class="business-home-main-block">
            <div class="business-img">
                @if ($gets['img'] !== null && $gets['img'] !== '')
                    <img src="{{ url('/images/breadcum/' . $gets->img) }}" class="img-fluid" alt="" />
                @else
                    <img src="{{ Avatar::create($gets->text)->toBase64() }}" alt="course" class="img-fluid">
                @endif
            </div>
            <div class="overlay-bg"></div>
            <div class="container-fluid">
                <div class="business-dtl">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="bredcrumb-dtl">
                                <h1 class="wishlist-home-heading text-white">{{ __('Purchase History') }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- about-home start -->

    <!-- about-home end -->

    <section id="purchase-block" class="purchase-main-block">
        <div class="container">
            <div class="purchase-table table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="purchase-history-heading">{{ __('Purchase History') }}</th>
                            <th class="purchase-text">{{ __('Enroll on') }}</th>
                            <th class="purchase-text">{{ __('Enroll End') }}</th>
                            <th class="purchase-text">{{ __('Payment Mode') }}</th>
                            <th class="purchase-text">{{ __('Total Price') }}</th>
                            <th class="purchase-text">{{ __('Payment Status') }}</th>
                            <th class="purchase-text">{{ __('Actions') }}</th>

                        </tr>
                    </thead>

                    @foreach ($orders as $order)

                        <div class="purchase-history-table">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="purchase-history-course-img">
                                            @if ($order->course_id != null)
                                                @if ($order->courses['preview_image'] !== null && $order->courses['preview_image'] !== '')
                                                    <a
                                                        href="{{ route('user.course.show', ['id' => $order->courses->id, 'slug' => $order->courses->slug]) }}"><img
                                                            src="{{ asset('images/course/' . $order->courses->preview_image) }}"
                                                            class="img-fluid" alt="course"></a>
                                                @else
                                                    <a
                                                        href="{{ route('user.course.show', ['id' => $order->courses->id, 'slug' => $order->courses->slug]) }}"><img
                                                            src="{{ Avatar::create($order->courses->title)->toBase64() }}"
                                                            class="img-fluid" alt="{{ __('course') }}"></a>
                                                @endif
                                            @else
                                                @if ($order->bundle['preview_image'] !== null && $order->bundle['preview_image'] !== '')
                                                    <a href="{{ route('bundle.detail', $order->bundle->id) }}"><img
                                                            src="{{ asset('images/bundle/' . $order->bundle->preview_image) }}"
                                                            class="img-fluid" alt="course"></a>
                                                @else
                                                    <a href="{{ route('bundle.detail', $order->bundle->id) }}"><img
                                                            src="{{ Avatar::create($order->bundle->title)->toBase64() }}"
                                                            class="img-fluid" alt="course"></a>
                                                @endif
                                            @endif

                                        </div>
                                        <div class="purchase-history-course-title">
                                            @if ($order->course_id != null)
                                                <a
                                                    href="{{ route('user.course.show', ['id' => $order->courses->id, 'slug' => $order->courses->slug]) }}">{{ $order->courses->title }}</a>
                                            @else
                                                <a
                                                    href="{{ route('bundle.detail', $order->bundle->id) }}">{{ $order->bundle->title }}</a>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="purchase-text">{{ date('jS F Y', strtotime($order->created_at)) }}
                                        </div>
                                    </td>

                                    <td>
                                        <div class="purchase-text">
                                            @if ($order->course_id != null)
                                                @if ($order->enroll_expire != null)
                                                    {{ date('jS F Y', strtotime($order->enroll_expire)) }}
                                                @else
                                                    -
                                                @endif
                                            @endif
                                        </div>
                                    </td>

                                    <td>
                                        <div class="purchase-text">{{ $order->payment_method }}</div>
                                    </td>



                                    <td>

                                        @php
                                            $contains = Illuminate\Support\Str::contains($order->currency_icon, 'fa');
                                        @endphp
                                        @if ($order->coupon_discount == !null)
                                            <div class="purchase-text">
                                                <b>
                                                    @if ($contains)
                                                        <i class="fa {{ $order->currency_icon }}"></i>
                                                    @else
                                                        {{ $order->currency_icon }}
                                                    @endif
                                                    {{ $order->total_amount - $order->coupon_discount }}
                                                </b>
                                            </div>
                                        @else
                                            <div class="purchase-text"><b>
                                                    @if ($contains)
                                                        <i class="fa {{ $order->currency_icon }}"></i>
                                                    @else
                                                        {{ $order->currency_icon }}
                                                    @endif
                                                    {{ $order->total_amount }}
                                                </b></div>
                                        @endif

                                    </td>

                                    <td>
                                        <div class="purchase-text">
                                            @if ($order->status == 1)
                                                {{ __('Recieved') }}
                                            @else
                                                @if (isset($order->bundle))
                                                    {{ __('Pending') }}
                                                    {{-- @if ($order->bundle['subscription_status'] !== 'active')
	                                                {{ __('Cancelled') }}
	                                            @else
	                                                {{ __('Pending') }}
	                                            @endif --}}
                                                @endif
                                            @endif
                                        </div>
                                    </td>

                                    <td>
                                        <div class="invoice-btn">

                                            <a href="{{ route('invoice.show', $order->id) }}"
                                                class="btn btn-secondary">{{ __('Invoice') }}</a>

                                        </div>

                                        @if ($order->subscription_status == 'active' && $order->payment_method !== 'Admin Enroll')
                                            <div class="unsubscribe-btn">
                                                <form id="unsubscribeForm"
                                                    action="{{ route('stripe.cancelsubscription') }}" method="POST"
                                                    accept-charset="UTF-8">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" value="{{ $order->id }}" name="order_id">
                                                    <a onclick="document.getElementById('unsubscribeForm').submit()"
                                                        class="btn btn-secondary">{{ __('UnSubscribe') }}</a>
                                                </form>
                                            </div>
                                        @endif

                                        @php
                                            $order_id = Crypt::encrypt($order->id);
                                            
                                            $cor = $order->course_id;
                                            
                                            $course = App\Course::where('id', $cor)->first();
                                            
                                            $ref = App\RefundPolicy::where('id', optional($course)->refund_policy_id)->first();
                                            
                                            $days = isset($ref['days']);
                                            
                                            $orderDate = $order['created_at'];
                                            
                                            $startDate = date('Y-m-d', strtotime("$orderDate +$days days"));
                                            
                                            $mytime = Carbon\Carbon::now();
                                            
                                        @endphp

                                        @php
                                            
                                            $requested = App\RefundCourse::where('user_id', Auth::User()->id)
                                                ->where('course_id', $order->course_id)
                                                ->first();
                                            
                                        @endphp


                                        @if ($requested == null)
                                            @if ($order->id)
                                                @if ($order->status == 1)
                                                    @if ($startDate >= $mytime)
                                                        <div class="invoice-btn">

                                                            <a href="{{ route('refund.proceed', $order_id) }}"
                                                                class="btn btn-secondary">{{ __('Refund') }}</a>

                                                        </div>
                                                    @endif
                                                @endif
                                            @endif

                                        @endif


                                    </td>


                                </tr>
                            </tbody>
                        </div>

                    @endforeach
                </table>
            </div>
        </div>
    </section>


    <section id="purchase-block" class="purchase-main-block">
        <div class="container">
            <div class="purchase-table table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="purchase-history-heading">{{ __('Refunds') }}</th>
                            <th class="purchase-text">{{ __('Date') }}</th>
                            <th class="purchase-text">{{ __('Amount') }}</th>
                            <th class="purchase-text">{{ __('Payment Mode') }}</th>
                            <th class="purchase-text">{{ __('Payment Status') }}</th>
                            <th class="purchase-text">{{ __('Actions') }}</th>

                        </tr>
                    </thead>


                    @foreach ($refunds as $refund)
                        <div class="purchase-history-table">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="purchase-history-course-img">
                                            @if ($refund->courses['preview_image'] !== null && $refund->courses['preview_image'] !== '')
                                                <a
                                                    href="{{ route('user.course.show', ['id' => $refund->courses->id, 'slug' => $refund->courses->slug]) }}"><img
                                                        src="{{ asset('images/course/' . $refund->courses->preview_image) }}"
                                                        class="img-fluid" alt="course"></a>
                                            @else
                                                <a
                                                    href="{{ route('user.course.show', ['id' => $refund->courses->id, 'slug' => $refund->courses->slug]) }}"><img
                                                        src="{{ Avatar::create($refund->courses->title)->toBase64() }}"
                                                        class="img-fluid" alt="course"></a>
                                            @endif
                                        </div>
                                        <div class="purchase-history-course-title">
                                            <a
                                                href="{{ route('user.course.show', ['id' => $refund->courses->id, 'slug' => $refund->courses->slug]) }}">{{ $refund->courses->title }}</a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="purchase-text">{{ date('jS F Y', strtotime($refund->updated_at)) }}
                                        </div>
                                    </td>
                                    <td>
                                        @if ($gsetting['currency_swipe'] == 1)
                                            <div class="purchase-text"><i
                                                    class="fa {{ $refund->currency_icon }}"></i>{{ $refund->total_amount }}
                                            </div>
                                        @else
                                            <div class="purchase-text">{{ $refund->total_amount }}<i
                                                    class="fa {{ $refund->currency_icon }}"></i></div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="purchase-text">{{ $refund->payment_method }}</div>
                                    </td>
                                    <td>
                                        <div class="purchase-text">
                                            @if ($refund->status == 1)
                                                {{ __('Refunded') }}
                                            @else
                                                {{ __('Pending') }}
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="invoice-btn">

                                            <a href="{{ route('invoice.show', $refund->id) }}"
                                                class="btn btn-secondary">{{ __('Invoice') }}</a>

                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </div>
                    @endforeach
                </table>
            </div>
        </div>
    </section>

@endsection
