@extends('admin.layouts.master')
@section('title', 'Add Faq - Admin')
@section('maincontent')
    @component('components.breadcumb', ['fourthactive' => 'active'])
        @slot('heading')
            {{ __('Add Faq') }}
        @endslot
        @slot('menu1')
            {{ __('Add Faq') }}
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
                        <h5 class="card-box"> {{ __('adminstaticword.Add') }} {{ __('adminstaticword.FAQ') }}</h5>
                    </div>

                    <!-- card body started -->
                    <div class="card-body">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                                    role="tab" aria-controls="pills-home" aria-selected="true">{{ __('English') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                                    role="tab" aria-controls="pills-profile"
                                    aria-selected="false">{{ __('Arabic') }}</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab">
                                @include('admin.faq.faq_form_en')
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                aria-labelledby="pills-profile-tab">
                                @include('admin.faq.faq_form_ar')
                            </div>

                        </div>
                    </div>
                    <!-- card body end -->

                </div><!-- col end -->
            </div>
        </div>
    </div><!-- row end -->
    <br><br>
@endsection
<!-- main content section ended -->
<!-- This section will contain javacsript start -->
@section('script')
    <!-- editor js start -->
    <script src="{{ url('admin_assets/assets/js/tinymce.min.js') }}"></script>
    <script src="{{ url('admin_assets/assets/js/master.js') }}"></script>
    <!-- editor js end -->
@endsection
<!-- This section will contain javacsript end -->
