<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          @if(Auth::User()['user_img'] != null && Auth::User()['user_img'] !='' && @file_get_contents('images/user_img/'.Auth::user()['user_img']))
          <img src="{{ asset('images/user_img/'.Auth::User()->user_img)}}" class="img-circle" alt="">

          @else
          <img src="{{ asset('images/default/user.jpg') }}" class="img-circle" alt="">

          @endif
        </div>
        <div class="pull-left info">
          <p>{{ Auth::User()->fname }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> {{ __('adminstaticword.Online') }}</a>
        </div>
      </div>


      @if(Auth::User()->role == "admin")
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">{{ __('adminstaticword.Navigation') }}</li>
        
          <li class="{{ Nav::isRoute('admin.index') }}"><a href="{{route('admin.index')}}"><i class="flaticon-web-browser" aria-hidden="true"></i><span>{{ __('adminstaticword.Dashboard') }}</span></a></li>

          <li class="{{ Nav::isRoute('user.index') }} {{ Nav::isRoute('user.add') }} {{ Nav::isRoute('user.edit') }}"><a href="{{route('user.index')}}"><i class="flaticon-user" aria-hidden="true"></i><span>{{ __('adminstaticword.Users') }}</span></a></li>

          <li class="{{ Nav::isRoute('meeting.create') }} {{ Nav::isRoute('zoom.show') }} {{ Nav::isRoute('zoom.edit') }} {{ Nav::isRoute('zoom.setting') }} {{ Nav::isRoute('zoom.index') }} {{ Nav::isRoute('meeting.show') }} {{ Nav::isRoute('bbl.setting') }} {{ Nav::isRoute('bbl.all.meeting') }} {{ Nav::isRoute('download.meeting') }} {{ Nav::isRoute('googlemeet.setting') }} {{ Nav::isRoute('googlemeet.index') }} {{ Nav::isRoute('googlemeet.allgooglemeeting') }} {{ Nav::isRoute('jitsi.dashboard') }} {{ Nav::isRoute('jitsi.create') }} {{ Nav::isResource('meeting-recordings') }} treeview">
            <a href="#">
              <i class="flaticon-live-1" aria-hidden="true"></i> <span>{{ __('adminstaticword.Meetings') }}</span>
              <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @if(isset($zoom_enable) && $zoom_enable == 1)
                  <li class="{{ Nav::isRoute('meeting.create') }} {{ Nav::isRoute('zoom.show') }} {{ Nav::isRoute('zoom.edit') }} {{ Nav::isRoute('zoom.setting') }} {{ Nav::isRoute('zoom.index') }} {{ Nav::isRoute('meeting.show') }} treeview">
                    <a href="#">
                     <i class="fa fa-gg" aria-hidden="true"></i> <span>{{ __('adminstaticword.ZoomLiveMeetings') }}</span>
                      <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <li class="{{ Nav::isRoute('zoom.setting') }}"><a href="{{route('zoom.setting')}}"><i class="flaticon-settings-1"></i>{{ __('adminstaticword.ZoomSettings') }}</a></li>
                      <li class="{{ Nav::isRoute('zoom.index') }} {{ Nav::isRoute('zoom.show') }} {{ Nav::isRoute('zoom.edit') }} {{ Nav::isRoute('meeting.create') }}"><a href="{{route('zoom.index')}}"><i class="fa fa-file-text-o"></i>{{ __('adminstaticword.ZoomDashboard') }}</a></li>
                      <li class="{{ Nav::isRoute('meeting.show') }}"><a href="{{route('meeting.show')}}"><i class="flaticon-online-education"></i>{{ __('adminstaticword.AllMeetings') }}</a></li>
                    </ul>
                  </li>
              @endif

              @if(isset($gsetting) && $gsetting->bbl_enable == 1)
                  <li class="{{ Nav::isRoute('bbl.setting') }} {{ Nav::isRoute('bbl.all.meeting') }} {{ Nav::isRoute('download.meeting') }} treeview">
                    <a href="#">
                     <i class="flaticon-honesty" aria-hidden="true"></i> <span>{{ __('adminstaticword.BigBlueMeetings') }}</span>
                      <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <li class="{{ Nav::isRoute('bbl.setting') }}"><a href="{{ route('bbl.setting') }}"><i class="flaticon-settings"></i>{{ __('adminstaticword.BigBlueButtonSettings') }}</a></li>
                      <li class="{{ Nav::isRoute('bbl.all.meeting') }}"><a href="{{ route('bbl.all.meeting') }}"><i class="flaticon-terms-and-conditions"></i>{{ __('adminstaticword.ListMeetings') }}</a></li>


                      <li class="{{ Nav::isRoute('download.meeting') }}"><a href="{{ route('download.meeting') }}"><i class="flaticon-terms-and-conditions"></i>{{ __('adminstaticword.MeetingRecordings') }}</a></li>


                    </ul>
                  </li>
              @endif
                   <!-- ======= googlemmet start =============== -->
              @if(isset($gsetting) && $gsetting->googlemeet_enable == 1)  
                <li class="{{ Nav::isRoute('googlemeet.setting') }} {{ Nav::isRoute('googlemeet.index') }} {{ Nav::isRoute('googlemeet.allgooglemeeting') }} treeview">
                  <a href="#">
                   <i class="fa fa-gg-circle" aria-hidden="true"></i> <span>{{ __('Google Meet Meeting') }}</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li class="{{ Nav::isRoute('googlemeet.setting') }}"><a href="{{route('googlemeet.setting')}}"><i class="flaticon-settings-1"></i>{{ __('Google Meet Settings') }}</a></li>
                    <li class="{{ Nav::isRoute('googlemeet.index') }}"><a href="{{route('googlemeet.index')}}"><i class="fa fa-file-text-o"></i>{{ __('Google Meet Dashboard') }}</a></li>
                    <li class="{{ Nav::isRoute('googlemeet.allgooglemeeting') }}"><a href="{{route('googlemeet.allgooglemeeting')}}"><i class="flaticon-online-education"></i>{{ __('adminstaticword.AllMeetings') }}</a></li>
                  </ul>
                </li>
              @endif
              <!-- ======= googlemeet end ================= -->

              <!-- ======= jitsi meeting start =============== -->
              @if(isset($gsetting) && $gsetting->jitsimeet_enable == 1)
                <li class="{{ Nav::isRoute('jitsi.dashboard') }} {{ Nav::isRoute('jitsi.create') }} treeview">
                    <a href="#">
                     <i class="fa fa-sheqel" aria-hidden="true"></i> <span>{{ __('Jitsi Meeting') }}</span>
                      <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <li class="{{ Nav::isRoute('jitsi.dashboard') }}"><a href="{{ route('jitsi.dashboard') }}"><i class="flaticon-settings-1"></i>{{ __('Dashboard') }}</a></li>
                      
                    </ul>
                  </li>
              @endif
              <!-- ======= jitsi meeting end ================= -->


              <li class="{{ Nav::isResource('meeting-recordings') }}"><a href="{{url('meeting-recordings')}}"><i class="fa fa-bullseye" aria-hidden="true"></i><span>{{ __('adminstaticword.MeetingRecordings') }}</span></a></li>

            </ul>
          </li>

        

       

          <li class="{{ Nav::isResource('admin/country') }} {{ Nav::isResource('admin/state') }} {{ Nav::isResource('admin/city') }} treeview">
            <a href="#">
              <i class="flaticon-location" aria-hidden="true"></i> <span>{{ __('adminstaticword.Location') }}</span>
              <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="{{ Nav::isResource('admin/country') }}"><a href="{{url('admin/country')}}"><i class="flaticon-flag"></i>{{ __('adminstaticword.Country') }}</a></li>
              <li class="{{ Nav::isResource('admin/state') }}"><a href="{{url('admin/state')}}"><i class="flaticon-placeholder"></i>{{ __('adminstaticword.State') }}</a></li>
              <li class="{{ Nav::isResource('admin/city') }}"><a href="{{url('admin/city')}}"><i class="flaticon-home"></i>{{ __('adminstaticword.City') }}</a></li>
            </ul>
          </li>

          <li class="{{ Nav::isResource('currency') }}"><a href="{{url('currency')}}"> <i class="flaticon-wallet"></i><span>{{ __('adminstaticword.Currency') }}</span></a></li>
         

          <li class="{{ Nav::isResource('category') }} {{ Nav::isResource('subcategory') }} {{ Nav::isResource('childcategory') }} {{ Nav::isResource('course') }} {{ Nav::isResource('bundle') }} {{ Nav::isResource('courselang') }} {{ Nav::isResource('coursereview') }} {{ Nav::isRoute('assignment.view') }} {{ Nav::isResource('refundpolicy') }} {{ Nav::isResource('batch') }} {{ Nav::isRoute('quiz.review') }} {{ Nav::isResource('private-course') }} treeview">
            <a href="#">
                <i class="flaticon-browser-1"></i>{{ __('adminstaticword.Course') }}
                <i class="fa fa-angle-left pull-right"></i>
            </a>                            

            <ul class="treeview-menu">
              <li class="{{ Nav::isResource('category') }} {{ Nav::isResource('subcategory') }} {{ Nav::isResource('childcategory') }} treeview">
                  <a href="#"><i class="flaticon-interface" aria-hidden="true"></i>{{ __('adminstaticword.Category') }}<i class="fa fa-angle-left pull-right"></i></a>
                  
                  <ul class="treeview-menu">
                    <li class="{{ Nav::isResource('category') }}"><a href="{{url('category')}}"><i class="flaticon-rec"></i>{{ __('adminstaticword.Category') }}</a></li>
                    <li class="{{ Nav::isResource('subcategory') }}"><a href="{{url('subcategory')}}"><i class="flaticon-rec"></i>{{ __('adminstaticword.SubCategory') }}</a></li>
                    <li class="{{ Nav::isResource('childcategory') }}"><a href="{{url('childcategory')}}"><i class="flaticon-rec"></i>{{ __('adminstaticword.ChildCategory') }}</a></li>
                  </ul>

                  <li class="{{ Nav::isResource('course') }}"><a href="{{url('course')}}"><i class="flaticon-document" aria-hidden="true"></i><span>{{ __('adminstaticword.Courses') }}</span></a></li>

                  <li class="{{ Nav::isResource('bundle') }}"><a href="{{url('bundle')}}"><i class="fa fa-server" aria-hidden="true"></i><span>{{ __('adminstaticword.BundleCourse') }}</span></a></li>

                  <li class="{{ Nav::isResource('courselang') }}"><a href="{{url('courselang')}}"><i class="flaticon-translation" aria-hidden="true"></i><span>{{ __('adminstaticword.CourseLanguage') }}</span></a></li>

                  <li class="{{ Nav::isResource('coursereview') }}"><a href="{{url('coursereview')}}"><i class="flaticon-rate" aria-hidden="true"></i><span>{{ __('adminstaticword.CourseReview') }}</span></a></li>
                  
                  @if($gsetting->assignment_enable == 1)
                  <li class="{{ Nav::isRoute('assignment.view') }}"><a href="{{route('assignment.view')}}"><i class="flaticon-computer" aria-hidden="true"></i><span>{{ __('adminstaticword.Assignment') }}</span></a></li>
                  @endif

                  <li class="{{ Nav::isResource('refundpolicy') }}"><a href="{{url('refundpolicy')}}"><i class="flaticon-rate" aria-hidden="true"></i><span>{{ __('adminstaticword.RefundPolicy') }}</span></a></li>

                  <li class="{{ Nav::isResource('batch') }}"><a href="{{url('batch')}}"><i class="flaticon-interface" aria-hidden="true"></i><span>{{ __('adminstaticword.Batch') }}</span></a></li>

                  <li class="{{ Nav::isRoute('quiz.review') }}"><a href="{{route('quiz.review')}}"><i class="flaticon-translation" aria-hidden="true"></i><span>{{ __('adminstaticword.QuizReview') }}</span></a></li>


                  <li class="{{ Nav::isResource('private-course') }}"><a href="{{url('private-course')}}"><i class="fa fa-bullseye" aria-hidden="true"></i><span>{{ __('adminstaticword.PrivateCourse') }}</span></a></li>



              </li>
            </ul>
          </li>

          @if(isset($gsetting) && $gsetting->attandance_enable == 1)

          <li class="{{ Nav::isResource('attandance') }}"><a href="{{url('attandance')}}"><i class="fa fa-user" aria-hidden="true"></i><span>{{ __('adminstaticword.Attandance') }}</span></a></li>

          @endif

          <li class="{{ Nav::isRoute('onesignal.settings') }}"><a href="{{route('onesignal.settings')}}"><i class="fa fa-location-arrow" aria-hidden="true"></i><span>{{ __('adminstaticword.PushNotification') }}</span></a></li>

          <li class="{{ Nav::isResource('coupon') }}"><a href="{{url('coupon')}}"><i class="flaticon-coupon" aria-hidden="true"></i><span>{{ __('adminstaticword.Coupon') }}</span></a></li>

          

          

          <li class="{{ Nav::isResource('plan/subscribe/settings') }} {{ Nav::isResource('subscription/plan') }} {{ Nav::isResource('orders/subscription') }} {{ Nav::isRoute('all.instructor') }} {{ Nav::isResource('requestinstructor') }} treeview">
           <a href="#">
             <i class="flaticon-teacher" aria-hidden="true"></i> <span>{{ __('adminstaticword.Instructors') }}</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              

              <li class="{{ Nav::isRoute('all.instructor') }}"><a href="{{route('all.instructor')}}"><i class="flaticon-customer"></i>{{ __('adminstaticword.All') }} {{ __('adminstaticword.InstructorRequest') }}</a></li>

              <li class="{{ Nav::isResource('requestinstructor') }}"><a href="{{url('requestinstructor')}}"><i class="flaticon-graduation"></i>{{ __('adminstaticword.Pending') }} {{ __('adminstaticword.InstructorRequest') }}</a></li>


              <li class="{{ Nav::isResource('plan/subscribe/settings') }}"><a href="{{url('plan/subscribe/settings')}}"><i class="fa fa-gears"></i>{{ __('adminstaticword.InstructorPlan') }} {{ __('adminstaticword.Setting') }}</a></li>
       

              @if(env('ENABLE_INSTRUCTOR_SUBS_SYSTEM') == 1)
              <li class="{{ Nav::isResource('subscription/plan') }}"><a href="{{url('subscription/plan')}}"><i class="fa fa-user-secret"></i>{{ __('adminstaticword.InstructorPlan') }}</a></li>

              <li class="{{ Nav::isResource('orders/subscription') }}"><a href="{{url('orders/subscription')}}"><i class="flaticon-graduation"></i>{{ __('adminstaticword.SubscribedInstructors') }}</a></li>

              @endif


              <li class="{{ Nav::isRoute('allrequestinvolve') }} {{ Nav::isRoute('involve.request.index') }} {{ Nav::isRoute('involve.request') }} treeview">
                <a href="#">
                  <i class="flaticon-test" aria-hidden="true"></i> <span>{{ __('adminstaticword.MultipleInstructor') }}</span>
                  <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li class="{{ Nav::isRoute('allrequestinvolve') }}"><a href="{{route('allrequestinvolve')}}"> <i class="flaticon-pending"></i>{{ __('adminstaticword.RequestToInvolve') }}</a></li>
                  <li class="{{ Nav::isRoute('involve.request.index') }}"><a href="{{route('involve.request.index')}}"><i class="flaticon-question" aria-hidden="true"></i>{{ __('adminstaticword.InvolvementRequests') }}</a></li>
                   <li class="{{ Nav::isRoute('involve.request') }}"><a href="{{route('involve.request')}}"><i class="flaticon-web-browser" aria-hidden="true"></i>{{ __('adminstaticword.InvolvedInCourse') }}</a></li>
                </ul>
              </li>


              <li class="{{ Nav::isRoute('instructor.settings') }} {{ Nav::isRoute('admin.instructor') }} {{ Nav::isRoute('admin.completed') }} treeview">
               <a href="#">
                 <i class="flaticon-payment" aria-hidden="true"></i> <span>{{ __('adminstaticword.InstructorPayout') }}</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li class="{{ Nav::isRoute('instructor.settings') }}"><a href="{{route('instructor.settings')}}"><i class="flaticon-settings-3"></i>{{ __('adminstaticword.PayoutSettings') }}</a></li>
                  <li class="{{ Nav::isRoute('admin.instructor') }}"><a href="{{route('admin.instructor')}}"><i class="flaticon-pending"></i>{{ __('adminstaticword.PendingPayout') }}</a></li>

                  <li class="{{ Nav::isRoute('admin.completed') }}"><a href="{{route('admin.completed')}}"><i class="flaticon-file"></i>{{ __('adminstaticword.CompletedPayout') }}</a></li>
                
                </ul>
              </li>


            </ul>
          </li>

          
          

          <li class="{{ Nav::isResource('order') }}"><a href="{{url('order')}}"><i class="flaticon-shopping-cart" aria-hidden="true"></i><span>{{ __('adminstaticword.Order') }}</span></a></li>
    
          <li class="{{ Nav::isResource('page') }}"><a href="{{url('page')}}"><i class="flaticon-computer" aria-hidden="true"></i><span>{{ __('adminstaticword.Pages') }}</span></a></li>

          <li class="{{ Nav::isResource('faq') }} {{ Nav::isResource('faqinstructor') }}  treeview">
           <a href="#">
             <i class="flaticon-faq" aria-hidden="true"></i> <span>{{ __('adminstaticword.Faq') }}</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="{{ Nav::isResource('faq') }}"><a href="{{url('faq')}}"><i class="flaticon-chat"></i>{{ __('adminstaticword.FaqStudent') }}</a></li>
              <li class="{{ Nav::isResource('faqinstructor') }}"><a href="{{url('faqinstructor')}}"><i class="flaticon-question"></i>{{ __('adminstaticword.FaqInstructor') }}</a></li>
            </ul>
          </li>
          

          <li class="{{ Nav::isResource('user/course/report') }} {{ Nav::isResource('user/question/report') }} treeview">
           <a href="#">
             <i class="flaticon-flag" aria-hidden="true"></i> <span>{{ __('adminstaticword.Report') }}</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="{{ Nav::isResource('admin/report/view') }}"><a href="{{url('admin/report/view')}}"><i class="flaticon-error"></i><span>{{ __('adminstaticword.Reported') }} Course</span></a></li>
              <li class="{{ Nav::isResource('user/question/report') }}"><a href="{{url('user/question/report')}}"><i class="flaticon-question-mark"></i><span>{{ __('adminstaticword.Reported') }} Question</span></a></li>
            </ul>
          </li>

          <li class="{{ Nav::isResource('slider') }} {{ Nav::isResource('facts') }} {{ Nav::isRoute('category.slider') }} {{ Nav::isResource('getstarted') }} {{ Nav::isResource('trusted') }} {{ Nav::isRoute('widget.setting') }} {{ Nav::isRoute('terms') }} {{ Nav::isResource('testimonial') }} {{ Nav::isResource('advertisement') }} {{ Nav::isResource('directory') }} treeview">
           <a href="#">
             <i class="flaticon-optimization" aria-hidden="true"></i> <span>{{ __('adminstaticword.FrontSetting') }}</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="{{ Nav::isResource('slider') }}"><a href="{{url('slider')}}"><i class="flaticon-slider-tool"></i><span>{{ __('adminstaticword.Slider') }}</span></a></li>
              <li class="{{ Nav::isResource('facts') }}"><a href="{{url('facts')}}"><i class="flaticon-project-management"></i><span>{{ __('adminstaticword.FactsSlider') }}</span></a></li>
              <li class="{{ Nav::isRoute('category.slider') }}"><a href="{{route('category.slider')}}"><i class="flaticon-interface"></i><span>{{ __('adminstaticword.CategorySlider') }}</span></a></li>
              <li class="{{ Nav::isResource('getstarted') }}"><a href="{{url('getstarted')}}"><i class="flaticon-shuttle"></i>{{ __('adminstaticword.GetStarted') }}</a></li>
              <li class="{{ Nav::isResource('trusted') }}"><a href="{{url('trusted')}}"><i class="flaticon-sliders"></i><span>{{ __('adminstaticword.TrustedSlider') }}</span></a></li>
              <li class="{{ Nav::isRoute('widget.setting') }}"><a href="{{route('widget.setting')}}"><i class="flaticon-real-state"></i>{{ __('adminstaticword.WidgetSetting') }}</a></li>
              <li class="{{ Nav::isResource('testimonial') }}"><a href="{{url('testimonial')}}"><i class="flaticon-customer-1"></i>{{ __('adminstaticword.Testimonial') }}</a></li>

              <li class="{{ Nav::isResource('advertisement') }}"><a href="{{url('advertisement')}}"><i class="fa fa-object-group" aria-hidden="true"></i>{{ __('adminstaticword.Advertisement') }}</a></li>

              <li class="{{ Nav::isResource('directory') }}"><a href="{{url('directory')}}"><i class="flaticon-digital-marketing" aria-hidden="true"></i><span>{{ __('adminstaticword.Seo') }} {{ __('adminstaticword.Directory') }}</span></a></li>

              
            </ul>
          </li>
          
          <li class="{{ Nav::isRoute('gen.set') }} {{ Nav::isRoute('api.setApiView') }} {{ Nav::isResource('blog') }} {{ Nav::isRoute('about.page') }} {{ Nav::isRoute('careers.page') }} {{ Nav::isRoute('comingsoon.page') }} {{ Nav::isRoute('termscondition') }} {{ Nav::isRoute('policy') }} {{ Nav::isRoute('bank.transfer') }} {{ Nav::isRoute('show.pwa') }} {{ Nav::isRoute('adsense') }} {{ Nav::isRoute('ipblock.view') }} {{ Nav::isRoute('whatsapp.button') }} {{ Nav::isRoute('coloroption.view') }} {{ Nav::isResource('manualpayment') }} {{ Nav::isRoute('twilio.settings') }} {{ Nav::isRoute('show.sitemap') }} {{ Nav::isRoute('get.api.key') }} {{ Nav::isRoute('show.lang') }}  treeview">
           <a href="#">
             <i class="flaticon-tools" aria-hidden="true"></i> <span>{{ __('adminstaticword.SiteSetting') }}</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="{{ Nav::isRoute('gen.set') }}"><a href="{{route('gen.set')}}"><i class="flaticon-admin"></i><span>{{ __('adminstaticword.Setting') }}</span></a></li>
              <li class="{{ Nav::isRoute('api.setApiView') }}"><a href="{{route('api.setApiView')}}"><i class="flaticon-report"></i>{{ __('adminstaticword.APISetting') }}</a></li>

              @if(Module::has('MPesa') && Module::find('MPesa')->isEnabled())
                  @include('mpesa::admin.sidebar')

              @endif
              
              <li class="{{ Nav::isResource('blog') }}"><a href="{{url('blog')}}"><i class="flaticon-real-state"></i>{{ __('adminstaticword.Blog') }}</a></li>
              <li class="{{ Nav::isRoute('about.page') }}"><a href="{{route('about.page')}}"><i class="flaticon-book"></i>{{ __('adminstaticword.About') }}</a></li>
              <li class="{{ Nav::isRoute('careers.page') }}"><a href="{{route('careers.page')}}"><i class="flaticon-mobile-marketing"></i>{{ __('adminstaticword.Career') }}</a></li>
              <li class="{{ Nav::isRoute('comingsoon.page') }}"><a href="{{route('comingsoon.page')}}"><i class="flaticon-fast-time"></i>{{ __('adminstaticword.ComingSoon') }}</a></li>
              <li class="{{ Nav::isRoute('termscondition') }}"><a href="{{route('termscondition')}}"><i class="flaticon-terms-and-conditions"></i>{{ __('adminstaticword.Terms&Condition') }} </a></li>
              <li class="{{ Nav::isRoute('policy') }}"><a href="{{route('policy')}}"><i class="flaticon-smartphone"></i> {{ __('adminstaticword.PrivacyPolicy') }}</a></li>

              <li class="{{ Nav::isRoute('bank.transfer') }}"><a href="{{route('bank.transfer')}}"><i class="flaticon-bank"></i> {{ __('adminstaticword.BankDetails') }}</a></li>

              <li class="{{ Nav::isRoute('show.pwa') }}"><a href="{{route('show.pwa')}}"><i class="flaticon-mobile-marketing" aria-hidden="true"></i><span> {{ __('adminstaticword.PWASetting') }}</span></a></li>
              <li class="{{ Nav::isRoute('adsense') }}"><a href="{{url('/admin/adsensesetting')}}" title="Adsense Setting"><span><i class="flaticon-settings-3"></i> {{ __('adminstaticword.AdsenseSetting') }}</span></a></li>
              
              @if(isset($gsetting) && $gsetting->ipblock_enable == 1)
              <li class="{{ Nav::isRoute('ipblock.view') }}"><a href="{{url('admin/ipblock')}}" title="IPBlock Setting"><span><i class="flaticon-error"></i> {{ __('adminstaticword.IPBlockSettings') }}</span></a></li>
              @endif


              <li class="{{ Nav::isRoute('whatsapp.button') }}"><a href="{{route('whatsapp.button')}}" title="Whatsapp Button Setting"><span><i class="fa fa-comment-o" aria-hidden="true"></i>&emsp; {{ __('adminstaticword.WhatsappButtonSetting') }}</span></a></li>

              <li class="{{ Nav::isRoute('coloroption.view') }}"><a href="{{url('admin/coloroption')}}" title="Color Options"><span><i class="fa fa-cube" aria-hidden="true"></i>&emsp;{{ __('adminstaticword.ColorSettings') }}</span></a></li>

              <li class="{{ Nav::isResource('manualpayment') }}"><a href="{{url('manualpayment')}}" title="Manual Payment Gateway"><span><i class="fa fa-file" aria-hidden="true"></i>&emsp;{{ __('adminstaticword.ManualPaymentGateway') }}</span></a></li>

              <li class="{{ Nav::isRoute('twilio.settings') }}"><a href="{{route('twilio.settings')}}" title="Twilio Settings"><span><i class="fa fa-comment-o" aria-hidden="true"></i>&emsp; {{ __('adminstaticword.TwilioSettings') }}</span></a></li>

              <li class="{{ Nav::isRoute('show.sitemap') }}"><a href="{{route('show.sitemap')}}"><i class="flaticon-location" aria-hidden="true"></i><span>{{ __('adminstaticword.SiteMap') }}</span></a></li>

              <li class="{{ Nav::isRoute('get.api.key') }}"><a href="{{route('get.api.key')}}"><i class="flaticon-test" aria-hidden="true"></i><span>{{ __('adminstaticword.GetAPIKeys') }}</span></a></li>

              <li class="{{ Nav::isRoute('show.lang') }}"><a href="{{route('show.lang')}}"><i class="flaticon-translation" aria-hidden="true"></i><span>{{ __('adminstaticword.Language') }}</span></a></li>

              <li class="{{ Nav::isRoute('maileclipse/mailables') }}"><a href="{{ url('maileclipse/mailables') }}"><i class="fa fa-clone" aria-hidden="true"></i><span>{{ __('adminstaticword.EmailSettings') }}{{ __('') }}</span></a></li>
             

            </ul>
          </li>

          <li class="{{ Nav::isRoute('player.set') }} {{ Nav::isRoute('ads') }} {{ Nav::isRoute('ad.setting') }} treeview">
           <a href="#">
             <i class="flaticon-video" aria-hidden="true"></i> <span>{{ __('adminstaticword.PlayerSettings') }}</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              <li class="{{ Nav::isRoute('player.set') }}"><a href="{{route('player.set')}}"><i class="flaticon-digital-marketing"></i> {{ __('adminstaticword.PlayerCustomization') }}</a></li>

              <li class="{{ Nav::isRoute('ads') }}"><a href="{{url('admin/ads')}}" title="Create ad"><i class="flaticon-video-advertising"></i>{{ __('adminstaticword.Advertise') }}</a></li>
              @php $ads = App\Ads::all(); @endphp
              @if($ads->count()>0)
              <li class="{{ Nav::isRoute('ad.setting') }}"><a href="{{url('admin/ads/setting')}}" title="Ad Settings"><i class="flaticon-project-management"></i>{{ __('adminstaticword.AdvertiseSettings') }}</a></li>
              @endif

            </ul>
          </li>


          <li class="{{ Nav::isResource('usermessage') }}"><a href="{{url('usermessage')}}"><i class="flaticon-phone-book" aria-hidden="true"></i><span>{{ __('adminstaticword.ContactUs') }}</span></a></li>

          

          @if(isset($gsetting) && $gsetting->activity_enable == '1')
            
          <li class="{{ Nav::isRoute('activity.index') }}"><a href="{{route('activity.index')}}"><i class="fa fa-clone" aria-hidden="true"></i><span>{{ __('adminstaticword.ActivityLog') }}</span></a></li>

          @endif

          @if(Module::has('Wallet') && Module::find('Wallet')->isEnabled())
              @include('wallet::admin.sidebar_menu')

          @endif

          @if(Module::has('Certificate') && Module::find('Certificate')->isEnabled())
              @include('certificate::admin.sidebar_menu')

          @endif


          <li class="{{ Nav::isRoute('admin.revenue.report') }} {{ Nav::isRoute('instructor.revenue.report') }} treeview">
           <a href="#">
             <i class="flaticon-project-management" aria-hidden="true"></i> <span>{{ __('adminstaticword.Revenue') }} {{ __('adminstaticword.Report') }}</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="{{ Nav::isRoute('admin.revenue.report') }}"><a href="{{route('admin.revenue.report')}}"><i class="fa fa-crosshairs"></i> {{ __('adminstaticword.AdminRevenue') }}</a></li>

              <li class="{{ Nav::isRoute('instructor.revenue.report') }}"><a href="{{route('instructor.revenue.report')}}"><i class="fa fa-ioxhost"></i> {{ __('adminstaticword.InstructorRevenue') }}</a></li>


            </ul>
          </li>


          <li class="{{ Nav::isRoute('import.view') }} {{ Nav::isRoute('database.backup') }} {{ Nav::isRoute('update.process') }} {{ Nav::isRoute('quick.update') }} treeview">
           <a href="#">
             <i class="flaticon-faq" aria-hidden="true"></i> <span>{{ __('adminstaticword.Help&Support') }}</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="{{ Nav::isRoute('import.view') }}"><a href="{{route('import.view')}}"><i class="fa fa-crosshairs"></i> {{ __('adminstaticword.ImportDemo') }}</a></li>

              <li class="{{ Nav::isRoute('database.backup') }}"><a href="{{route('database.backup')}}"><i class="fa fa-ioxhost"></i> {{ __('adminstaticword.DatabaseBackup') }}</a></li>

              <li class="{{ Nav::isRoute('update.process') }}"><a href="{{route('update.process')}}"><i class="fa fa-bullseye" aria-hidden="true"></i><span>{{ __('adminstaticword.UpdateProcess') }}</span></a></li>

              <li class="{{ Nav::isRoute('quick.update') }}"><a href="{{route('quick.update')}}"><i class="fa fa-spinner" aria-hidden="true"></i><span>{{ __('adminstaticword.QuickUpdate') }}</span></a></li>

              <li class="{{ Nav::isRoute('remove.public') }}"><a href="{{route('remove.public')}}"><i class="fa fa-comment-o" aria-hidden="true"></i><span>{{ __('adminstaticword.RemovePublic') }}</span></a></li>

              <li class="{{ Nav::isRoute('clear-cache') }}"><a href="{{url('clear-cache')}}"><i class="fa fa-clone" aria-hidden="true"></i><span>{{ __('adminstaticword.ClearCache') }}</span></a></li>

              <li class="{{ Nav::isResource('admin/addon') }}"><a href="{{url('admin/addon')}}"><i class="flaticon-real-state" aria-hidden="true"></i><span>{{ __('adminstaticword.Addon') }} {{ __('adminstaticword.Manager') }}</span></a></li>

            </ul>
          </li>
          

        </ul>
      @endif


    </section>
    <!-- /.sidebar -->
</aside>