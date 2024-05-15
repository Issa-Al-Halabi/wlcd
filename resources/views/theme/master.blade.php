<!DOCTYPE html>
<!--
**********************************************************************************************************
    Copyright (c) 2021.
**********************************************************************************************************  -->
<!--
Template Name: eClass - Learning Management System
Version: 4.7.0
Author: Media City
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]> -->

<?php
$language = Session::get('changed_language'); //or 'english' //set the system language
$rtl = ['ar', 'he', 'ur', 'arc', 'az', 'dv', 'ku', 'fa']; //make a list of rtl languages
?>

<html lang="en" @if (in_array($language, $rtl)) dir="rtl" @endif>
<!-- <![endif]-->
<!-- head -->

<head>
    @include('theme.head')
</head>
@if ($gsetting->cookie_enable == '1')
    @include('cookieConsent::index')
@endif
<!-- end head -->
<!-- body start-->

<body>
    @if (env('GOOGLE_TAG_MANAGER_ENABLED') == 'true' && env('GOOGLE_TAG_MANAGER_ID') == !null)
        @include('googletagmanager::body')
    @endif
    <!-- preloader -->

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($gsetting->preloader_enable == 1)

        <div class="preloader">
            <div class="status">
                @if (isset($gsetting->preloader_logo))
                    <div class="status-message">
                        
                        <img src="{{ asset('images/logo/logo_green.png') }}" alt="logo" class="img-fluid image-position"
                            width="20%">
                        <div id="bars6">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    @endif
    <!-- whatsapp chat button -->
    <div id="myButton"></div>


    @php
        if (isset(Auth::user()->orders)) {
            //Run User Enroll expire background process
            App\Jobs\EnrollExpire::dispatchNow();
        }
        
        if (env('ENABLE_INSTRUCTOR_SUBS_SYSTEM') == 1) {
            if (isset(Auth::user()->plans)) {
                //Run User Plan Subscription expire background process
                App\Jobs\InstructorPlan::dispatchNow();
            }
        }
    @endphp
    <!-- end preloader -->
    <!-- top-nav bar start-->
    @include('theme.nav')
    <!-- top-nav bar end-->
    <!-- home start -->
    @yield('content')
    <!-- testimonial end -->
    <!-- footer start -->
    @include('theme.footer')
    <!-- footer end -->
    <!-- jquery -->
    @include('theme.scripts')
    <!-- end jquery -->
</body>
<!-- body end -->

</html>

<style>
    /* * {
 border: 0;
 box-sizing: border-box;
 margin: 0;
 padding: 0;
} */
    /* :root {
 --hue: 223;
 --bg: hsl(var(--hue),90%,90%);
 --fg: hsl(var(--hue),90%,10%);
 --trans-dur: 0.3s;
 font-size: calc(20px + (30 - 20) * (100vw - 320px) / (1280 - 320));
}
body {
 background: var(--bg);
 color: var(--fg);
 font: 1em/1.5 sans-serif;
 height: 100vh;
 display: grid;
 place-items: center;
} */

    .status-message {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .image-position {
        position: absolute;
        /*top: 50%;*/
    }



   
    /** END of bars6 */
</style>
