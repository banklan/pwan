@component('mail::message')
# Your profile has been authorized and ready to use!

Dear {{ $admin->fullname }}, your **admin** profile on www.pwan-platinum.com.ng has been fully set up.<br>
You can now log in on {{ $url }}.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
