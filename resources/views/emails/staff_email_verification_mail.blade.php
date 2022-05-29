@component('mail::message')
# **Staff Email Verification Email**

Dear **{{ $user->first_name }}**,<br>
Your profile was successfully created as a **Staff User** on the **PWAN Platinum** website. kindly click on the link below to verify your email address. <br>


@component('mail::button', ['url' => $url.'/staff-email-confirmation?token='.$conf->token])
Verify Your Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
