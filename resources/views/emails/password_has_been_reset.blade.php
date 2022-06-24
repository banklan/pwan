@component('mail::message')
# Your password has been reset!

Dear <strong>{{ $user->fullname }}</strong>,
Your password has been reset successfully. <br>
You can now log into your account.
Thank you.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
