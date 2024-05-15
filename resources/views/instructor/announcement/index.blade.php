@extends('admin.layouts.master')
@section('title','All Announcement')
@section('maincontent')
@component('components.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('Announcement') }}
@endslot

@slot('menu1')
   {{ __('Announcement') }}
@endslot

@slot('button')

<div class="col-md-4 col-lg-4">
    <div class="widgetbar">
        
        <a href="{{ url('instructor/announcement/create') }}"  class="float-right btn btn-primary-rgba mr-2"><i class="feather icon-plus mr-2"></i>Add Announcement</a>
        
    </div>                        
</div>

@endslot
@endcomponent
<div class="contentbar"> 
  <div class="row">
      
      <div class="col-lg-12">
          <div class="card m-b-30">
              <div class="card-header">
                  <h5 class="box-title">All Announcement</h5>
              </div>
              <div class="card-body">
              
                  <div class="table-responsive">
                      <table id="datatable-buttons" class="table table-striped table-bordered">
                          <thead>
                          <tr>
                            <th>#</th>
                            <th>{{ __('adminstaticword.Announcement') }}</th>
                            <th>{{ __('adminstaticword.Course') }}</th>
                            <th>{{ __('adminstaticword.Status') }}</th>
                            <th>{{ __('adminstaticword.Action') }}</th>
                          
                          </tr>
                          </thead>
                          <tbody>
                          <?php $i=0;?>
                          @foreach($announs as $announ)
                          <tr>
                            <?php $i++;?>
                            <td><?php echo $i;?></td>
                              <td>{{$announ->announsment}}</td>
                              <td>{{$announ->courses->title}}</td>
                            <td>
                              <label class="switch">
                                <input class="user" type="checkbox"  data-id="{{$announ->id}}" name="status" {{ $announ->status == '1' ? 'checked' : '' }}>
                                <span class="knob"></span>
                              </label>
                               
                            </td>
                            <td>
                              <div class="dropdown">
                                  <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                                  <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                      <a class="dropdown-item" href="{{url('instructor/announcement/'.$announ->id)}}"><i class="feather icon-edit mr-2"></i>Edit</a>
                                      <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $announ->id }}" >
                                          <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                                      </a>
                                  </div>
                              </div>

                              <!-- delete Modal start -->
                              <div class="modal fade bd-example-modal-sm" id="delete{{$announ->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                  <div class="modal-dialog modal-sm">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <h5 class="modal-title" id="exampleSmallModalLabel">Delete</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>
                                          <div class="modal-body">
                                                  <h4>{{ __('Are You Sure ?')}}</h4>
                                                  <p>{{ __('Do you really want to delete')}} ? {{ __('This process cannot be undone.')}}</p>
                                          </div>
                                          <div class="modal-footer">
                                              <form method="post" action="{{url('instructor/announcement/'.$announ->id)}}" class="pull-right">
                                                  {{csrf_field()}}
                                                  {{method_field("DELETE")}}
                                                  <button type="reset" class="btn btn-secondary" data-dismiss="modal">No</button>
                                                  <button type="submit" class="btn btn-primary">Yes</button>
                                              </form>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <!-- delete Model ended -->

                          </td>
                           
                          </tr>
                          @endforeach
                   
                        </table>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection
