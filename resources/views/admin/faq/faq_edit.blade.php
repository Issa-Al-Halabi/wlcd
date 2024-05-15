@extends('admin.layouts.master')
@section('title', 'Edit Faq - Admin')
@section('maincontent')
    @component('components.breadcumb', ['fourthactive' => 'active'])
        @slot('heading')
            {{ __('Edit Faq') }}
        @endslot
        @slot('menu1')
            {{ __('Edit Faq') }}
        @endslot
        @slot('button')
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{ url('faq') }}" class="btn btn-primary-rgba"><i
                            class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
                </div>
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

            <!-- row started -->
            <div class="col-lg-12">

                <div class="card m-b-30">
                    <!-- Card header will display you the heading -->
                    <div class="card-header">
                        <h5 class="card-box"> {{ __('adminstaticword.Edit') }} {{ __('adminstaticword.FAQ') }}</h5>
                    </div>

                    <!-- card body started -->
                    <div class="card-body">
                        <div class="card-body">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a @if ($find->getTranslation('title', 'en', false) != null) class="nav-link active"
								@else
								class="nav-link" @endif
                                        id="pills-home1-tab" data-toggle="pill" href="#pills-home1" role="tab"
                                        aria-controls="pills-home" aria-selected="true">{{ __('English') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a @if ($find->getTranslation('title', 'en', false) != null) class="nav-link"
									@else
									class="nav-link active" @endif
                                        id="pills-profile1-tab" data-toggle="pill" href="#pills-profile1" role="tab"
                                        aria-controls="pills-profile" aria-selected="false">{{ __('Arabic') }}</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div @if ($find->getTranslation('title', 'en', false) != null) class="tab-pane fade show active"
								@else
								class="tab-pane fade show" @endif
                                    id="pills-home1" role="tabpanel" aria-labelledby="pills-home1-tab">

                                    <form action="{{ url('faq/' . $find->id) }}" class="form" method="POST" novalidate
                                        enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        {{ method_field('PATCH') }}
                                        <input type="hidden" name="lang" value="en" id="lang">

                                        <!-- row start -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- card start -->
                                                <div class="card">
                                                    <!-- card body start -->
                                                    <div class="card-body">
                                                        <!-- row start -->
                                                        <div class="row">

                                                            <div class="col-md-12">
                                                                <!-- row start -->
                                                                <div class="row">

                                                                    <!-- Title -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label
                                                                                class="text-dark">{{ __('adminstaticword.Title') }}:
                                                                                <span class="text-danger">*</span></label>
                                                                            <input type="text"
                                                                                value="{{ $find->getTranslation('title', 'en', false) }}" autofocus=""
                                                                                class="form-control @error('title') is-invalid @enderror"
                                                                                placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Title') }}"
                                                                                name="title" required="">
                                                                            @error('title')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <!-- details -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label
                                                                                class="text-dark">{{ __('adminstaticword.Detail') }}:
                                                                                <span class="text-danger">*</span></label>
                                                                            <textarea id="detail" name="details" class="@error('details') is-invalid @enderror"
                                                                                placeholder="Please Enter Description" required=""> {{ $find->getTranslation('details', 'en', false) }}</textarea>
                                                                            @error('details')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <!-- Status -->
                                                                    <div class="form-group col-md-2">
                                                                        <label class="text-dark"
                                                                            for="exampleInputDetails">{{ __('adminstaticword.Status') }}
                                                                            :</label><br>
                                                                        <input type="checkbox" class="custom_toggle"
                                                                            name="status"
                                                                            {{ $find->status == '1' ? 'checked' : '' }} />
                                                                        <input type="hidden" name="free" value="0"
                                                                            for="status" id="status">
                                                                    </div>

                                                                    <!-- update and reset button -->
                                                                    <div class="col-md-12">
                                                                        <button type="reset"
                                                                            class="btn btn-danger-rgba mr-1"><i
                                                                                class="fa fa-ban"></i>
                                                                            {{ __('Reset') }}</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary-rgba"><i
                                                                                class="fa fa-check-circle"></i>
                                                                            {{ __('Update') }}</button>
                                                                    </div>

                                                                </div><!-- row end -->
                                                            </div><!-- col end -->
                                                        </div><!-- row end -->

                                                    </div><!-- card body end -->
                                                </div><!-- card end -->
                                            </div><!-- col end -->
                                        </div><!-- row end -->
                                    </form>
                                </div>
                                <div @if ($find->getTranslation('title', 'en', false) != null) class="tab-pane fade show"
								@else
								class="tab-pane fade show active" @endif
                                    id="pills-profile1" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    <form action="{{ url('faq/' . $find->id) }}" class="form" method="POST"
                                        novalidate enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        {{ method_field('PATCH') }}
                                        <input type="hidden" name="lang" value="ar" id="lang">

                                        <!-- row start -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- card start -->
                                                <div class="card">
                                                    <!-- card body start -->
                                                    <div class="card-body">
                                                        <!-- row start -->
                                                        <div class="row">

                                                            <div class="col-md-12">
                                                                <!-- row start -->
                                                                <div class="row">

                                                                    <!-- Title -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label
                                                                                class="text-dark">{{ __('adminstaticword.Title') }}:
                                                                                <span class="text-danger">*</span></label>
                                                                            <input type="text"
                                                                                value="{{ $find->getTranslation('title', 'ar', false) }}"
                                                                                autofocus=""
                                                                                class="form-control @error('title') is-invalid @enderror"
                                                                                placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Title') }}"
                                                                                name="title" required="">
                                                                            @error('title')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <!-- details -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label
                                                                                class="text-dark">{{ __('adminstaticword.Detail') }}:
                                                                                <span class="text-danger">*</span></label>
                                                                            <textarea id="detail" name="details" class="@error('details') is-invalid @enderror"
                                                                                placeholder="Please Enter Description" required="">{{ $find->getTranslation('details', 'ar', false) }}</textarea>
                                                                            @error('details')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                    <!-- Status -->
                                                                    <div class="form-group col-md-2">
                                                                        <label class="text-dark"
                                                                            for="exampleInputDetails">{{ __('adminstaticword.Status') }}
                                                                            :</label><br>
                                                                        <input type="checkbox" class="custom_toggle"
                                                                            name="status"
                                                                            {{ $find->status == '1' ? 'checked' : '' }} />
                                                                        <input type="hidden" name="free"
                                                                            value="0" for="status" id="status">
                                                                    </div>

                                                                    <!-- update and reset button -->
                                                                    <div class="col-md-12">
                                                                        <button type="reset"
                                                                            class="btn btn-danger-rgba mr-1"><i
                                                                                class="fa fa-ban"></i>
                                                                            {{ __('Reset') }}</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary-rgba"><i
                                                                                class="fa fa-check-circle"></i>
                                                                            {{ __('Update') }}</button>
                                                                    </div>

                                                                </div><!-- row end -->
                                                            </div><!-- col end -->
                                                        </div><!-- row end -->

                                                    </div><!-- card body end -->
                                                </div><!-- card end -->
                                            </div><!-- col end -->
                                        </div><!-- row end -->
                                    </form>
                                </div>

                            </div>
                        </div>

                        <!-- form start -->

                        <!-- form end -->

                    </div><!-- card body end -->

                </div><!-- col end -->
            </div>
        </div>
    </div><!-- row end -->
    <br><br>
@endsection
<!-- main content section ended -->
<!-- This section will contain javacsript start -->
@section('script')
@endsection
<!-- This section will contain javacsript end -->
