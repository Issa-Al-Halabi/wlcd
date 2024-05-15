@extends('admin.layouts.master')
@section('title', 'Your Google Meetings - Admin')
@section('maincontent')
 

@component('components.breadcumb',['thirdactive' => 'active'])
@slot('heading')
   {{ __('Your Google Meetings ') }}
@endslot
@slot('menu1')
   {{ __('Meetings') }}
@endslot
@slot('menu2')
   {{ __('Your Google Meetings ') }}
@endslot

@slot('button')
<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
      <a   title="Create a new meeting" href="{{ route('googlemeet.meeting.create') }}"  class="btn btn-primary-rgba"><i class="feather icon-plus mr-2"></i>{{ __("Add")}}</a>
      
      <a href="page-product-detail.html" class="btn btn-danger-rgba"  data-toggle="modal" data-target=".bd-example-modal-sm1"><i class="feather icon-trash mr-2"></i>Delete Multiple</a>
                                
      <div class="modal fade bd-example-modal-sm1" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-sm">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleSmallModalLabel">Delete</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body text-center">
                      <p class="text-muted">{{ __("Do you really want to delete these records? This process cannot be undone.")}}</p>
                  </div>
                  <div class="modal-footer">
                    <form method="post" action="{{ action('BulkdeleteController@googlemeetingdeleteAll') }}
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
                    <h5 class="box-title">{{ __('Your Google Meetings ')}}</h5>
                </div>
                <div class="card-body">
                 
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
								<th>
									
                                    <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]" value="all" id="checkboxAll">
                                    <label for="checkboxAll" class="material-checkbox"></label> 
                                     #
									</th>
									<th>
										{{ __('adminstaticword.MeetingID') }}
									</th>
									<th>
										{{ __('adminstaticword.Meeting') }} {{ __('adminstaticword.URL') }}
									</th>
									<th>
										{{ __('adminstaticword.Action') }}
									</th>
                           
                            </tr>
                            </thead>
                            <tbody>
								@php
								$i = 0;
							@endphp
		  
							@foreach($allgooglemeet as $key => $meeting)
		  
								@php
									$i++;
								@endphp
							  <tr>
								  <td>
                                    <input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="{{ $meeting->id}}" id="checkbox{{ $meeting->id}}">
                                    <label for="checkbox{{ $meeting->id}}" class="material-checkbox"></label> {{ $i }}
								  </td>
		  
								  <td>
									  <p><b>{{ __('adminstaticword.MeetingID') }}:</b>{{ $meeting['meeting_id'] }} </p>
									  <p><b>{{ __('adminstaticword.MeetingTopic') }}:</b>{{ $meeting['meeting_title'] }} </p>
									  <p><b>{{ __('adminstaticword.Agenda') }}:</b>{{ $meeting['agenda'] }}</p>
									  <p><b>{{ __('adminstaticword.StartTime') }}:</b>{{ $meeting['start_time'] }}</p>
									  <p><b>{{ __('adminstaticword.EndTime') }}:</b>{{ $meeting['end_time'] }}</p>
									  <p><b>{{ __('adminstaticword.Duration') }}:</b>{{ $meeting['duration'] }}</p>	
								  </td>
		  
								  <td>
									  <a title="Join Meeting" target="_blank" href="{{ $meeting['meet_url'] }}">
										  {{ $meeting['meet_url'] }}
									  </a>
									  </a>
								  </td>
                               <td>
                                <div class="dropdown">
                                    <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                                    <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
                                        <a class="dropdown-item"  title="Edit Meeting" href="{{ route('googlemeet.edit',$meeting['meeting_id']) }}"><i class="feather icon-edit mr-2"></i>{{ __("Edit")}}</a>
                                        <a class="dropdown-item"  title="Start Meeting" href="{{ $meeting['meet_url'] }}"><i class="feather icon-send mr-2"></i>{{ __("Start Meetings")}}</a>
                                        <a class="dropdown-item" data-toggle="modal" data-target=".bd-example-modal-sm"><i class="feather icon-trash mr-2"></i>{{ __("Delete")}}</a>
                                      
                                    </div>
                                </div>
                              </td>

                              <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                                  <div class="modal-dialog modal-sm">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <h5 class="modal-title" id="exampleSmallModalLabel">Delete</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>
                                          <div class="modal-body">
                                              <p class="text-muted">{{ __("Do you really want to delete these records? This process cannot be undone.")}}</p>
                                          </div>
                                          <div class="modal-footer">
											<form method="post" action="{{ route('googlemeet.delete',$meeting['meeting_id']) }}" class="pull-right">
												{{csrf_field()}}
												{{method_field("DELETE")}}
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("No")}}</button>
                                              <button type="submit" class="btn btn-danger">{{ __("Yes")}}</button>
                                          </form>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                             
                                    
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
            
                                    
                                     
                                      
                                    
                                   
                              
                               
                                
    
              
                               
                              
                
                               
                              
