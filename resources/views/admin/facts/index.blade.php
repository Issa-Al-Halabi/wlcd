@extends('admin.layouts.master')
@section('title', 'Fact - Admin')
@section('maincontent')
@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
   {{ __('Fact') }}
@endslot
@slot('menu1')
{{ __('Fact') }}
@endslot
@slot('button')
<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
    @can('front-settings.factsetting.create')
      <a href="{{ route('fact.create') }}" class="btn btn-primary-rgba"><i class="feather icon-plus mr-2"></i>{{ __("Add Fact")}}</a>
    </div>
    @endcan
</div>
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
  <!-- Start row -->
  <div class="row">
  
      <div class="col-lg-12">
          <div class="card m-b-30">
              <div class="card-header">
                  <h5 class="card-title">{{ __('Fact')}}</h5>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  @if(Auth::User()->role == "admin")
                  <table id="datatable-buttons" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>{{ __('Id') }}</th>
                        <th>{{ __('Image') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Detail') }}</th>
                        <th>{{ __('Number') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Action') }}</th>
                      </tr>
                        </thead>
                        <tbody>
                          @foreach($facts as $key => $fact)
                          <tr>
                              <td>{{ filter_var($key+1) }}</td>
                              <td><img src="{{ asset('images/facts/'.$fact->image) }}" class="img-responsive img-circle" ></td>
                              <td>{{$fact->title}}</td>
                              <td>{{$fact->description}}</td> 
                              <td>{{$fact->number}}</td>
                              <td>
                                <button type="button" class="btn btn-rounded {{ ($fact->status == '1' ? 'checked' : '') ? 'btn-success-rgba' : 'btn-danger-rgba' }}" data-toggle="modal" data-target="#myModal">
                                  @if( $fact->status)
                                    {{ __('adminstaticword.Active') }}
                                    @else
                                    {{ __('adminstaticword.Deactive') }}
                                    @endif 
                              </button>
                              </td>
                              <td>
                                <div class="dropdown">
                                  <button  class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                                  <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
                                    @can('front-settings.factsetting.edit')
                                      <a class="dropdown-item" href="{{url('fact/'.$fact->id.'/edit')}}" ><i class="feather icon-edit mr-2"></i>{{ __("Edit")}}</a>
                                      @endcan
                                      @can('front-settings.factsetting.delete')
                                      <a class="dropdown-item" data-toggle="modal" data-target=".bd-example-modal-sm"><i class="feather icon-delete mr-2"></i>{{ __("Delete")}}</a>
                                      @endcan
                                  </div>
                                </div>
                              </td>
                                <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                                  <div class="modal-dialog modal-sm">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>
                                          <div class="modal-body">
                                              <p class="text-muted">{{ __("Do you really want to delete these records? This process cannot be undone.")}}</p>
                                          </div>
                                          <div class="modal-footer">
                                            <form  method="post" action="{{ route('fact.destroy', $fact->id)}}
                                              "data-parsley-validate class="form-horizontal form-label-left">
                                              {{ csrf_field() }}
                                              {{ method_field('DELETE') }}
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("No")}}</button>
                                              <button type="submit" class="btn btn-danger">{{ __("Yes")}}</button>
                                          </form>
                                          </div>
                                      </div>
                                  </div>
                                </div>
                              </td>
                              </tr>   
                            @endforeach
                          </tbody>
                  </table>
                  @endif

               
                </div>
              </div>
          </div>
      </div>
    <!-- End col -->
  </div>
<!-- End row -->
</div> 
@endsection