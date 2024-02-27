@component('mail::message')
Hello {{$user->name}},<br>
{!!$user->send_message!!}
<br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent