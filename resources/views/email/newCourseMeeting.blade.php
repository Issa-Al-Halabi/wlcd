@component('mail::message')
# Welcome, {{$user['fname']}} !!

A new meeting class : <b>{{ $googlemeet->meeting_title }}</b>, 
has been added to the course : <br>
<b>{{$course['title']}}</b>. <br>
The meeting will start at {{ $googlemeet->start_time->format('Y-m-d H:i') }} <br>
Check it out.
@component('mail::button', ['url' => 'https://wlcd.academy/course-content/' . $course['id']])
Click Here
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
