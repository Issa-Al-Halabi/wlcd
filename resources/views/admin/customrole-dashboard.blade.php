@extends('admin.layouts.master')
@section('title',__('Admin Dashboard'))
@section('breadcum')
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">{{ __('Home') }}</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Dashboard') }}</li>
                </ol>
            </div>
        </div>
 </div>
</div>
@endsection
@section('maincontent')
<div class="contentbar">
    <!-- Start row -->
    <div class="row">

        <!-- Start col -->
        <div class="col-lg-12">
           <h3> {{ auth()->user()->getRoleNames()[0] }} {{ __('Dashboard') }} </h3>
        </div>
        <div class="col-md-12">
        <div class="card bg-primary-rgba m-b-30">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h5 class="card-title text-primary mb-1">Welcome, {{ Auth::user()->fname}}
                        </h5>
                        <p class="mb-0 text-primary font-14">"May the sun shine brightest, Today"</p>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection