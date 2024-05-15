<div class="card btm-10">
    <div class="card-header" id="headingChapter{{ $coursechapter->id }}">
        <div class="mb-0">
            <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapseChapter{{ $coursechapter->id }}" aria-expanded="true" aria-controls="collapseChapter">
                <div class="course-check-table">
                <table class="table">  
                    <tbody>
                        <tr>
                        <td width="10px">
                            <div class="form-check">
                                <input class="form-check-input filled-in material-checkbox-input" type="checkbox" name="checked[]" value="{{$coursechapter->id}}" id="checkbox{{$coursechapter->id}}"  {{ isset($progress->mark_chapter_id) && in_array($coursechapter->id, $progress->mark_chapter_id) ? "checked" : "" }} >
                                <label class="form-check-label" for="invalidCheck">
                                </label>
                            </div>
                        </td>
                        
                        <td>
                            <div class="row">
                                <div class="col-lg-6 col-6">
                                    <div class="section">{{ __('Section') }}: <?php echo $i;?></div>
                                </div>
                                <div class="col-lg-6 col-6">
                                    <div class="section-dividation text-right">
                                        @php
                                            $classone = App\CourseClass::where('coursechapter_id', $coursechapter->id)->count();
                                            if($classone>0){

                                                echo $classone;
                                            }
                                            else{

                                                echo "0";
                                            }
                                        @endphp
                                        {{ __('Classes') }}
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-10 col-8">
                                    <div class="profile-heading">{{ $coursechapter->chapter_name }}
                                    </div>
                                </div>
                                <div class="col-lg-2 col-4">
                                    <div class="text-right">
                                        @php
                                        $classtwo =  App\CourseClass::where('coursechapter_id', $coursechapter->id)->sum("duration");
                                        echo $duration_round2 = round($classtwo,2);
                                        @endphp
                                        
                                        {{ __('min') }}

                                        @if($coursechapter->file != NULL)
                                        <a href="{{ asset('files/material/'.$coursechapter->file) }}" download="{{$coursechapter->file}}" title="Learning Material"><i class="fa fa-download"></i></a>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </button>
        </div>
    </div>
    <div id="collapseChapter{{ $coursechapter->id }}" class="collapse" aria-labelledby="headingChapter" data-parent="#accordion">

        @php

            $mytime = Carbon\Carbon::now();
        @endphp
        @foreach($coursechapter->courseclass->sortBy('position') as $class)


            @if(Auth::user()->role == "user" && $course->drip_enable == 1 && $class->drip_type != NULL)

                @if($class->drip_type == 'date' && $class->drip_date != NULL)

                    @if($today >= $class->drip_date)

                        @include('include.course_class')

                    @endif

                @elseif($class->drip_type == 'days' && $class->drip_days != NULL)

                    @php
                        $order = App\Order::where('status', '1')->where('user_id', Auth::User()->id)->where('course_id', $course->id)->first();
                        $days = $class->drip_days;
                        
                        $orderDate = optional($order)['created_at'];


                        $bundle = App\Order::where('user_id', Auth::User()->id)->where('bundle_id', '!=', NULL)->get();

                        $course_id = array();

                        foreach($bundle as $b)
                        {
                           $bundle = App\BundleCourse::where('id', $b->bundle_id)->first();
                            array_push($course_id, $bundle->course_id);
                        }

                        $course_id = array_values(array_filter($course_id));
                        $course_id = array_flatten($course_id);

                        if($orderDate != NULL){
                            $startDate = date("Y-m-d", strtotime("$orderDate +$days days"));
                        }
                        elseif(isset($course_id) && in_array($course->id, $course_id)){
                            $startDate = date("Y-m-d", strtotime("$bundle->created_at +$days days"));
                        }
                    @endphp

                    @if($today >= $startDate)

                        @include('include.course_class')

                    @endif

                @endif
            @else

                @include('include.course_class')

            @endif


        
        @endforeach
    </div>
</div>