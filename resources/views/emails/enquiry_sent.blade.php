@component('mail::message')
# Thank you for dropping a message!

Dear {{ $enquiry->fullname }},<br>
We have received your enquiry titled <strong>{{ $enquiry->subject }}</strong> at PWAN-platinum.<br>
One of our executives will reach out to you soon.<br>
Thank you for contacting us.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
