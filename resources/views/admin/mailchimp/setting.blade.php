@extends('admin.layouts.master')
@section('title', 'Mailchimp Setting - Admin')
@section('maincontent')
@component('components.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Mailchimp Setting') }}
@endslot
@slot('menu1')
{{ __('Settings') }}
@endslot
@slot('menu2')
{{ __('Mailchimp Setting') }}
@endslot
@endcomponent
<div class="contentbar">
    @if ($errors->any())
    <div class="alert alert-danger" role="alert">
        @foreach($errors->all() as $error)
        <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true" class="text-danger">&times;</span></button></p>
        @endforeach
    </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">{{ __('Mailchimp Setting') }}</h5>
                </div>
                <div class="card-body">
                    <form class="form" action="{{ route('mailchimp.update') }}" method="POST" novalidate
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-dark" for="MAILCHIMP_APIKEY">{{ __('Mailchimp Apikey') }} <span class="text-danger">*</span></label>
                                    <input value="{{ env('MAILCHIMP_APIKEY') }}" autofocus name="MAILCHIMP_APIKEY" type="text" class="form-control" placeholder="Enter Mailchimp api Key"/>
                                </div>
                                </div> 
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="MAILCHIMP_LIST_ID">{{ __('Mailchimp listid') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('MAILCHIMP_LIST_ID') }}" autofocus name="MAILCHIMP_LIST_ID" type="text" class="form-control" placeholder="Enter  Mailchimp list id"/>
                                    </div>
                                    </div>
                        </div>
                        <div class="form-group">
                            <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i>
                                {{ __("Reset")}}</button>
                            <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                {{ __("Update")}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection