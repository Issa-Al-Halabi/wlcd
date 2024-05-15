@extends('admin.layouts.master')
@section('title','All Countries')
@section('maincontent')
 

@component('components.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('Countries') }}
@endslot
@slot('menu1')
   {{ __('Countries') }}
@endslot


@slot('button')
<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
    @can('locations.country.delete')
      <a  href=" {{url('admin/country/create')}}" class="btn btn-primary-rgba"><i class="feather icon-plus mr-2"></i>{{ __("Add Country")}}</a>
      @endcan
    
                            
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
                    <h5 class="box-title">{{ __('Countries')}}</h5>
                </div>
                <div class="card-body">
                 
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                              <th> 
                                {{ __("#")}}</th>
                              <th>{{ __("Country Name")}} </th>
                              <th>{{ __("ISO Code 2")}}</th>
                              <th>{{ __("ISO Code 3")}}</th>
                              <th>{{ __("Action")}}</th>
                      
                            </tr>
                            </thead>
                            <tbody>
                              <?php $i=0;?> 
                              @foreach ($countries as $country)

                                <tr>
                                  <?php $i++;?>
                                  <td>
 
                                   
                                  <?php echo $i;?></td>
                                  <td>{{ $country->nicename }}</td>
                                  <td>{{ $country->iso }}</td>
                                  <td>{{ $country->iso3 }}</td>
                               <td>
                                
                                  <div class="dropdown">
                                      <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                                      <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
                                        @can('locations.country.edit')
                                          <a class="dropdown-item"   href="{{url('admin/country/'.$country->id. '/edit')}}"><i class="feather icon-edit mr-2"></i>{{ __("Edit")}}</a>
                                          @endcan
                                          @can('locations.country.delete')
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
                                              <form  method="post" action="{{url('admin/country/'.$country->id)}}
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
                               
                              
                                @endforeach
                              </tr>
                              
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
