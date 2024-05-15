<div class="leftbar sidebar-two" style="background-image: url('images/navbar.png')">
    <!-- Start Sidebar -->
    <div class="sidebar">
        <!-- Start Navigationbar -->

        <div class="navigationbar">
            
            <div class="vertical-menu-detail">

                <div class="tab-content" id="v-pills-tabContent">

                    <div class="tab-pane fade active show" id="v-pills-dashboard" role="tabpanel"
                        aria-labelledby="v-pills-dashboard">
                        <ul class="vertical-menu">
                            <div class="logobar">
                                <a href="{{ url('/') }}" class="logo logo-large">
                                    <img style="object-fit:scale-down;" src="{{ url('images/logo/'.$gsetting->footer_logo) }}"
                                        class="img-fluid" alt="logo">
                                </a>
                            </div>
                        

                            <li class="{{ Nav::isRoute('admin.index') }}">
                                <a class="nav-link" href="{{route('admin.index')}}">
                                    <i class="feather icon-pie-chart text-secondary"></i>
                                    <span>{{ __('adminstaticword.Dashboard') }}</span>
                                </a>
                            </li>
                            
                            @can(['marketing-dashboard.manage'])
                            <li class="{{ Nav::isRoute('market.index') }}">
                                <a class="nav-link" href="{{route('market.index')}}">
                                    <i class="feather icon-pie-chart text-secondary"></i>
                                    <span>{{ __('Marketing Dashboard') }}</span>
                                </a>
                            </li>
                            @endcan
                            <!-- dashboard end -->
                            @canany(['users.view','Alluser.view','Allinstructor.view'])
                            <li class="header">{{ __('Users') }}</li>
                            <!-- user start  -->
                            <li class="{{ Nav::isRoute('user.index') }} {{ Nav::isRoute('user.add') }} {{ Nav::isRoute('user.edit') }}{{ Nav::isRoute('alluser.index') }} {{ Nav::isRoute('alluser.add') }} {{ Nav::isRoute('alluser.edit') }}{{ Nav::isRoute('allinstructor.index') }} {{ Nav::isRoute('allinstructor.add') }} {{ Nav::isRoute('allinstructor.edit') }}{{ Nav::isResource('roles') }}">
                                <a href="javaScript:void();" class="menu"><i class="feather icon-users text-secondary"></i>
                                    <span>{{ __('Users') }}<div class="sub-menu truncate">All Users, All Students, All Instructors, Roles And Permission</div></span>
                                    <i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    @can('users.view')
                                    <li>
                                        <a class="{{ Nav::isResource('user') }}"
                                            href="{{route('user.index')}}">{{ __('All Users') }}</a>
                                    </li>
                                    @endcan
                                    @can('Alluser.view')
                                    <li>
                                        <a class="{{ Nav::isResource('allusers') }}"
                                            href="{{route('allusers.index')}}">{{ __('All Students') }}</a>
                                    </li>
                                    @endcan
                                    @can('Allinstructor.view')
                                    <li>
                                        <a class="{{ Nav::isResource('allinstructor') }}"
                                            href="{{route('allinstructor.index')}}">{{ __('All Instructors') }}</a>
                                    </li>
                                    @endcan
                                    <li>
                                        <a class="{{ Nav::isResource('roles') }}"
                                            href="{{route('roles.index')}}">{{ __('Roles And Permission') }}</a>
                                    </li>

                                </ul>
                            </li>
                            @endcanany


                            @canany(['instructorrequest.view','instructor-pending-request.manage','instructor-plan-subscription.view'])
                            <li class="{{ Nav::isResource('plan/subscribe/settings') }} {{ Nav::isResource('subscription/plan') }}  {{ Nav::isRoute('all.instructor') }} {{ Nav::isResource('requestinstructor') }}">
                                <a href="javaScript:void();" class="menu"><i class="feather icon-user text-secondary"></i>
                                    <span>{{ __('adminstaticword.Instructors') }}<div class="sub-menu truncate">All Instructor Request, Pending Request, Instructor Subscription, Instructor Plan, Multiple Instructor, Instructor Payout</div></span>
                                    <i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    @can('instructorrequest.view')
                                    <li class="{{ Nav::isRoute('all.instructor') }}"><a
                                            href="{{route('all.instructor')}}">{{ __('adminstaticword.All') }}
                                            {{ __('adminstaticword.InstructorRequest') }}</a></li>
                                            @endcan
                                    @can('instructor-pending-request.manage')
                                    <li class="{{ Nav::isResource('requestinstructor') }}"><a
                                            href="{{url('requestinstructor')}}">{{ __('adminstaticword.Pending') }}
                                            {{ __('Request') }}</a></li>
                                            @endcan
                                            @can('instructor-plan-subscription.view')
                                    <li class="{{ Nav::isResource('plan/subscribe/settings') }}"><a
                                            href="{{url('plan/subscribe/settings')}}">{{ __('adminstaticword.Instructor') }}
                                            {{ __('adminstaticword.Subscription') }}</a></li>
                                            @endcan
                                    @if(env('ENABLE_INSTRUCTOR_SUBS_SYSTEM') == 1)
                                    <li class="{{ Nav::isResource('subscription/plan') }}"><a
                                            href="{{url('subscription/plan')}}">{{ __('adminstaticword.InstructorPlan') }}</a>
                                    </li>
                                    @endif
                                    <!-- MultipleInstructor start  -->
                                    <li
                                        class="{{ Nav::isRoute('allrequestinvolve') }} {{ Nav::isRoute('involve.request.index') }} {{ Nav::isRoute('involve.request') }}">
                                        <a href="javaScript:void();">
                                            <span>{{ __('adminstaticword.MultipleInstructor') }}</span>
                                        </a>
                                        <ul class="vertical-submenu">

                                            <li class="{{ Nav::isRoute('allrequestinvolve') }}"><a
                                                    href="{{route('allrequestinvolve')}}">{{ __('adminstaticword.RequestToInvolve') }}</a>
                                            </li>
                                            <li class="{{ Nav::isRoute('involve.request.index') }}"><a
                                                    href="{{route('involve.request.index')}}">{{ __('adminstaticword.InvolvementRequests') }}</a>
                                            </li>
                                            <li class="{{ Nav::isRoute('involve.request') }}"><a
                                                    href="{{route('involve.request')}}">{{ __('adminstaticword.InvolvedInCourse') }}</a>
                                            </li>

                                        </ul>
                                    </li>
                                    <!-- MultipleInstructor end  -->
                                    <!-- InstructorPayout start  -->
                                    <li
                                        class="{{ Nav::isRoute('instructor.settings') }} {{ Nav::isRoute('admin.instructor') }} {{ Nav::isRoute('admin.completed') }}">
                                        <a href="javaScript:void();">
                                            <span>{{ __('adminstaticword.InstructorPayout') }}</span>
                                        </a>
                                        <ul class="vertical-submenu">

                                            <li class="{{ Nav::isRoute('instructor.settings') }}"><a
                                                    href="{{route('instructor.settings')}}">{{ __('adminstaticword.PayoutSettings') }}</a>
                                            </li>
                                            <li class="{{ Nav::isRoute('admin.instructor') }}"><a
                                                    href="{{route('admin.instructor')}}">{{ __('adminstaticword.PendingPayout') }}</a>
                                            </li>
                                            <li class="{{ Nav::isRoute('admin.completed') }}"><a
                                                    href="{{route('admin.completed')}}">{{ __('adminstaticword.CompletedPayout') }}</a>
                                            </li>


                                        </ul>
                                    </li>
                                    <!-- InstructorPayout end  -->
                                </ul>
                            </li>
                            @endcanany


                            <!-- user end -->
                            @canany(['categories.view','courses.view','bundle-courses.view','course-languages.view','course-reviews.view','assignment.view','refund-policy.view','quiz-review.view','private-course.view','reported-course.view','reported-question.view'])

                            <li class="header">{{ __('Education') }}</li>
                            <!-- ====================Course start======================== -->
                            <li class="{{ Nav::isResource('category') }} {{ Nav::isResource('subcategory') }} {{ Nav::isResource('childcategory') }} {{ Nav::isResource('course') }} {{ Nav::isResource('bundle') }} {{ Nav::isResource('courselang') }} {{ Nav::isResource('coursereview') }} {{ Nav::isRoute('assignment.view') }} {{ Nav::isResource('refundpolicy') }} {{ Nav::isResource('batch') }} {{ Nav::isRoute('quiz.review') }} {{ Nav::isResource('private-course') }} {{ Nav::isResource('admin/report/view') }} {{ Nav::isResource('user/question/report') }}">
                                <a href="javaScript:void();" class="menu"><i class="feather icon-book text-secondary"></i>
                                    <span>{{ __('adminstaticword.Course') }}<div class="sub-menu truncate">Categories, Courses, Bundle Course, Course Language, Course Review, Assignment, Refund Policy, Quiz Review, Reported Course, Reported Question</div></span>
                                    <i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    <!-- Category start  -->
                                    @canany(['categories.view','subcategories.view','childcategories.views'])
                                    <li
                                        class="{{ Nav::isResource('category') }} {{ Nav::isResource('subcategory') }} {{ Nav::isResource('childcategory') }}">
                                        <a href="javaScript:void();"><span>{{ __('adminstaticword.Category') }}</span><i
                                                class="feather icon-chevron-right"></i>
                                        </a>
                                        <ul class="vertical-submenu">
                                            @can(['categories.view'])
                                            <li class="{{ Nav::isResource('category') }}"><a
                                                    href="{{url('category')}}">{{ __('adminstaticword.Category') }}</a>
                                            </li>
                                            @endcan
                                            @can(['subcategories.view'])
                                            <li class="{{ Nav::isResource('subcategory') }}"><a
                                                    href="{{url('subcategory')}}">{{ __('adminstaticword.SubCategory') }}</a>
                                            </li>
                                            @endcan
                                            @can(['childcategories.view'])
                                            <li class="{{ Nav::isResource('childcategory') }}"><a
                                                    href="{{url('childcategory')}}">{{ __('adminstaticword.ChildCategory') }}</a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </li>
                                    @endcanany


                                    <!-- Category end  -->
                                    @can(['courses.view'])
                                    <li class="{{ Nav::isResource('course') }}"><a
                                            href="{{url('course')}}"><span>{{ __('adminstaticword.Courses') }}</span></a>
                                    </li>
                                    @endcan
                                    @can(['bundle-courses.view'])
                                    <li class="{{ Nav::isResource('bundle') }}"><a
                                            href="{{url('bundle')}}"><span>{{ __('adminstaticword.BundleCourse') }}</span></a>
                                    </li>
                                    @endcan
                                    @can(['course-languages.view'])
                                    <li class="{{ Nav::isResource('courselang') }}"><a
                                            href="{{url('courselang')}}"><span>{{ __('adminstaticword.CourseLanguage') }}</span></a>
                                    </li>
                                    @endcan
                                    @can(['course-reviews.view'])
                                    <li class="{{ Nav::isResource('coursereview') }}"><a
                                            href="{{url('coursereview')}}"><span>{{ __('adminstaticword.CourseReview') }}</span></a>
                                    </li>
                                    @endcan
                                    @can(['assignment.view'])
                                    @if($gsetting->assignment_enable == 1)
                                    <li class="{{ Nav::isRoute('assignment.view') }}"><a
                                            href="{{route('assignment.view')}}"><span>{{ __('adminstaticword.Assignment') }}</span></a>
                                    </li>
                                    @endif
                                    @endcan
                                    @can(['refund-policy.view'])
                                    <li class="{{ Nav::isResource('refundpolicy') }}"><a
                                            href="{{url('refundpolicy')}}"><span>{{ __('adminstaticword.RefundPolicy') }}</span></a>
                                    </li>
                                    @endcan
                                    {{-- @can(['batch.view'])
                                    <li class="{{ Nav::isResource('batch') }}"><a
                                            href="{{url('batch')}}"><span>{{ __('adminstaticword.Batch') }}</span></a>
                                    </li>
                                    @endcan --}}
                                    @can(['quiz-review.view'])
                                    <li class="{{ Nav::isRoute('quiz.review') }}"><a
                                            href="{{route('quiz.review')}}"><span>{{ __('adminstaticword.QuizReview') }}</span></a>
                                    </li>
                                    @endcan
                                    {{-- @can(['private-course.view'])
                                    <li class="{{ Nav::isResource('private-course') }}"><a
                                            href="{{url('private-course')}}"><span>{{ __('adminstaticword.PrivateCourse') }}</span></a>
                                    </li>
                                    @endcan --}}
                                    @can(['reported-course.view'])
                                    <li class="{{ Nav::isResource('admin/report/view') }}">
                                        <a href="{{url('admin/report/view')}}">{{ __('adminstaticword.Reported') }}
                                            {{ __('Course') }}
                                        </a>
                                    </li>
                                    @endcan
                                    
                                    @can(['reported-question.view'])
                                    <li class="{{ Nav::isResource('user/question/report') }}">
                                        <a href="{{url('user/question/report')}}">{{ __('adminstaticword.Reported') }}
                                            {{ __('Question') }}</a>
                                    </li>
                                    @endcan
                                </ul>
                            </li>
                            @endcanany
                            <!--=================== Course end====================================  -->
                            <!-- ====================Meetings start======================== -->
                            @canany(['meetings.zoom-meetings.view','meetings.big-blue.view','meetings.google-meet.view','meetings.jitsi-meet.view','meetings.google-classroom.view','meetings.meeting-recordings.view'])
                            <li class="{{ Nav::isRoute('meeting.create') }} {{ Nav::isRoute('zoom.show') }} {{ Nav::isRoute('zoom.edit') }} {{ Nav::isRoute('zoom.setting') }} {{ Nav::isRoute('zoom.index') }} {{ Nav::isRoute('meeting.show') }} {{ Nav::isRoute('bbl.setting') }} {{ Nav::isRoute('bbl.all.meeting') }} {{ Nav::isRoute('download.meeting') }} {{ Nav::isRoute('googlemeet.setting') }} {{ Nav::isRoute('googlemeet.index') }} {{ Nav::isRoute('googlemeet.allgooglemeeting') }} {{ Nav::isRoute('jitsi.dashboard') }} {{ Nav::isRoute('jitsi.create') }} {{ Nav::isResource('meeting-recordings') }}">
                                <a href="javaScript:void();" class="menu"><i class="feather icon-clock text-secondary"></i>
                                    <span>{{ __('adminstaticword.Meetings') }}<div class="sub-menu truncate">Google Meet</div></span>
                                    <i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    <!-- ZoomLiveMeetings start  -->
                                    {{-- @if(isset($zoom_enable) && $zoom_enable == 1)
                                    <li
                                        class="{{ Nav::isRoute('meeting.create') }} {{ Nav::isRoute('zoom.show') }} {{ Nav::isRoute('zoom.edit') }} {{ Nav::isRoute('zoom.setting') }} {{ Nav::isRoute('zoom.index') }} {{ Nav::isRoute('meeting.show') }}">
                                        <a href="javaScript:void();">
                                            <i class=""></i> <span>{{ __('Zoom Meetings') }}</span><i
                                                class="feather icon-chevron-right"></i>
                                        </a>
                                        <ul class="vertical-submenu">
                                            <li class="{{ Nav::isRoute('zoom.setting') }}"><a
                                                    href="{{route('zoom.setting')}}">{{ __('Settings') }}</a>
                                            </li>
                                            <li
                                                class="{{ Nav::isRoute('zoom.index') }} {{ Nav::isRoute('zoom.show') }} {{ Nav::isRoute('zoom.edit') }} {{ Nav::isRoute('meeting.create') }}">
                                                <a href="{{route('zoom.index')}}">{{ __('Dashboard') }}</a>
                                            </li>

                                            <li class="{{ Nav::isRoute('meeting.show') }}"><a
                                                    href="{{route('meeting.show')}}">{{ __('adminstaticword.AllMeetings') }}</a>
                                            </li>

                                        </ul>
                                    </li>
                                    @endif --}}
                                    <!-- ZoomLiveMeetings end  -->
                                    <!-- BigBlueMeetings start  -->
                                    {{-- @if(isset($gsetting) && $gsetting->bbl_enable == 1)
                                    <li
                                        class="{{ Nav::isRoute('bbl.setting') }} {{ Nav::isRoute('bbl.all.meeting') }} {{ Nav::isRoute('download.meeting') }}">
                                        <a href="javaScript:void();">
                                            <i class=""></i> <span>{{ __('Big Blue') }}</span><i
                                                class="feather icon-chevron-right"></i>
                                        </a>
                                        <ul class="vertical-submenu">

                                            <li class="{{ Nav::isRoute('bbl.setting') }}"><a
                                                    href="{{ route('bbl.setting') }}">{{ __('Settings') }}</a>
                                            </li>
                                            <li class="{{ Nav::isRoute('bbl.all.meeting') }}"><a
                                                    href="{{ route('bbl.all.meeting') }}">{{ __('adminstaticword.ListMeetings') }}</a>
                                            </li>
                                            <li class="{{ Nav::isRoute('download.meeting') }}"><a
                                                    href="{{ route('download.meeting') }}">{{ __('Recorded') }}</a>
                                            </li>
                                        </ul>
                                    </li>
                                    @endif --}}
                                    <!-- BigBlueMeetings end  -->

                                    <!-- Google Meet Meeting start  -->
                                    @if(isset($gsetting) && $gsetting->googlemeet_enable == 1)
                                    <li
                                        class="{{ Nav::isRoute('googlemeet.setting') }} {{ Nav::isRoute('googlemeet.index') }} {{ Nav::isRoute('googlemeet.allgooglemeeting') }}">
                                        <a href="javaScript:void();">
                                            <i class=""></i> <span>{{ __('Google Meet') }}</span><i
                                                class="feather icon-chevron-right"></i>
                                        </a>
                                        <ul class="vertical-submenu">

                                            <li class="{{ Nav::isRoute('googlemeet.setting') }}"><a
                                                    href="{{route('googlemeet.setting')}}">{{ __('Settings') }}</a>
                                            </li>
                                            <li class="{{ Nav::isRoute('googlemeet.index') }}"><a
                                                    href="{{route('googlemeet.index')}}">{{ __('Dashboard') }}</a>
                                            </li>
                                            <li class="{{ Nav::isRoute('googlemeet.allgooglemeeting') }}"><a
                                                    href="{{route('googlemeet.allgooglemeeting')}}">{{ __('adminstaticword.AllMeetings') }}</a>
                                            </li>

                                        </ul>
                                    </li>
                                    @endif
                                    <!-- Google Meet Meeting end  -->

                                    <!-- Jitsi Meeting start -->
                                    {{-- @if(isset($gsetting) && $gsetting->jitsimeet_enable == 1)
                                    <li
                                        class="{{ Nav::isRoute('jitsi.dashboard') }} {{ Nav::isRoute('jitsi.create') }}">
                                        <a href="javaScript:void();">
                                            <i class=""></i> <span>{{ __('Jitsi Meeting') }}</span><i
                                                class="feather icon-chevron-right"></i>
                                        </a>
                                        <ul class="vertical-submenu">
                                            <li class="{{ Nav::isRoute('jitsi.dashboard') }}"><a
                                                    href="{{ route('jitsi.dashboard') }}">{{ __('Dashboard') }}</a></li>
                                        </ul>
                                    </li>
                                    @endif

                                    @if(Module::find('Googleclassroom') && Module::find('googleclassroom')->isEnabled())
                                    @include('googleclassroom::layouts.admin_sidebar_menu')
                                    @endif
                                    <!-- Jitsi Meeting end -->
                                    <li class="{{ Nav::isResource('meeting-recordings') }}"><a
                                            href="{{url('meeting-recordings')}}"><span>{{ __('adminstaticword.MeetingRecordings') }}</span></a>
                                    </li> --}}

                                </ul>
                            </li>
                            @endcanany

                            {{-- @can(['institute.view'])
                            <li>
                                <a href="{{url('institute')}}" class="menu"><i class="feather icon-grid text-secondary"></i>
                                    <span>{{ __('Institute') }}</span>
                                </a>
                            </li>
                            @endcan --}}


                            @can('certificate.manage')
                            @if(Module::has('Certificate') && Module::find('Certificate')->isEnabled())
                            @include('certificate::admin.sidebar_menu')
                            @endif
                            <li class="{{ Nav::isRoute('certificate.index') }}">
                                <a href="{{route('certificate.index')}}" class="menu"><i class="feather icon-help-circle text-secondary"></i>
                                    <span>{{ __('Certificate Verify') }}</span>
                                </a>
                            </li>
                            @endcan

                            <!--===================meeting end====================================  -->
                            <!-- ====================instructor start======================== -->

                            <!--===================instructor end====================================  -->
                            @can(['coupons.view'])

                            <li class="header">{{ __('Marketing') }}</li>
                            <li class="{{ Nav::isResource('coupon') }}">
                                <a href="{{url('coupon')}}" class="menu">
                                  <i class="feather icon-award text-secondary"></i><span>{{ __('adminstaticword.Coupon') }}</span>
                                </a>
                            </li>
                            
                            @endcan
                            @can(['followers.manage'])
                            <li class="{{ Nav::isRoute('follower.view') }}">
                                <a href="{{route('follower.view')}}" class="menu">
                                    <i class="feather icon-help-circle text-secondary"></i><span>{{ __('Followers') }}</span>
                                </a>
                            </li>
                            @endcan
                            @canany(['affiliate.manage',' wallet-setting.manage','wallet-transactions.manage'])
                            <li class="{{ Nav::isRoute('save.affiliates') }} {{ Nav::isRoute('wallet.settings') }} {{ Nav::isRoute('wallet.transactions') }}">
                               <a href="javaScript:void();" class="menu">
                                   <i class="feather icon-dollar-sign text-secondary"></i>
                                   <span>{{ __('adminstaticword.Affiliate&Wallet') }}
                                       <div class="sub-menu truncate">Affiliate, Wallet</div>
                                   </span>
                                   <i class="feather icon-chevron-right"></i>
                               </a>
                               <ul class="vertical-submenu">
                                   @can(['affiliate.manage'])
                                   <li class="{{ Nav::isRoute('save.affiliates') }}">
                                       <a href="{{route('save.affiliates')}}">{{ __('adminstaticword.Affiliate') }}</a>
                            </li>
                                   @endcan
                            @canany(['wallet-setting.manage','wallet-transactions.manage'])f

                                   <li class="{{ Nav::isRoute('wallet.settings') }} {{ Nav::isRoute('wallet.transactions') }}">
                                       <a href="javaScript:void();">

                                           <span>{{ __('adminstaticword.Wallet') }}</span>
                                   @endcan 
                                       </a>
                                       <ul class="vertical-submenu">
                                           @can(['wallet-setting.manage'])
                                           <li class="{{ Nav::isRoute('wallet.settings') }}"><a
                                                   href="{{route('wallet.settings')}}">{{ __('adminstaticword.Wallet') }}
                                                   {{ __('adminstaticword.Setting') }}</a>
                                           </li>
                                           @endcan
                                           @can(['wallet-transactions.manage'])
                                           <li class="{{ Nav::isRoute('wallet.transactions') }}"><a
                                                   href="{{route('wallet.transactions')}}">{{ __('adminstaticword.Wallet') }}
                                                   {{ __('adminstaticword.Transactions') }}</a>
                                           </li>
                                           @endcan

                                       </ul>
                                   </li>

                               </ul>
                            </li>
                            @endcanany
                            <!-- PushNotification -->
                            {{-- @can(['push-notification.manage'])
                            <li class="{{ Nav::isRoute('onesignal.settings') }}">
                                <a href="{{route('onesignal.settings')}}" class="menu">
                                    <i class="feather icon-navigation text-secondary"></i>
                                    <span>{{ __('adminstaticword.PushNotification') }}</span>
                                </a>
                            </li>
                            @endcan --}}


                            {{-- @can(['flash-deals.view'])
                            <li class="{{ Nav::isResource('admin/flash-sales') }}">
                                <a href="{{url('admin/flash-sales')}}" class="menu">
                                    <i class="feather icon-clock text-secondary"></i>
                                    <span>{{ __('Flash Deals') }}</span>
                                </a>
                            </li>
                            @endcan --}}



                            <!-- attandance -->
                            @can(['attendance.manage'])
                            @if(isset($gsetting) && $gsetting->attandance_enable == 1)
                            <li class="{{ Nav::isResource('attandance') }}">
                                <a href="{{url('attandance')}}" class="menu">
                                    <i class="feather icon-user text-secondary"></i>
                                    <span>{{ __('adminstaticword.Attandance') }}</span>
                                </a>
                            </li>
                            @endif
                            @endcan

                            <!-- coupon -->
                            @can(['orders.manage'])

                            <li class="header">{{ __('Financial') }}</li>

                            <!-- order -->
                            <li class="{{ Nav::isResource('order') }}">
                                <a href="{{url('order')}}" class="menu">
                                    <i class="feather icon-shopping-cart text-secondary"></i>
                                    <span>{{ __('adminstaticword.Order') }}</span>
                                </a>
                            </li>
                            @endcan

                            <!-- order -->

                            @can(['blogs.view'])

                            <li class="header">{{ __('Content') }}</li>

                            <li class="{{ Nav::isResource('blog') }}">
                                <a href="{{url('blog')}}" class="menu">
                                    <i class="feather icon-message-square text-secondary"></i>
                                    <span>{{ __('Blogs') }}</span>
                                </a>
                            </li>
                            @endcan
                            <!-- pages start -->
                            {{-- @can(['pages.view'])
                            <li class="{{ Nav::isResource('page') }}">
                                <a href="{{url('page')}}" class="menu">
                                    <i class="feather icon-file-text text-secondary"></i>
                                    <span>{{ __('Pages') }}</span>
                                </a> 
                            </li>
                            @endcan --}}
                            <!-- pages end -->
                            <!-- report start  -->
                            @canany(['report.progress-report.manage','report.quiz-report.manage','report.revenue-admin-report.manage','report.revenue-instructor-report.manage'])
                            <li class="{{ Nav::isResource('user/course/report') }} {{ Nav::isResource('user/question/report') }}{{url('show/progress/report')}} {{ Nav::isResource('show/quiz/report') }}">
                                <a href="javaScript:void();" class="menu">
                                    <i class="feather icon-file-text text-secondary"></i>
                                    <span>{{ __('adminstaticword.Report') }}<div class="sub-menu truncate">Quiz Report, Progress Report, Revenue Report,  Financial Reports, Device History</div></span>
                                    <i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">


                                    <li class="{{ Nav::isResource('show/quiz/report') }}">
                                        <a href="{{url('show/quiz/report')}}">{{ __('Quiz') }} {{ __('Report') }} </a>
                                    </li>
                                    <li class="{{ Nav::isResource('show/progress/report') }}">
                                        <a href="{{url('show/progress/report')}}">{{ __('Progress') }}
                                            {{ __('Report') }}</a>
                                    </li>

                                    <!-- revenue report start  -->
                                    <li
                                        class="{{ Nav::isRoute('admin.revenue.report') }} {{ Nav::isRoute('instructor.revenue.report') }}{{ Nav::isResource('device-logs') }}">
                                        <a href="javaScript:void();"><span>{{ __('adminstaticword.Revenue') }}
                                                {{ __('adminstaticword.Report') }}</span><i
                                                class="feather icon-chevron-right"></i>
                                        </a>
                                        <ul class="vertical-submenu">

                                            <li class="{{ Nav::isRoute('admin.revenue.report') }}">
                                                <a
                                                    href="{{route('admin.revenue.report')}}">{{ __('adminstaticword.AdminRevenue') }}</a>
                                            </li>

                                            <li class="{{ Nav::isRoute('instructor.revenue.report') }}">
                                                <a
                                                    href="{{route('instructor.revenue.report')}}">{{ __('adminstaticword.InstructorRevenue') }}</a>
                                            </li>

                                        </ul>
                                    </li>


                                    <li class="{{ Nav::isResource('admin/report/view') }}">
                                        <a href="{{ route('order.report') }}">
                                            {{ __('Financial reports') }} </a>
                                    </li>

                                    <li class="{{ Nav::isResource('device-logs') }}">
                                        <a href="{{url('device-logs')}}">{{ __('Device History') }} </a>
                                    </li>

                                </ul>
                            </li>
                            
                            @endcanany
                            <!-- report end -->
                            <!-- forum -->
                            @can('forum-discussion.manage')
                            @if(Module::find('forum') && Module::find('forum')->isEnabled())
                            @include('forum::layouts.admin_sidebar_menu')
                            @endif
                            @endcan
                            @can(['about.manage'])
                            <li class="{{ Nav::isRoute('about.page') }}">
                                <a href="{{route('about.page')}}" class="menu">
                                    <i class="feather icon-external-link text-secondary"></i>
                                    <span>{{ __('adminstaticword.About') }}</span>
                                </a>
                            </li>
                            @endcan
                            <!-- faq start  -->
                            @canany(['faq.faq-student.view','faq.faq-instructor.view'])
                            {{-- tala --}}
                            <li class="{{ Nav::isResource('faq') }} {{ Nav::isResource('faqinstructor') }}">
                                <a href="{{url('faq')}}" class="menu">
                                    <i class="feather icon-message-square text-secondary"></i>
                                     <span>{{ __('adminstaticword.Faq') }}</span>
                                </a>
                            </li>
                            {{-- tala --}}
                            {{-- <li class="{{ Nav::isResource('faq') }} {{ Nav::isResource('faqinstructor') }}">
                                <a href="javaScript:void();" class="menu">
                                    <i class="feather icon-help-circle text-secondary"></i>
                                    <span>{{ __('adminstaticword.Faq') }}<div class="sub-menu truncate">Faq Student, Faq Instructor</div></span>
                                    <i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">

                                    <li class="{{ Nav::isResource('faq') }}">
                                        <a href="{{url('faq')}}">{{ __('adminstaticword.FaqStudent') }}</a>
                                    </li>

                                    <li class="{{ Nav::isResource('faqinstructor') }}">
                                        <a href="{{url('faqinstructor')}}">{{ __('adminstaticword.FaqInstructor') }}</a>
                                    </li>

                                </ul>
                            </li> --}}
                            @endcanany
                            {{-- @can(['career.manage'])
                            <li class="{{ Nav::isRoute('careers.page') }}">
                                <a href="{{route('careers.page')}}" class="menu">
                                    <i class="feather icon-sidebar text-secondary"></i><span>{{ __('adminstaticword.Career') }}</span>
                                </a>
                            </li>
                            @endcan --}}
                            <!-- faq end -->
                            <!-- location start -->
                            @canany(['locations.country.view','locations.state.view','locations.city.view'])
                            <li class="{{ Nav::isResource('admin/country') }} {{ Nav::isResource('admin/state') }} {{ Nav::isResource('admin/city') }}">
                                <a href="javaScript:void();" class="menu"><i class="feather icon-map-pin text-secondary"></i>
                                    <span>{{ __('Locations') }}<div class="sub-menu truncate">Country, State, City</div></span>
                                    <i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    @can(['locations.country.view'])

                                    <li class="{{ Nav::isResource('admin/country') }}"><a
                                            href="{{url('admin/country')}}">{{ __('adminstaticword.Country') }}</a>
                                    </li>
                                    @endcan
                                    @can(['locations.state.view'])
                                    <li class="{{ Nav::isResource('admin/state') }}"><a
                                            href="{{url('admin/state')}}">{{ __('adminstaticword.State') }}</a>
                                    </li>
                                    @endcan
                                    @can(['locations.city.view'])
                                    <li class="{{ Nav::isResource('admin/city') }}"><a
                                            href="{{url('admin/city')}}">{{ __('adminstaticword.City') }}</a>
                                    </li>
                                    @endcan

                                </ul>
                            </li>
                            @endcanany
                            <!-- contact us start -->
                            @can('contact-us.manage')
                            <li class="{{ Nav::isResource('usermessage') }}">
                                <a href="{{url('usermessage')}}" class="menu"><i
                                        class="feather icon-phone-call text-secondary"></i><span>{{ __('adminstaticword.ContactUs') }}</span>
                                </a>
                            </li>
                            @endcan
                            @can('job.manage')
                            @if(Module::has('Resume') && Module::find('Resume')->isEnabled())
                            @include('resume::front.job.admin.icon')
                            @endif
                            @endcan
                            <!-- contact us end -->
                            <!-- location end -->
                            <li class="header">{{ __('Setting') }}</li>
                            {{-- @can(['get-api-key.manage'])
                            <li class="{{ Nav::isRoute('get.api.key') }}">
                                <a href="{{route('get.api.key')}}" class="menu">
                                    <i class="feather icon-share text-secondary"></i><span>{{ __('adminstaticword.GetAPIKeys') }}</span>
                                </a>
                            </li>
                            @endcan --}}
                            {{-- @can(['currency.view'])
                            <li class="{{ Nav::isRoute('currency.index') }}">
                                <a href="{{route('currency.index')}}" class="menu">
                                    <i class="feather icon-dollar-sign text-secondary"></i><span>{{ __('adminstaticword.Currency') }}</span>
                                </a>
                            </li>
                            @endcan --}}
                             {{-- <!-- @can(['themes.manage']) -->
                             
                            <li class="{{ Nav::isRoute('themesettings.index') }}">
                                <a href="{{route('themesettings.index')}}" class="menu">
                                    <i class="feather icon-airplay text-secondary"></i>
                                    <span>{{ __('adminstaticword.Themes') }}</span>
                                </a>
                            </li>
                            <!-- @endcan  --> --}}
                            {{-- @can(['homepage-setting.manage'])
                            <li class="{{ Nav::isRoute('homepage.setting') }}">
                                <a href="{{route('homepage.setting')}}" class="menu"><i
                                class="feather icon-settings text-secondary"></i><span>{{ __('Homepage Setting') }}</span></a>
                            </li>
                            @endcan --}}
                            {{-- <li class="{{ Nav::isRoute('admincustomisation') }}">
                                <a href="{{url('admincustomisation')}}" class="menu"><i
                                    class="feather icon-settings text-secondary"></i><span><span>{{ __('Admin Color Setting') }}</span></a>
                            </li> --}}
                            {{-- <li class="{{ Nav::isRoute('mailchimp') }}">
                                <a href="{{url('mailchimp/setting')}}"><i
                                    class="feather icon-settings text-secondary"></i><span><span>{{ __('Mail Chimp Setting') }}</span></a>
                            </li> --}}
                            <!-- front setting start  -->
                            @canany(['front-settings.testimonial.view','front-settings.advertisement.view','front-settings.sliders.view','front-settings.fact-slider.view','category-sliders.manage','get-started.manage','front-settings.trusted-sliders.view','widget.manage','front-settings.seo-directory.view','coming-soon.manage','terms-condition.manage','privacy-policy.manage','invoice-design.manage','login-signup.manage','video-setting.manage','breadcum-setting.manage','front-settings.fact-slider.view','join-an-instructor.manage '])
                            <li class="{{ Nav::isResource('testimonial') }} {{ Nav::isResource('advertisement') }} {{ Nav::isResource('slider') }} {{ Nav::isResource('facts') }} {{ Nav::isRoute('category.slider') }} {{ Nav::isResource('getstarted') }} {{ Nav::isResource('trusted') }} {{ Nav::isRoute('widget.setting') }} {{ Nav::isRoute('terms') }} {{ Nav::isResource('directory') }} {{ Nav::isRoute('videosetting') }} {{ Nav::isRoute('breadcum') }} {{ Nav::isRoute('fact') }} {{ Nav::isRoute('joininstructor') }}">
                                <a href="javaScript:void();" class="menu"><i class="feather icon-monitor text-secondary"></i>
                                    <span>{{ __('adminstaticword.FrontSetting') }}<div class="sub-menu truncate">Testimonial, Slider, Fact Slider, Trusted Slider, Terms & Condition, Privacy Policy, Invoice Design, Videosetting, </div></span>
                                    <i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    @can(['front-settings.testimonial.view'])
                                    <li class="{{ Nav::isResource('testimonial') }}"><a
                                            href="{{url('testimonial')}}"><span>{{ __('adminstaticword.Testimonial') }}</span></a>
                                    </li>
                                    @endcan
                                    {{-- @can(['front-settings.advertisement.view'])
                                    <li class="{{ Nav::isResource('advertisement') }}"><a
                                            href="{{url('advertisement')}}"><span>{{ __('adminstaticword.Advertisement')}}</span></a>
                                    </li>
                                    @endcan --}}
                                    @can(['front-settings.sliders.view'])
                                    <li class="{{ Nav::isResource('slider') }}"><a
                                            href="{{url('slider')}}"><span>{{ __('adminstaticword.Slider') }}</span></a>
                                    </li>
                                    @endcan
                                    @can(['front-settings.fact-slider.view'])
                                    <li class="{{ Nav::isResource('facts') }}"><a
                                            href="{{url('facts')}}"><span>{{ __('Fact Slider') }}</span></a>
                                    </li>
                                    @endcan

                                    {{-- @can(['category-sliders.manage'])
                                    <li class="{{ Nav::isRoute('category.slider') }}"><a
                                            href="{{route('category.slider')}}"><span>{{ __('adminstaticword.CategorySlider') }}</span></a>
                                    </li>
                                    @endcan --}}
                                    {{-- @can(['get-started.manage'])

                                    <li class="{{ Nav::isResource('getstarted') }}"><a
                                            href="{{url('getstarted')}}">{{ __('adminstaticword.GetStarted') }}</a>
                                    </li>
                                    @endcan --}}
                                    {{-- @can(['front-settings.trusted-sliders.view'])
                                    <li class="{{ Nav::isResource('trusted') }}"><a
                                            href="{{url('trusted')}}"><span>{{ __('adminstaticword.TrustedSlider') }}</span></a>
                                    </li>
                                    @endcan --}}
                                    {{-- @can(['widget.manage'])
                                    
                                    <li class="{{ Nav::isRoute('widget.setting') }}"><a
                                            href="{{route('widget.setting')}}">{{ __('Widget') }}</a>
                                    </li>
                                    @endcan --}}
                                    {{-- @can(['front-settings.seo-directory.view'])
                                    <li class="{{ Nav::isResource('directory') }}"><a
                                            href="{{url('directory')}}"><span>{{ __('adminstaticword.Seo') }}
                                                {{ __('adminstaticword.Directory') }}</span></a>
                                    </li>
                                    @endcan --}}
                                    {{-- @can(['coming-soon.manage'])

                                    <li class="{{ Nav::isRoute('comingsoon.page') }}">
                                        <a
                                            href="{{route('comingsoon.page')}}">{{ __('adminstaticword.ComingSoon') }}</a>
                                    </li>
                                    @endcan --}}
                                    @can(['terms-condition.manage'])
                                    <li class="{{ Nav::isRoute('termscondition') }}">
                                        <a href="{{route('termscondition')}}">{{ __('adminstaticword.Terms&Condition') }}
                                        </a>
                                    </li>
                                    @endcan
                                    @can(['privacy-policy.manage'])
                                    <li class="{{ Nav::isRoute('policy') }}">
                                        <a href="{{route('policy')}}">{{ __('adminstaticword.PrivacyPolicy') }}</a>
                                    </li>
                                    @endcan
                                    {{-- @can(['invoice-design.manage'])
                                   

                                    <li class="{{ Nav::isRoute('invoice/settings') }}">
                                        <a href="{{ url('invoice/settings') }}">{{ __('Invoice Design') }}{{ __('') }}</a>
                                    </li>
                                    @endcan --}}
                                    {{-- @can(['login-signup.manage'])
                                    <li class="{{ Nav::isRoute('login') }}">
                                        <a href="{{ url('settings/login') }}">{{ __('Login/Signup') }}{{ __('') }}</a>
                                    </li>
                                    @endcan --}}
                                    @can(['video-setting.manage'])
                                    <li class="{{ Nav::isRoute('videosetting') }}">
                                        <a href="{{ route('videosetting') }}">{{ __('Videosetting') }}{{ __('') }}</a>
                                    </li>
                                    @endcan
                                    {{-- @can(['breadcum-setting.manage'])
                                    <li class="{{ Nav::isRoute('breadcum') }}">
                                        <a href="{{ url('breadcum/setting') }}">{{ __('Breadcumsetting') }}{{ __('') }}</a>
                                    </li>
                                    @endcan --}}
                                    {{-- @can(['front-settings.fact-slider.view'])
                                    <li class="{{ Nav::isRoute('fact') }}">
                                        <a href="{{ url('fact') }}">{{ __('Factsetting, ') }}{{ __('') }}</a>
                                    </li>
                                    @endcan --}}
                                    {{-- @can(['join-an-instructor.manage'])
                                    <li class="{{ Nav::isRoute('joininstructor') }}">
                                        <a href="{{ url('join/setting') }}">{{ __('Join an Instructor') }}{{ __('') }}</a>
                                    </li>
                                    @endcan --}}

                                </ul>
                            </li>
                            @endcanany

                            <!-- front setting end -->
                            <!-- site setting start  -->
                            {{-- @canany(['settings.manage','pwa.manage','adsense-setting.manage','twilio-setting.manage','site-map-setting.manage','site-settings.language.view','email-design.manage'])
                            <li class="{{ Nav::isRoute('gen.set') }} {{ Nav::isRoute('careers.page') }}  {{ Nav::isRoute('termscondition') }} {{ Nav::isRoute('policy') }}  {{ Nav::isRoute('show.pwa') }} {{ Nav::isRoute('adsense') }} {{ Nav::isRoute('ipblock.view') }}   {{ Nav::isRoute('twilio.settings') }} {{ Nav::isRoute('show.sitemap') }} {{ Nav::isRoute('show.lang') }}">
                                <a href="javaScript:void();" class="menu"><i class="feather icon-settings text-secondary"></i>
                                    <span>{{ __('adminstaticword.SiteSetting') }}<div class="sub-menu truncate">Setting, PWA, Adsense, IP Block Settings, Twilio, Site Map, Language, Email Design</div></span>
                                    <i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">

                                    @can(['settings.manage'])
                                     <li class="{{ Nav::isRoute('gen.set') }}">
                                        <a href="{{route('gen.set')}}">{{ __('adminstaticword.Setting') }}</a>
                                    </li>
                                    @endcan
                                    
                                    @can(['pwa.manage'])
                                    <li class="{{ Nav::isRoute('show.pwa') }}">
                                        <a href="{{route('show.pwa')}}">{{ __('PWA') }}</a>
                                    </li>
                                    @endcan
                                    
                                    @can(['adsense-setting.manage'])
                                    <li class="{{ Nav::isRoute('adsense') }}">
                                        <a href="{{url('/admin/adsensesetting')}}">{{ __('Adsense') }}</a>
                                    </li>
                                    @endcan

                                    @if(isset($gsetting) && $gsetting->ipblock_enable == 1)
                                    <li class="{{ Nav::isRoute('ipblock.view') }}">
                                        <a
                                            href="{{url('admin/ipblock')}}">{{ __('adminstaticword.IPBlockSettings') }}</a>
                                    </li>
                                    @endif
                                    @can(['twilio-setting.manage'])
                                    <li class="{{ Nav::isRoute('twilio.settings') }}">
                                        <a href="{{route('twilio.settings')}}">{{ __('Twilio') }}</a>
                                    </li>
                                    @endcan
                                    @can(['site-map-setting.manage'])
                                    <li class="{{ Nav::isRoute('show.sitemap') }}">
                                        <a href="{{route('show.sitemap')}}">{{ __('adminstaticword.SiteMap') }}</a>
                                    </li>
                                    @endcan
                                    
                                    @can(['site-settings.language.view'])
                                    <li class="{{ Nav::isRoute('show.lang') }}">
                                        <a href="{{route('show.lang')}}">{{ __('adminstaticword.Language') }}</a>
                                    </li>
                                    @endcan
                                    @can(['email-design.manage'])
                                    
                                    <li class="{{ Nav::isRoute('maileclipse/mailables') }}">
                                        <a href="{{ url('maileclipse/mailables') }}">{{ __('Email Design') }}{{ __('') }}</a>
                                    </li>
                                    @endcan
                                    


                                </ul>
                            </li>
                            @endcanany --}}
                            <!-- site setting end -->
                            <!-- payment setting start -->
                            @canany(['payment-setting.manual-payment.view'])
                            {{-- @canany(['payment-setting-credentials.manage','payment-setting-MPESA-setting.manage','payment-setting-bank-details.manage','payment-setting.manual-payment.view']) --}}
                            <li class=" {{ Nav::isResource('manualpayment') }} ">
                            {{-- <li class=" {{ Nav::isRoute('api.setApiView') }}{{ Nav::isRoute('bank.transfer') }}{{ Nav::isResource('manualpayment') }} "> --}}
                                <a href="javaScript:void();" class="menu"><i class="feather icon-dollar-sign text-secondary"></i>
                                    <span>{{ __('Payment Setting') }}<div class="sub-menu truncate">Manual Payment</div></span>
                                    <i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    {{-- @can(['payment-setting-credentials.manage'])
                                    <li class="{{ Nav::isRoute('api.setApiView') }}">
                                        <a href="{{route('api.setApiView')}}">{{ __('Credentials') }}</a>
                                    </li>
                                    @endcan --}}

                                    {{-- @if(Module::has('MPesa') && Module::find('MPesa')->isEnabled())
                                    @include('mpesa::admin.sidebar')
                                    @endif
                                    @can(['payment-setting-bank-details.manage'])

                                    <li class="{{ Nav::isRoute('bank.transfer') }}">
                                        <a href="{{route('bank.transfer')}}">{{ __('adminstaticword.BankDetails') }}</a>
                                    </li>
                                    @endcan --}}
                                    @can(['payment-setting.manual-payment.view'])
                                    <li class="{{ Nav::isResource('manualpayment') }}">
                                        <a href="{{url('manualpayment')}}">{{ __('Manual Payment') }}</a>
                                    </li>
                                    @endcan
                                </ul>
                            </li>
                            @endcanany
                            <!-- payment setting start end -->
                            <!-- player setting start -->
                            {{-- @canany(['player-settings.manage','player-settings.advertise.view'])
                            <li class="{{ Nav::isRoute('player.set') }} {{ Nav::isRoute('ads') }} {{ Nav::isRoute('ad.setting') }}">
                                <a href="javaScript:void();" class="menu"><i class="feather icon-play-circle text-secondary"></i>
                                    <span>{{ __('adminstaticword.PlayerSettings') }}<div class="sub-menu truncate">Player Customization, Advertise Settings</div></span>
                                    <i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    @can(['player-settings.manage'])


                                    <li class="{{ Nav::isRoute('player.set') }}"><a
                                            href="{{route('player.set')}}">{{ __('adminstaticword.PlayerCustomization') }}</a>
                                    </li>
                                    @endcan

                                    <li class="{{ Nav::isRoute('ads') }}"><a href="{{url('admin/ads')}}"
                                            title="Create ad">{{ __('adminstaticword.Advertise') }}</a></li>
                                    @php $ads = App\Ads::all(); @endphp
                                    @can(['player-settings.advertise.view'])
                                    @if($ads->count()>0)
                                    <li class="{{ Nav::isRoute('ad.setting') }}"><a href="{{url('admin/ads/setting')}}"
                                            title="Ad Settings">{{ __('adminstaticword.AdvertiseSettings') }}</a>
                                    </li>
                                    @endif
                                    @endcan

                                </ul>
                            </li>
                            @endcanany --}}
                            <!-- player setting start end -->
                            @if(isset($gsetting) && $gsetting->activity_enable == '1')
                            <li class="{{ Nav::isRoute('activity.index') }}">
                                <a href="{{route('activity.index')}}" class="menu">
                                    <i class="feather icon-help-circle text-secondary"></i><span>{{ __('adminstaticword.ActivityLog') }}</span>
                                </a>
                            </li>

                            @endif
                            {{-- @can(['addon.view'])

                            <li class="header">{{ __('Support') }}</li>
                            <!-- help & support start  -->
                            <li class="{{ Nav::isResource('admin-addon') }}">
                                <a href="{{url('admin/addon')}}" class="menu"> 
                                    <i class="feather icon-move text-secondary"></i><span>{{ __('adminstaticword.Addon') }}
                                    {{ __('adminstaticword.Manager') }}</span>
                                </a>
                            </li>
                            @endcan --}}
                            {{-- @can(['update-process.manage'])
                            <li class="{{ Nav::isRoute('update.process') }}">
                                <a href="{{route('update.process')}}" class="menu"><i class="feather icon-share text-secondary"></i><span>{{ __('adminstaticword.UpdateProcess') }}</span>
                                </a>
                            </li>
                            @endcan --}}
                            {{-- @canany(['help-support-import-demo.manage','help-support-database-backup.manage','help-support-remove-public.manage','help-support-clear-cache.manage'])
                            <li class="{{ Nav::isRoute('import.view') }} {{ Nav::isRoute('database.backup') }} ">
                                <a href="javaScript:void();" class="menu">
                                    <i class="feather icon-help-circle text-secondary"></i>
                                    <span>{{ __('adminstaticword.Help&Support') }}<div class="sub-menu truncate">Import Demo, Database Backup, Remove Public, Clear Cache</div></span>
                                    <i class="feather icon-chevron-right"></i>
                                </a>
                                <ul class="vertical-submenu">
                                    @can(['help-support-import-demo.manage'])

                                    <li class="{{ Nav::isRoute('import.view') }}">
                                        <a href="{{route('import.view')}}">{{ __('adminstaticword.ImportDemo') }}</a>
                                    </li>
                                    @endcan
                                    @can(['help-support-database-backup.manage'])
                                    <li class="{{ Nav::isRoute('database.backup') }}">
                                        <a
                                            href="{{route('database.backup')}}">{{ __('adminstaticword.DatabaseBackup') }}</a>
                                    </li>
                                    @endcan
                                    @can(['help-support-remove-public.manage'])
                                   

                                    <li class="{{ Nav::isRoute('remove.public') }}">
                                        <a
                                            href="{{route('remove.public')}}">{{ __('adminstaticword.RemovePublic') }}</a>
                                    </li>
                                    @endcan
                                    @can(['help-support-clear-cache.manage'])
                                    <li class="{{ Nav::isRoute('clear-cache') }}">
                                        <a href="{{url('clear-cache')}}">{{ __('adminstaticword.ClearCache') }}</a>
                                    </li>
                                    @endcan


                                </ul>
                            </li>
                            @endcanany --}}
                            <!-- help & support end -->



                            </li>
                        </ul>
                    </div>

                </div>

            </div>
        </div>
        <!-- End Navigationbar -->
    </div>
    <!-- End Sidebar -->
</div>