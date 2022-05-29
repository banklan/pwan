@component('mail::message')
# Your subscription form was received by PWAN Platinum!

Dear {{ $sub->surname }},
We are excited to receive your completed subscription form at PWAN Platinum.
Be rest assured that your request is receiving the utmost attention. One of our executives will contact you very soon.
Thank you for choosing PWAN Platinum.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
