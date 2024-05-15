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
                        <table class="table table-striped table-bordered">
                        <thead>
                           
                        <th>#</th>
                        <th>{{ __('adminstaticword.User') }}</th>
                        <th>{{ __('Class') }}</th>
                        <th>{{ __('adminstaticword.UsersEnrolled') }}</th>
                            
                        </thead>
                       
                        <tbody>
                        <?php $i=0;?>
                          @foreach($live_attandance as $course)
                            <?php $i++;?>
                            <tr>
                            <td><?php echo $i;?></td>

                              <td>
                                <p><b></b> {{ $course->user['fname'] }}</p>
                              
                              </td>

                              <td>
                                @if($course->zoom_id != NULL)
                                <p><b></b> {{ optional($course->zoom)['meeting_title'] }}</p>
                                @endif
                                @if($course->bbl_id != NULL)
                                <p><b></b> {{ optional($course->bbl)['meetingname'] }}</p>
                                @endif
                                @if($course->jitsi_id != NULL)
                                <p><b></b> {{ optional($course->jitsi)['meeting_title'] }}</p>
                                @endif
                                @if($course->google_id != NULL)
                                <p><b></b> {{ optional($course->google)['meeting_title'] }}</p>
                                @endif
                              
                              </td>
                              <td>
                                <p><b>{{ __('adminstaticword.Attandance') }}: </b>{{ date('d-m-Y', strtotime($course->date)) }} </p>
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