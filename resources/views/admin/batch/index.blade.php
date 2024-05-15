@extends('admin.layouts.master')
@section('title','All Batch')
@section('maincontent')
@component('components.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('Batches') }}
@endslot

@slot('menu1')
   {{ __('Batch') }}
@endslot

@slot('button')

<div class="col-md-4 col-lg-4">
    <div class="widgetbar">
        @can('batch.create')
        <a href="{{ route('batch.create') }}"  class="float-right btn btn-primary-rgba mr-2"><i class="feather icon-plus mr-2"></i>{{ __('Add Batch') }}</a>
        @endcan
        @can('batch.delete')
        <a href="page-product-detail.html" class="btn btn-danger-rgba mr-2"  data-toggle="modal" data-target=".bd-example-modal-sm1"><i class="feather icon-trash mr-2"></i>{{ __('Delete Selected') }}</a>
        @endcan                     
        <div class="modal fade bd-example-modal-sm1" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5  class="modal-title">{{ __('Delete') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <p class="text-muted">{{ __("Do you really want to delete these records? This process cannot be undone.")}}</p>
                    </div>
                    <div class="modal-footer">
                      
                      <form method="post" action="{{ action('BatchController@batchdeleteAll') }}
                      " id="bulk_delete_form" data-parsley-validate class="form-horizontal form-label-left">
                      {{ csrf_field() }}
                    
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("No")}}</button>
                        <button type="submit" class="btn btn-danger">{{ __("Yes")}}</button>
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
  <div class="row">
      
      <div class="col-lg-12">
          <div class="card m-b-30">
              <div class="card-header">
                  <h5 class="card-box">{{ __('All Batches') }}</h5>
              </div>
              <div class="card-body">
              
                  <div class="table-responsive">
                      <table id="datatable-buttons" class="table table-striped table-bordered">
                          <thead>
                          <tr>
                            <th> <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]"
                              value="all" />
                          <label for="checkboxAll" class="material-checkbox"></label>#</th>
                            <th>{{ __('adminstaticword.Image') }}</th>
                            <th>{{ __('adminstaticword.Title') }}</th>
                            <th>{{ __('adminstaticword.Instructor') }}</th>
                            <th>{{ __('adminstaticword.Slug') }}</th>
                            <th>{{ __('adminstaticword.Featured') }}</th>
                            <th>{{ __('adminstaticword.Status') }}</th>
                            <th>{{ __('adminstaticword.Action') }}</th>
                            
                        </thead>
          
                        <tbody>
                          <?php $i=0;?>
                            @if(Auth::User()->role == "admin")
                              @foreach($course as $cat)
                                <?php $i++;?>
                                <tr>
                                  <td>
                                    <input type='checkbox' form='bulk_delete_form' class='check filled-in material-checkbox-input'
                                    name='checked[]' value='{{ $cat->id }}' id='checkbox{{ $cat->id }}'>
                                   <label for='checkbox{{ $cat->id }}' class='material-checkbox'></label>
                                   <?php echo $i; ?>
                                
                            
                                  </td>
                                  <td>
                                    @if($cat['preview_image'] !== NULL && $cat['preview_image'] !== '')
                                        <img src="images/batch/<?php echo $cat['preview_image'];  ?>" class="img-circle" >
                                    @else
                                        <img src="{{ Avatar::create($cat->title)->toBase64() }}" class="img-circle" >
                                    @endif
                                  </td>
                                  <td>{{$cat->title}}</td>
                                  <td>@if(isset($cat->user)){{ $cat->user['fname'] }} @endif</td>
                                  <td>{{$cat->slug}}</td>
                                  <td>
                                    <label class="switch">
                                      <input class="batchfeatured" type="checkbox"  data-id="{{$cat->id}}" name="status"  {{ $cat['featured'] ==1 ? 'checked' : ''}}>
                                      <span class="knob"></span>
                                    </label>
                                    </td>

                                    <td>
                                      <label class="switch">
                                        <input class="batchstatus" type="checkbox"  data-id="{{$cat->id}}"    {{ $cat->status ==1 ? 'checked' : ''}}>
                                        <span class="knob"></span>
                                      </label>
                                      </td>


                                 
                                  <td>
                                    <div class="dropdown">
                                        <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                                        <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                            <a class="dropdown-item" href="{{ route('batch.show',$cat->id) }}"><i class="feather icon-edit mr-2"></i>{{ __('Edit') }}</a>
                                            <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $cat->id}}" >
                                                <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- delete Modal start -->
                                    <div class="modal fade bd-example-modal-sm" id="delete{{$cat->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                        <h4>{{ __('Are You Sure ?')}}</h4>
                                                        <p>{{ __('Do you really want to delete')}} ? {{ __('This process cannot be undone.')}}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="post" action="{{url('batch/'.$cat->id)}}" class="pull-right">
                                                        {{csrf_field()}}
                                                        {{method_field("DELETE")}}
                                                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{ __('No') }}</button>
                                                        <button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- delete Model ended -->

                                  </td>

                                       
                                     
                                 
                                </tr>
                              @endforeach
                            @else
                            
                              @php
                                $cors = App\Batch::where('user_id', Auth::User()->id)->get();
                              @endphp
                              @foreach($cors as $cor)
                                <?php $i++;?>
                                <tr>
                                  <td><?php echo $i;?></td>
                                  <td>
                                    @if($cor['preview_image'] !== NULL && $cor['preview_image'] !== '')
                                        <img src="images/course/<?php echo $cor['preview_image'];  ?>" class="img-circle">
                                    @else
                                        <img src="{{ Avatar::create($cor->title)->toBase64() }}" class="img-circle" >
                                    @endif
                                  </td>
                                  <td>{{$cor->title}}</td>
                                  <td>{{ $cor->user['fname'] }}</td>
                                  <td>{{$cor->slug}}</td>

                                  <td>
                                    <label class="switch">
                                      <input class="batchfeatured" type="checkbox"  data-id="{{$cat->id}}" name="status"  {{ $cat['featured'] ==1 ? 'checked' : ''}}>
                                      <span class="knob"></span>
                                    </label>
                                    </td>

                                    <td>
                                      <label class="switch">
                                        <input class="batchstatus" type="checkbox"  data-id="{{$cat->id}}" name="status"   {{ $cat->status ==1 ? 'checked' : ''}}>
                                        <span class="knob"></span>
                                      </label>
                                      </td>

                                 
                                  <td>
                                  
                                  <div class="dropdown">
                                      <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                                      <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                        @can('batch.edit')
                                          <a class="dropdown-item" href="{{ route('bundle.show',$cor->id) }}"><i class="feather icon-edit mr-2"></i>{{ __('Edit') }}</a>
                                          @endcan
                                          @can('batch.delete')
                                          <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $cor->id}}" >
                                              <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                                          </a>
                                          @endcan
                                      </div>
                                  </div>

                                  <!-- delete Modal start -->
                                  <div class="modal fade bd-example-modal-sm" id="delete{{$cor->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                      <div class="modal-dialog modal-sm">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                  </button>
                                              </div>
                                              <div class="modal-body">
                                                      <h4>{{ __('Are You Sure ?')}}</h4>
                                                      <p>{{ __('Do you really want to delete')}} ? {{ __('This process cannot be undone.')}}</p>
                                              </div>
                                              <div class="modal-footer">
                                                  <form method="post" action="{{url('bundle/'.$cor->id)}}" class="pull-right">
                                                      {{csrf_field()}}
                                                      {{method_field("DELETE")}}
                                                      <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{ __('No') }}</button>
                                                      <button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
                                                  </form>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <!-- delete Model ended -->

                                 </td>
          
                                  
                                </tr>
                              @endforeach
                            @endif
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
@section('scripts')
<script>
  "use Strict";

$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

 
      $(document).on("change",".batchstatus",function() {
        
        $.ajax({
            type: "POST",
            dataType: "json",
            url:"{{url('batch/status')}}",
            data:{'status': $(this).is(':checked') ? 1 : 0, 'id': $(this).data('id')},
            success: function(data){
              console.log(data)
            }
        });
   
  })

  

$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

      $(document).on("change",".batchfeatured",function() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url:"{{url('batch/features')}}",
            data:{'features': $(this).is(':checked') ? 1 : 0, 'id': $(this).data('id')},
            success: function(data){
              console.log(data)
            }
        });
      })
</script>


@endsection