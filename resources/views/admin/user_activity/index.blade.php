@extends('admin.layouts.master')
@section('title','All Users Activity Logs')
@section('maincontent')
@component('components.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('Users Activity Logs') }}
@endslot

@slot('menu1')
   {{ __('Users Activity Logs') }}
@endslot


@endcomponent
<div class="contentbar"> 
  <div class="row">
      
      <div class="col-lg-12">
          <div class="card m-b-30">
              <div class="card-header">
                  <h5 class="box-title">{{ __('All Users Activity Logs') }}</h5>
              </div>
              <div class="card-body">
              
                  <div class="table-responsive">
                      <table id="datatable-buttons" class="table table-striped table-bordered">
                          <thead>
                          <tr>
                              <th>
                                <th>#</th>
                                <th>{{ __('adminstaticword.User') }}</th>
                                <th>{{ __('adminstaticword.Email') }}</th>
                                <th>{{ __('adminstaticword.Description') }}</th>
                                <th>{{ __('adminstaticword.Time') }}</th>
                                <th>{{ __('adminstaticword.Delete') }}</th>
                              </thead> 
              
                              <tbody>
                                <?php $i=0;?>
              
                                  @foreach ($lastActivity as $user)
              
                                    @php
                                      $users = App\User::where('id', $user->causer_id)->first();
                                    @endphp
                                   
                                    <?php $i++;?>
              
                                    <tr>
                                      <td></td>
                                      <td><?php echo $i;?></td>
                                     
                                      <td>@if(isset($users)) {{ $users->fname }} @endif</td>
                                      <td>@if(isset($users)) {{ $users->email }} @endif</td>
                                      <td>{{ $user->description }}</td>
                                      <td>{{ $user->created_at->diffForHumans() }}</td>
                                      <td>
                                        <div class="dropdown">
                                            <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                                            <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                                <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $user->id }}" >
                                                    <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                                                </a>
                                            </div>
                                        </div>
    
                                        <!-- delete Modal start -->
                                        <div class="modal fade bd-example-modal-sm" id="delete{{$user->id}}" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                            <p>{{ __('Do you really want to delete')}} <b>{{$user->fname}}</b>? {{ __('This process cannot be undone.')}}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form method="post" action="{{ route('activity.delete',$user->id) }}" class="pull-right">
                                                            {{csrf_field()}}
                                                            {{method_field("DELETE")}}
                                                            <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{ __('No') }}</button>
                                                            <button type="submit" class="btn btn-primary">{{ __('Yes') }}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- delete Model ended -->
    
                                    </td>
                                    
                                      
                                    </tr>
                              
                                  @endforeach
              
                              </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
      
@endsection

