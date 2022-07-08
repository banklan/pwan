@component('mail::message')
# new Staff Account Has Been Created!

This is a mail notifying all administrators on the Pwan-Platinum platinum that a new staff account has been created.<br>
The new staff is {{ $user->fullname }}.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
