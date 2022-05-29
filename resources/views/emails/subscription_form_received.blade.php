@component('mail::message')
# A Subscription form has been received!

A subscription form sent by {{ $sub->surname.' '.$sub->other_names }} has been received.

@component('mail::table')

@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
