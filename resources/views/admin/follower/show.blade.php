@extends('admin.layouts.master')
@section('title','Followers')
@section('maincontent')
@component('components.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('Followers') }}
@endslot

@slot('menu1')
   {{ __('Followers') }}
@endslot
@slot('button')


@endslot
@endcomponent
<div class="contentbar"> 
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        
       <div class="box-body">
       
    <div class="col-md-12">
      <div class="card m-b-30">
          <div class="card-header">
              <h5 class="card-box">{{ __('Followers/Following') }}</h5>
          </div>
          <div class="card-body">
              <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                  <li class="nav-item">
                      <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">{{ __('Followers') }}</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">{{ __('Following') }}</a>
                  </li>
                  
              </ul>
              <div class="tab-content" id="pills-tabContent">
                  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    @include('admin.follower.follower')
                  </div>
                  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    @include('admin.follower.following')
                  </div>
                 
              </div>
          </div>
      </div>
  </div>
       </div>
      </div>
    </div>
  </div>
</div>
@endsection