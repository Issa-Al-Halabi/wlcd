@extends('admin.layouts.master')
@section('title', 'Zoom Setting')
@section('maincontent')


@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
{{ __('Zoom Setting') }}
@endslot
@slot('menu1')
{{ __('Meetings') }}
@endslot
@slot('menu2')
{{ __('Zoom Live Mettings') }}
@endslot
@slot('menu3')
{{ __('Zoom Settings') }}
@endslot
@slot('button')
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
          <h5 class="card-title">{{ __('Zoom Settings') }}</h5>
        </div>
        <div class="card-body">

          <form action="{{ route('updateToken') }}" method="POST">
            @csrf

          <div class="row">
            <div class="col-md-6">

              <div class="form-group">
                <label>{{ __('adminstaticword.ZoomEmail') }}:</label>
                  <div class="input-group mb-3">
                    <input id="password-field" value="{{ Auth::user()->zoom_email }}" type="password"  name="zoom_email" class="form-control" placeholder="user@example.com">
                    <div class="input-group-prepend text-center">
                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span></i></span>
                    </div>
                  </div>
              </div>

            
                   
                 
                <div class="form-group">
                  <label>{{ __('adminstaticword.ZoomJWTToken') }}:</label>
                  <textarea name="jwt_token" class="form-control" rows="5" cols="30" placeholder="Enter your JWT Token here">{{ Auth::user()->jwt_token }}</textarea>
                </div>
            </div>

            <div class="col-md-6">
              <h4 style="color: black"><i class="fa fa-question-circle"></i> How to get JWT Token and Email : </h4>
              <hr>
             <div class="panel panel-default">
              <div class="panel-body">
              <ul>
                <li>First Sign up or Sign in here : <a href="https://marketplace.zoom.us/" target="_blank">Zoom Market Place Portal</a></li>
                 <li>Click on Top right side menu and click on build app : <a href="https://marketplace.zoom.us/develop/create" target="_blank">Create app</a></li>
                 <li>Choose JWT App and Continue...</li>
                 <li>After filling details click on credtional tab and bottom you will see <b>JWT Token</b> change token expiry accroding to your setting.</li>
                 <li>Paste your zoom email account id and JWT token here and create,edit meetings here.</li>
              </ul>
            </div>
            </div>
            </div>
            </div>
            
            <div class="form-group">
							<button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
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

