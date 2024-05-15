@extends('admin.layouts.master')
@section('title', 'Pending Instructor Request - Admin')
@section('maincontent')
 

@component('components.breadcumb',['thirdactive' => 'active'])
@slot('heading')
   {{ __('Instructor Request') }}
@endslot
@slot('menu1')
   {{ __('Instructor') }}
@endslot
@slot('menu2')
   {{ __('Pending Instructor Request') }}
@endslot

@slot('button')
<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
     @can(' instructor-pending-request.manage')
      <a href="page-product-detail.html" class="btn btn-danger-rgba"  data-toggle="modal" data-target=".bd-example-modal-sm1"><i class="feather icon-trash mr-2"></i>{{ __('Delete Selected') }}</a>
       @endcan                         
      <div class="modal fade bd-example-modal-sm1" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-sm">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body text-center">
                      <p class="text-muted">{{ __("Do you really want to delete these records? This process cannot be undone.")}}</p>
                  </div>
                  <div class="modal-footer">
                    
                    
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close")}}</button>
                      <button type="submit" class="btn btn-primary">{{ __("Delete")}}</button>
                  </form>
                  </div>
              </div>
          </div>
      </div>
  </div>                        
</div>
@endslot
@endcomponent


  <div class="contentbar">                
    <!-- Start row -->
    <div class="row">
    
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="box-title">{{ __('Pending Instructor Request')}}</h5>
                </div>
                <div class="card-body">
                 
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                              <tr>
                                <th>{{ __('adminstaticword.Image') }}</th>
                                <th>{{ __('adminstaticword.Name') }}</th>
                                <th>{{ __('adminstaticword.Email') }}</th>
                                <th>{{ __('adminstaticword.Detail') }}</th>
                                <th>{{ __('adminstaticword.Status') }}</th>
                                <th>{{ __('adminstaticword.Action') }}</th>
                               
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($items as $item)
                              <tr>
                                @if($item->status == '0')
                                  <td><img src="{{ asset('images/instructor/'.$item->image)}}" class="img-circle"></td> 
                                  <td>{{$item->fname}}</td>
                                  <td>{{$item->email}}</td>
                                  <td>{{ str_limit($item->detail, $limit= 50, $end = '...')}}</td>
                                  <td>
                                    @if($item->status==1)
                                    <span class="badge badge-pill badge-success"> {{ __('adminstaticword.Approved') }}</span>
                                     
                                    @else
                                    <span class="badge badge-pill badge-warning"> {{ __('adminstaticword.Pending') }}</span>
                                    @endif
                                  </td>
                               <td>
                                <div class="dropdown">
                                    <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                                    <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
                                        @can('instructorrequest.edit')
                                        <a class="dropdown-item"   href="{{route('requestinstructor.edit',$item->id)}}"><i class="feather icon-eye mr-2"></i>{{ __("View")}}</a>
                                        @endcan
                                        @can('instructorrequest.delete')
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
                                            <form  method="post" action="{{url('requestinstructor/'.$item->id)}}
                                              "data-parsley-validate class="form-horizontal form-label-left">
                                              {{ csrf_field() }}
                                              {{ method_field('DELETE') }}
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close")}}</button>
                                              <button type="submit" class="btn btn-primary">{{ __("Delete")}}</button>
                                          </form>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                             
                            </tr>   
                            @endif  
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

                                      
                                    
                                     
                                      
                                    
                                   
                              
                               
                                
    
              
                               
                              
                
                               
                              
