@component('mail::message')
# Password Reset Request!

Dear <strong>{{ $user->fullname }}</strong>,
You are seeing this email because we received a password reset request from you, for your account at www.pwan-platinum.com.<br>
If you did not make this request, just ignore this email.
If the request was made by you, Kindly click the link below.


@component('mail::button', ['url' => 'https://www.pwan-platinum.com.ng/password-reset?token='.$req->token])
Reset Link
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
