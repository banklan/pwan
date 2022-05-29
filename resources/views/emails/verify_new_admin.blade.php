@component('mail::message')
# **New Admin Email Verification Email**

Dear **{{ $user->first_name }}**,<br>
Your profile was set up as an **Admin** on the **PWAN Platinum** website. kindly click on the link below to verify your email address. <br>


@component('mail::button', ['url' => $url.'/admin-email-confirmation?token='.$conf->token])
Verify Your Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
