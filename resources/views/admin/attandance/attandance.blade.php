@extends('admin.layouts.master')
@section('title', 'Attandance - Admin')
@section('maincontent')
@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
   {{ __('Attandance') }}
@endslot
@slot('menu1')
{{ __('Attandance') }}
@endslot
@endcomponent
<div class="contentbar">
    <div class="row">
@if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach  
  </div>
  @endif
  
    <!-- row started -->
    <div class="col-lg-12">
    
        <div class="card m-b-30">
                <!-- Card header will display you the heading -->
                <div class="card-header">
                    <h5 class="card-box">{{ __('adminstaticword.User') }} ({{ $user->fname }} {{ $user->lname }} )-> {{ __('adminstaticword.Enrolledon') }} {{ date('d-m-Y', strtotime($enrolled['created_at'])) }}</h5>
                </div> 
               
                <!-- card body started -->
                <div class="card-body">
                <div class="table-responsive">
                        <!-- table to display Attandance start -->
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                        <th>#</th>
                        <th>{{ __('adminstaticword.Users') }}</th>
                        <th>{{ __('Attandance Date') }}</th>
                        </thead>
​
                        <tbody>
                        <?php $i=0;?>
                          @foreach($attandance as $attand)
                          <?php $i++;?>
                          <tr>
                            <td><?php echo $i;?></td>
                          
                            <td>
                              <p><b>{{ __('adminstaticword.User') }}:</b> {{ $user->fname }} {{ $user->lname }}</p>
                              
                            
                            </td>
                            <td>
                              <p><b>{{ __('adminstaticword.Attandance') }}: </b>{{ date('d-m-Y', strtotime($attand->date)) }} </p>
                            </td>
                            

                            @endforeach
                        
                          </tr>
                        </tbody>
                        </table>                  
                        <!-- table to display Attandance data end -->                
                    </div><!-- table-responsive div end -->
                </div><!-- card body end -->
            
        </div><!-- col end -->
    </div>
</div>
</div><!-- row end -->
    <br><br>
@endsection
<!-- main content section ended -->
<!-- This section will contain javacsript start -->
@section('script')

@endsection
<!-- This section will contain javacsript end -->