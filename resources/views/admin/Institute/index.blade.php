@extends('admin.layouts.master')
@section('title', 'Institute - Admin')
@section('maincontent')
@component('components.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
{{ __('Institute') }}
@endslot
@slot('menu1')
{{ __('Institute') }}
@endslot
@slot('button')
<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
    @can('institute.create')
    <a href="{{ route('institute.create') }}" class="btn btn-primary-rgba"><i class="feather icon-plus mr-2"></i>{{ __("Add Institute")}}</a>
    @endcan
      {{ csrf_field() }}
    <a href="{{ route('institute.import') }}" class="btn btn-success-rgba"><i class="feather icon-plus mr-2"></i>{{ __("Import")}}</a>
  </div>
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
                  <h5 class="card-title">{{ __('Institute')}}</h5>
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
                        <th>{{ __('Skills') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Verify') }}</th>
                        <th>{{ __('Action') }}</th>
                      </tr>
                        </thead>
                        <tbody>
                          @foreach($institute as $key => $item)
                          <tr>
                              <td>{{ filter_var($key+1) }}</td>
                              <td><img src="{{ asset('files/institute/'.filter_var($item->image)) }}" class="img-responsive img-circle" ></td>
                              <td>{{$item->title}}</td>
                              <td>{{$item->detail}}</td> 
                              <td>{{$item->skill}}</td>
                              <td>
                                <label class="switch">
                                  <input class="status" type="checkbox"  name="status"  data-id="{{$item->id}}"  {{ $item->status == '1' ? 'checked' : '' }}> 
                                  <span class="knob"></span>
                                </label>
                              </td>
                              <td>
                                <label class="switch">
                                  <input class="verify" type="checkbox"  name="verify" data-id="{{$item->id}}"  {{ $item->verified == '1' ? 'checked' : '' }}> 
                                  <span class="knob"></span>
                                </label>
                              </td>
                              <td>
                                <div class="dropdown">
                                  <button  class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                                  <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
                                      <a class="dropdown-item"   href="{{route('institute.edit',['id' => $item->id])}}" ><i class="feather icon-edit mr-2"></i>{{ __("Edit")}}</a>
                                      <a class="dropdown-item" data-toggle="modal" data-target=".bd-example-modal-sm"><i class="feather icon-delete mr-2"></i>{{ __("Delete")}}</a>
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
                                            <form  method="post" action="{{ route('institute.delete',['id' => $item->id])}}
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
                              </tr>   
                            @endforeach
                          </tbody>
                  </table>
                  @endif

                 @if(Auth::User()->role == "instructor")
                  <table id="datatable-buttons" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>{{ __('Id') }}</th>
                        <th>{{ __('Image') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Detail') }}</th>
                        <th>{{ __('Skills') }}</th>
                        <th>{{ __('Action') }}</th>
                      </tr>
                        </thead>
                        <tbody>
                          @php
                            $insti = App\Institute::where('user_id',Auth::User()->id)
                                                      ->where('status',1)
                                                      ->get();
                                                          
                            @endphp
                          @foreach($insti as $key => $value)
                          <tr>
                              <td>{{ filter_var($key+1) }}</td>
                              <td><img src="{{ asset('files/institute/'.filter_var($value->image)) }}" class="img-responsive img-circle" ></td>
                              <td>{{$value->title}}</td>
                              <td>{{$value->detail}}</td> 
                              <td>{{$value->skill}}</td>
                              <td>
                                <div class="dropdown">
                                  <button  class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                                  <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
                                    @can('institute.edit')
                                      <a class="dropdown-item"   href="{{route('institute.edit',['id' => $value->id])}}" ><i class="feather icon-edit mr-2"></i>{{ __("Edit")}}</a>
                                      @endcan
                                      @can('institute.delete')
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
                                            <form  method="post" action="{{ route('institute.delete',['id' => $value->id])}}
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
@section('script')
<script>
$(document).on("change",".status",function() {
  $.ajax({
      type: "GET",
      dataType: "json",
      url:'institute/status',
      data:  {'status': $(this).is(':checked') ? 1 : 0, 'id': $(this).data('id')},
      success: function(data){
        console.log(id)
      }
  });
});
</script>
<script>
$(document).on("change",".verify",function() {
$.ajax({
      type: "GET",
      dataType: "json",
      url:'institute/verify',
      data:  {'verify': $(this).is(':checked') ? 1 : 0, 'id': $(this).data('id')},
      success: function(data){
            var warning = new PNotify( {
                title: 'success', text:'Status Update Successfully', type: 'success', desktop: {
                desktop: true, icon: 'feather icon-thumbs-down'
                }
              });
              warning.get().click(function() {
                warning.remove();
              });
          }
  });
});
</script>
@endsection
