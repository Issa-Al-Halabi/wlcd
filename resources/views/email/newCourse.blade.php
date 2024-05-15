@component('mail::message')
# Welcome, {{$user['fname']}} !!

A new course has been added to our academy : <br>
{{$course['title']}}. 

Check it out.
@component('mail::button', ['url' => 'https://wlcd.academy/course-details/' . $course['id']])
Click Here
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
