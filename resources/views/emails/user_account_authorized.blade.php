@component('mail::message')
# Your profile has been authorized!

Dear **{{ $user->first_name }}**,<br>
Your profile has been authorized and successfully set-up as a **Staff User** on the PWAN-platinum platform.
Click on the link below to login.

@component('mail::button', ['url' => $url, 'color' => 'success'])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
