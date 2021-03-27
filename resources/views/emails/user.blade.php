@component('mail::message')
# {{$msg->subject}} vial {{ config('app.name') }}

{{$msg->text_content}}

Thanks,<br>
{{ config('app.name') }} Team
@endcomponent
