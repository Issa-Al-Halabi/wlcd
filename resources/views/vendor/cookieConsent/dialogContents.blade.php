
@php
if(Schema::hasTable('color_options')){
  $color = App\ColorOption::first();
}
@endphp
@if(isset($color))

<style type="text/css">
  
  :root {
  --linear-gradient-bg-color:linear-gradient(-45deg, {{ $color['linear_bg_one'] }} 0, {{ $color['linear_bg_two'] }} 100%);
  --linear-gradient-reverse-bg-color:linear-gradient(-45deg, {{ $color['linear_reverse_bg_one'] }} 0, {{ $color['linear_reverse_bg_two'] }} 100%);
  --linear-gradient-about-bg-color:linear-gradient(197.61deg, {{ $color['linear_about_bg_one'] }} , {{ $color['linear_about_bg_two'] }});
  --linear-gradient-about-blue-bg-color:linear-gradient(40deg, {{ $color['linear_about_bluebg_one'] }} 33%, {{ $color['linear_about_bluebg_two'] }} 84%);
  --linear-gradient-career-bg-color:linear-gradient(22.72914987deg, {{ $color['linear_career_bg_one'] }} 4%, {{ $color['linear_career_bg_two'] }});
  --background-blue-bg-color: {{ $color['blue_bg'] }};
  --background-red-bg-color: {{ $color['red_bg'] }}; 
  --background-grey-bg-color:{{ $color['grey_bg'] }};
  --background-light-grey-bg-color:{{ $color['light_grey_bg'] }};
  --background-black-bg-color:{{ $color['black_bg'] }};
  --background-white-bg-color:{{ $color['white_bg'] }};
  --background-mehroon-bg-color:{{ $color['dark_red_bg'] }};
  --text-black-color:{{ $color['black_text'] }};
  --text-light-grey-color:{{ $color['light_grey_text'] }};
  --text-dark-grey-color:{{ $color['dark_grey_text'] }};
  --text-red-color:{{ $color['red_text'] }};
  --text-blue-color:{{ $color['blue_text'] }};
  --text-dark-blue-color:{{ $color['dark_blue_text'] }};
  --text-white-color:{{ $color['white_text'] }};
}
</style>

@else

<style type="text/css">
 :root {

  --linear-gradient-bg-color:linear-gradient(-45deg, #F44A4A 0, #6E1A52 100%);
  --linear-gradient-reverse-bg-color:linear-gradient(-45deg, #6E1A52 0,#F44A4A 100%);
  --linear-gradient-about-bg-color:linear-gradient(197.61deg,#F44A4A,#6E1A52);
  --linear-gradient-about-blue-bg-color:linear-gradient(40deg,#1A263A 33%,#4A8394 84%);
  --linear-gradient-career-bg-color:linear-gradient(22.72914987deg,#F5C252 4%,#6AC1D0);
  --background-blue-bg-color: #0284A2;
  --background-red-bg-color:#F44A4A; 
  --background-grey-bg-color:#F7F8FA;
  --background-light-grey-bg-color:#F9F9F9;
  --background-black-bg-color:#29303B;
  --background-white-bg-color:#FFF;
  --background-mehroon-bg-color:#992337;
  --text-black-color:#29303B;
  --text-light-grey-color:#777;
  --text-red-color:#F44A4A;
  --text-dark-grey-color:#686F7A; 
  --text-blue-color:#0284A2;
  --text-dark-blue-color:#003845;
  --text-white-color:#FFF;
}

</style>

@endif

<style>
    #cookieWrapper {
        position: fixed;
        bottom: 0;
        width: 100%;
        z-index: 100;
        margin: 0;
        border-radius: 0;
        background-color: #007b4e !important;
    }

    .bg-primary {
	    background-color: var(--background-blue-bg-color) !important;
	}
	.btn-warning {
	    background-color: var(--background-red-bg-color)!important;
	    border: 1px solid var(--background-red-bg-color)!important;
	    color: var(--text-white-color);
	}
    .cookie-consent__message {
        color: var(--text-white-color);
    }
</style>



<div id="cookieWrapper" class="bg-primary text-white w-100 py-3 text-center cookierbar js-cookie-consent cookie-consent">
    <span class="cookie-consent__message">
        {!! trans('cookieConsent::texts.message') !!}&nbsp;&nbsp;
    </span>
    <button class="btn btn-sm btn-warning js-cookie-consent-agree cookie-consent__agree">
        {{ trans('cookieConsent::texts.agree') }}
    </button>
</div>
