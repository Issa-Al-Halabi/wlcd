@component('mail::message')
# Welcome, {{$user['fname']}}.

You have been successfully Enrolled in the course : <br>
{{$course['title']}}. 

Check it out.
@component('mail::button', ['url' => 'https://wlcd.academy/course-details/' . $course['id']])
Click Here
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
