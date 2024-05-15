@component('mail::message')
Hello {{$user['fname']}} {{$user['lname']}} 

Your Password Reset Code is : {{$code}} <br>

{{ __('Have fun!')}}<br>
{{ config('app.name') }}
@endcomponent