@extends('admin.layouts.master')
@section('title', 'Your Zoom Meetings')
@section('maincontent')
 

@component('components.breadcumb',['secondactive' => 'active'])
@slot('heading')
   {{ __('Your Zoom Meetings') }}
@endslot
@slot('menu1')
   {{ __('Zoom Meetings') }}
@endslot


@slot('button')
<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
      <a href="{{ route('meeting.create') }}" class="btn btn-primary-rgba"><i class="feather icon-plus mr-2"></i>{{ __("Add")}}</a>
      {{-- <a href="page-product-detail.html" class="btn btn-danger-rgba"  data-toggle="modal" data-target=".bd-example-modal-sm1"><i class="feather icon-trash mr-2"></i>Delete Select</a> --}}
                                
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
                    <h5 class="box-title"> {{ __('adminstaticword.AllMeetings') }} ({{ count($meetings) }})</h5>
                </div>
                <div class="card-body">
					<h6>{{ __('adminstaticword.ZoomProfile') }}</h6>
					<div class="row">
						
						
						  <div class="col-md-2">
							  <img src="{{ isset($profile['pic_url']) ? $profile['pic_url'] : Avatar::create($profile['first_name'])}}" alt="your_profile_picture" class="img-responsive img-circle">
						  </div>
		  
						  <div class="col-md-4">
							  <p><b>{{ __('adminstaticword.FirstName') }}:</b> {{ $profile['first_name'] }}</p>
							  <p><b>{{ __('adminstaticword.LastName') }}:</b> {{ $profile['last_name'] }}</p>
							  <p><b>{{ __('adminstaticword.Timezone') }}:</b> {{ $profile['timezone'] }}</p> 
						  </div>
		  
						  <div class="col-md-4">
							  <p><b>{{ __('adminstaticword.Status') }}:</b> {{ $profile['status'] }}</p>
							  <p><b>Zoom ID:</b> {{ $profile['id'] }}</p>
							  <p><b>{{ __('adminstaticword.Language') }}:</b> {{ $profile['language'] }}</p> 
						  </div>
		  
						</div>
					</div>
					
				   
                 
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
								<th>
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
	  
						@foreach($meetings as $key => $meeting)
	  
							@php
								$i++;
							@endphp
	  
						  <tr>
							  <td>
								  {{ $i }}
							  </td>
	  
							  <td>
								  <p><b>{{ __('adminstaticword.MeetingID') }}:</b> {{ $meeting['id'] }}</p>
								  <p><b>{{ __('adminstaticword.MeetingTopic') }}:</b> {{ $meeting['topic'] }}</p>
								  <p><b>{{ __('adminstaticword.Agenda') }}:</b> {{ isset($meeting['agenda']) ? str_limit($meeting['agenda'], $limit = 10, $end = '...') : "" }}</p>
								  <p><b>{{ __('adminstaticword.Duration') }}:</b> {{ isset($meeting['duration']) ? $meeting['duration'] : "" }} min</p>
								  <p><b>{{ __('adminstaticword.StartTime') }}:</b>{{ isset($meeting['start_time']) ? date('d-m-Y | h:i:s A',strtotime($meeting['start_time'])) : "" }} </p>
								  <p><b>Meeting Type:</b> @if($meeting['type'] == '2') Scheduled Meeting @elseif($meeting['type'] == '3') Recurring Meeting with no fixed time @else Recurring Meeting with fixed time @endif</p>
	  
								  
	  
								  
							  </td>
	  
							  <td>
								  <a title="Join Meeting" target="_blank" href="{{ $meeting['join_url'] }}">
									  {{ $meeting['join_url'] }}
								  </a>
							  </td>
	  
							  <td>
	  
								  @php
									  $curl = curl_init();
									  $token = Auth::user()->jwt_token;
									  $meetingID = $meeting['id'];
										  curl_setopt_array($curl, array(
											CURLOPT_URL => "https://api.zoom.us/v2/meetings/$meetingID",
											CURLOPT_RETURNTRANSFER => true,
											CURLOPT_ENCODING => "",
											CURLOPT_MAXREDIRS => 10,
											CURLOPT_TIMEOUT => 30,
											CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
											CURLOPT_CUSTOMREQUEST => "GET",
											CURLOPT_HTTPHEADER => array(
											  "authorization: Bearer $token"
											),
										  ));
	  
										  $url = curl_exec($curl);
										  $err = curl_error($curl);
										  $url = json_decode($url,true);
										  curl_close($curl);
									  @endphp
	  
	
									<div class="dropdown">
										<button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
										<div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
											<a class="dropdown-item"  title="Edit Meeting" href="{{ route('zoom.edit',$meeting['id']) }}"><i class="feather icon-edit mr-2"></i>{{ __("Edit")}}</a>
											<a class="dropdown-item" title="View Meeting" href="{{ route('zoom.show',$meeting['id']) }}"><i class="feather icon-eye mr-2"></i>{{ __("View")}}</a>
											<a class="dropdown-item"  title="Start Meeting" href="{{ isset($url['start_url']) ? $url['start_url'] : "" }}"><i class="feather icon-send mr-2"></i>{{ __("Share")}}</a>
											<a class="dropdown-item" title="Delete Meeting" data-toggle="modal" data-target=".bd-example-modal-sm"><i class="feather icon-delete mr-2"></i>{{ __("Delete")}}</a>
										
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
											<form method="post" action="{{ route('zoom.delete',$meeting['id']) }}" class="pull-right">
												{{csrf_field()}}
												{{method_field("DELETE")}}
											<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close")}}</button>
											<button type="submit" class="btn btn-primary">{{ __("Delete")}}</button>
										</form>
										</div>
									</div>
								</div>
							</div>
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
@section('scripts')

  <script>
  $(function() {
    $('.custom_toggle').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0; 
        
        var id = $(this).data('id'); 
        
        
        $.ajax({
            type: "GET",
            dataType: "json",
            url: 'quickupdate/slider',
            data: {'status': status, 'id': id},
            success: function(data){
              console.log(id)
            }
        });
    })
  })
</script>
@endsection
                                      
                                    
                                     
                                      
                                    
                                   
                              
                               
                                
    
              
                               
                              
                
                               
                              
