@extends('admin.layouts.master')
@section('title','Report')
@section('maincontent')
@component('components.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('Report') }}
@endslot

@slot('menu1')
   {{ __(' Quiz Report') }}
@endslot
@endcomponent
<div class="contentbar"> 
  <div class="row">
    <div class="col-lg-12">
          <div class="card m-b-30">
              <div class="card-header">
                  <h5 class="card-title">{{ __('All Quiz Report') }}</h5>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                      <table id="datatable-buttons" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>User Name</th>
                              <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                            
                              @foreach($user as $key => $u)
                             
                                <tr>
                                  <td>
                                    {{$key+1}}
                                  </td>
                                 
                                
                                  <td>{{$u->fname}} {{$u->lname}}</td>               
                                <td>
                                  <div class="btn-group mr-2">
                                            <a  href="{{url('show/quiz/report/'.$u->id)}}" class="btn btn-xs btn-primary-rgba"><i class="feather icon-eye mr-2"></i>{{ __('View') }}</a>
                                </div>
                                </td>
                                  
                                </tr> 
                              @endforeach
            
                          
                          </tbody>
             
            </table>
          </div>
      </div>
  </div>
</div>
<!-- End col -->
</div>
<!-- End row -->
</div>
@endsection

