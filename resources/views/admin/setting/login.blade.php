@extends('admin.layouts.master')
@section('title', 'Login - Setting')
@section('maincontent')
@component('components.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Login/Signup') }}
@endslot
@slot('menu1')
{{ __('Front Settings') }}
@endslot
@slot('menu2')
{{ __('Login/Signup') }}
@endslot
@endcomponent
<div class="contentbar">
    @if ($errors->any())
    <div class="alert alert-danger" role="alert">
        @foreach($errors->all() as $error)
        <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true" style="color:red;">&times;</span></button></p>
        @endforeach
    </div>
    @endif


    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">{{ __('Login/Signup') }}</h5>
                </div>
                <div class="card-body">
                    <form class="form" action="{{ route('login.update') }}" method="POST" novalidate
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="text-dark" for="exampleInputSlug">{{ __('adminstaticword.Image') }}:
                                </label>


                                <div class="input-group mb-3">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                            id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                                    </div>
                                    <div class="custom-file">

                                        <input type="file" name="img" class="custom-file-input" id="img"
                                            aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label"
                                            for="inputGroupFile01">{{ __('Choose file') }}</label>
                                    </div>
                                </div>
                                @if($setting['img'] !== NULL && $setting['img'] !== '')
                                <img src="{{ url('/images/login/'.$setting->img) }}" height="100px;" width="100px;" />
                                @else
                                <img src="{{ Avatar::create($setting->text)->toBase64() }}" alt="course"
                                    class="img-fluid">
                                @endif
                            </div>
                            <div class="form-group col-md-12">
                                <label class="text-dark">{{ __('adminstaticword.Text') }}:</label>
                                <input name="text" value="{{ $setting->text }}" autofocus="" type="text"
                                    class="{{ $errors->has('text') ? ' is-invalid' : '' }} form-control"
                                    placeholder="Enter text" required="">
                                <div class="invalid-feedback">
                                    {{ __('Please enter text!') }}.
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