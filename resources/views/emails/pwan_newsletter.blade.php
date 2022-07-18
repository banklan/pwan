@component('mail::message')
# {{ $newsletter->subject }}


{{ $newsletter->body }}.

{{ $newsletter->closing }}.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
