@component('mail::message')
# Welcome, {{$user['fname']}} !!

The meeting class : <b>{{ $googlemeet->meeting_title }}</b>, 
in course : <br>
<b>{{$course['title']}}</b>, has been changed. <br>
The meeting will start at {{ $googlemeet->start_time }} <br>
Check it out.
@component('mail::button', ['url' => 'https://wlcd.academy/course-content/' . $course['id']])
Click Here
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
