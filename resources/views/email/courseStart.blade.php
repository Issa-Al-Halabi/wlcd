@component('mail::message')
# Welcome, {{$user['fname']}} !!

{{$course['title']}}
course will start tomorrow !! <br>

Get ready.
@component('mail::button', ['url' => 'https://wlcd.academy/course-details/' . $course['id']])
Click Here
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
