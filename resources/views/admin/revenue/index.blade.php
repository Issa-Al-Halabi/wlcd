@extends('admin.layouts.master')
@section('title', 'Pending Payout - Admin')
@section('maincontent')


@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
   {{ __('Pending Payout' ) }}
@endslot
@slot('menu1')
{{ __('Instructor') }}
@endslot
@slot('menu2')
{{ __('Instructor Payout') }}
@endslot
@slot('menu3')
{{ __('Pending Payout ') }}
@endslot

@endcomponent


  <div class="contentbar">                
    <!-- Start row -->
    <div class="row">
    
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="box-title">{{ __('Pending Payout ')}}</h5>
                </div>
                <div class="card-body">
                 
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                              <th>#</th>
                              <th>{{ __('adminstaticword.Instructor') }}</th>
                              <th>{{ __('adminstaticword.View') }}</th>
                           
                            </tr>
                            </thead>
                            <tbody>
                              <?php $i=0;?>
                              @foreach($users as $user)
                              <tr>
                                <?php $i++;?>
                                  <td><?php echo $i;?></td>
                                  <td>{{$user->fname}}</td>
                               <td>
                                <div class="dropdown">
                                    <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                                    <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
                                        <a class="dropdown-item"  href="{{ route('admin.pending', $user->id) }}"><i class="feather icon-eye mr-2"></i>{{ __('Pending Payout') }}</a>
                                        <a class="dropdown-item"  href="{{ route('admin.paid', $user->id) }}"><i class="feather icon-eye mr-2"></i>{{ __('Complete Payout') }}</a>
                                      
                                      
                                    </div>
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
                       
                                    
                                     
                                      
                                    
                                   
                              
                               
                                
    
              
                               
                              
                
                               
                              
