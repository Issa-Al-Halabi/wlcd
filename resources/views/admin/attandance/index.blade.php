<div class="row">
        <div class="col-md-12">
            <!-- card started -->
            <div class="card">
              <!-- ========= -->
                <!-- to show add button start -->
                <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-7">
                    <!-- <div class="card-header">
                        <h5 class="card-title">{{ __('adminstaticword.Language') }}</h5>
                    </div>  -->
                    </div> 
                    <div class="col-md-5">
                    <div class="widgetbar">
                   
                    </div>
                    </div>
                </div>
                </div>
                <!-- to show add button end -->
                <!-- card body started -->
                <div class="card-body">
                <div class="table-responsive">

                        <!-- table to display language start -->
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                           
                            <th>{{ __('adminstaticword.Course') }}</th>
                            <th>{{ __('adminstaticword.UsersEnrolled') }}</th>
                            
                        </thead>
                       
                        <tbody>
                        <?php $i=0;?>
                        @foreach($courses as $course)
                        <?php $i++;?>
                            <tr>
                            <td><?php echo $i;?></td>
                            
                            <td>
                            <p><b>{{ __('adminstaticword.course') }}:</b> {{ $course['title'] }}</p>
                          </td>
                          <td>
                          <a href="{{ route('enrolled.users',$course->id) }}" class="btn btn-primary">{{ __('adminstaticword.UsersEnrolled') }}</a>
                          </td>
                                
                            </tr> 
                            @endforeach
                        </tbody>
                       
                        </table>                  
                        <!-- table to display language data end -->                
                    </div><!-- table-responsive div end -->
                </div><!-- card body end -->
            </div><!-- card end -->
        </div><!-- col end -->
    </div><!-- row end -->