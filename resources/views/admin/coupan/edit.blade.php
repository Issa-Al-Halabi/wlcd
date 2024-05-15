@extends('admin.layouts.master')
@section('title','Edit Coupan - '.$coupan->coupanno)
@section('maincontent')

@component('components.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __('Admin') }}
@endslot

@slot('menu2')
{{ __(' Edit Coupan') }}
@endslot

@slot('button')
<div class="col-md-4 col-lg-4">
    <a href="{{ url('coupon') }}" class="float-right btn btn-primary-rgba mr-2"><i class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
</div>
@endslot

@endcomponent
<div class="contentbar">
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-box">{{ __('adminstaticword.Edit') }} {{ __('Coupan') }}</h5>
                </div>
                <div class="card-body ml-2">
                    <form action="{{ route('coupon.update', $coupan->id) }}" method="POST">
                        @csrf
                        {{ method_field('PUT') }}
                       
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('adminstaticword.CouponCode') }}: <span
                                                class="text-danger">*</span></label>
                                        <input value="{{ $coupan->code }}" type="text" class="form-control" name="code">
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('adminstaticword.DiscountType') }}: <span
                                                class="text-danger">*</span></label>

                                        <select required="" name="distype" id="distype" class="form-control select2">

                                            <option {{ $coupan->distype == 'fix' ? 'selected' : '' }} value="fix">
                                                {{ __('adminstaticword.FixAmount') }}</option>
                                            <option {{ $coupan->distype == 'per' ? 'selected' : '' }} value="per">%
                                                {{ __('adminstaticword.Percentage') }}</option>

                                        </select>

                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('adminstaticword.Amount') }}: <span
                                                class="text-danger">*</span></label>
                                        <input type="text" value="{{ $coupan->amount }}" class="form-control"
                                            name="amount">

                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('adminstaticword.Linkedto') }}: <span
                                                class="text-danger">*</span></label>

                                        <select required="" name="link_by" id="link_by" class="form-control select2">
                                            <option {{ $coupan->link_by == 'course' ? 'selected' : '' }} value="course">
                                                {{ __('adminstaticword.LinktoCourse') }}</option>
                                            <option {{ $coupan->link_by == 'cart' ? 'selected' : '' }} value="cart">
                                                {{ __('adminstaticword.LinktoCart') }}</option>
                                            <option {{ $coupan->link_by == 'category' ? 'selected' : '' }}
                                                value="category">
                                                {{ __('adminstaticword.LinktoCategory') }}</option>
                                            <option {{ $coupan->link_by == 'bundle' ? 'selected' : '' }} value="bundle">
                                                {{ __('adminstaticword.LinktoBundle') }}</option>
                                        </select>

                                    </div>

                                    <div style="{{ $coupan->link_by == 'course' ? '' : 'display: none' }}" id="probox"
                                        class="form-group">
                                        <label>{{ __('adminstaticword.SelectCourse') }}: <span
                                                class="text-danger">*</span> </label>
                                        <br>
                                        <select id="pro_id" name="course_id"
                                            class="form-control select2">
                                            <option value="none" selected disabled hidden>
                                                {{ __('adminstaticword.SelectanOption') }}
                                            </option>
                                            @foreach (App\Course::where('status', '1')->get() as $product)
                                            @if ($product->type == 1)
                                            <option {{ $coupan->course_id == $product->id ? 'selected' : '' }}
                                                value="{{ $product->id }}">{{ $product['title'] }} -
                                                {{ $product->discount_price }}<i
                                                    class="{{ $currency->icon }}">{{ $currency->currency }}</i>
                                            </option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div style="{{ $coupan->link_by == 'bundle' ? '' : 'display: none' }}"
                                        id="bundlebox" class="form-group">
                                        <label>{{ __('adminstaticword.SelectBundle') }}: <span
                                                class="text-danger">*</span> </label>
                                        <br>
                                        <select id="bundle_id" name="bundle_id"
                                            class="form-control select2">
                                            <option value="none" selected disabled hidden>
                                                {{ __('adminstaticword.SelectanOption') }}
                                            </option>
                                            @foreach (App\BundleCourse::where('status', '1')->get() as $product)
                                            @if ($product->type == 1)
                                            <option {{ $coupan->bundle_id == $product->id ? 'selected' : '' }}
                                                value="{{ $product->id }}">{{ $product['title'] }}
                                                @isset($product->billing_interval)
                                                - {{ $product->discount_price }} <i
                                                    class="{{ $currency->icon }}">{{ $currency->currency }}</i> /
                                                {{ $product->billing_interval }}
                                                @endisset()
                                            </option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                              
                               
                                    <div style="{{ $coupan->link_by == 'category' ? '' : 'display: none' }}" id="catbox"
                                        class="form-group">
                                        <label>{{ __('adminstaticword.SelectCategories') }}: <span
                                                class="text-danger">*</span> </label>
                                        <br>
                                        <select style="width: 100%" id="cat_id" name="category_id"
                                            class="form-control select2">
                                            <option value="none" selected disabled hidden>
                                                {{ __('adminstaticword.SelectanOption') }}
                                            </option>
                                            @foreach (App\Categories::where('status', '1')->get() as $category)
                                            <option {{ $coupan->category_id == $category->id ? 'selected' : '' }}
                                                value="{{ $category->id }}">{{ $category['title'] }}

                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>{{ __('adminstaticword.MaxUsageLimit') }}: <span
                                                class="text-danger">*</span></label>
                                        <input value="{{ $coupan->maxusage }}" type="number" min="1"
                                            class="form-control" name="maxusage">
                                    </div>
                                    <div style="{{ $coupan->link_by == 'product' ? 'display:none' : '' }}"
                                        id="minAmount" class="form-group">
                                        <label>{{ __('adminstaticword.MinAmount') }}: </label>
                                        <div class="input-group">
                                            
                                            <span class="input-group-addon"><i class="{{ $currency->icon }}"></i></span>
                                            <input value="{{ $coupan->minamount }}" type="number" min="0.0" value="0.00"
                                                step="0.1" class="form-control" name="minamount">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('adminstaticword.ExpiryDate') }}: </label>
                                        <div class="input-group">
                                            <span class="input-group-addon"></span>
                                            <input value="{{ date('Y-m-d', strtotime($coupan->expirydate)) }}"
                                                id="default-date" type="text" class="form-control" name="expirydate">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="exampleInputDetails">{{ __('adminstaticword.CouponCodedisplayonfront') }}:</label>
                                            <input type="checkbox" class="custom_toggle" name="show_to_users"
                                            {{ $coupan->show_to_users=="1" ? 'checked' : '' }} />
                        
                                      
                                        <label class="tgl-btn" data-tg-off="No" data-tg-on="Yes" for="frees"></label>

                                        <small class="txt-desc">({{ __('If Choose Yes then Coupon Code shows to all users') }})
                                        </small>
                                    </div>
                                    <div class="form-group">
                                        <button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i>
                                            {{ __('Reset') }}</button>
                                        <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                            {{ __('Update') }}</button>
                                    </div>
                                    <div class="clear-both"></div>
                              


                            </div>
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
    (function ($) {
        "use strict";

        $('#link_by').on('change', function () {
            var opt = $(this).val();

            if (opt == 'course') {
                $('#minAmount').hide();
                $('#probox').show();
                $('#catbox').hide();
                $('#bundlebox').hide();
                $('#pro_id').attr('required', 'required');
            } else if (opt == 'bundle') {
                $('#minAmount').hide();
                $('#probox').hide();
                $('#catbox').hide();
                $('#bundlebox').show();
                $('#bundle_id').attr('required', 'required');
            } else {
                $('#bundlebox').hide();
                $('#minAmount').show();
                $('#probox').hide();
                $('#catbox').show();
                $('#pro_id').removeAttr('required');
            }
        });

        $('#link_by').on('change', function () {
            var opt = $(this).val();

            if (opt == 'category') {
                $('#catbox').show();
                $('#probox').hide();
                $('#bundlebox').hide();
                $('#cat_id').attr('required', 'required');
            } else {
                $('#catbox').hide();
                $('#probox').show();
                $('#cat_id').removeAttr('required');
            }
        });

        $(function () {
            $("#expirydate").datepicker({
                dateFormat: 'yy-m-d'
            });
        });

    })(jQuery);
</script>

@endsection