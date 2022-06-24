@component('mail::message')
# An enquiry has been received!

An enquiry has been received on pwan-platinum.com, sent by {{ $enquiry->fullname }}.<br/>
<p style="font-size: 16px; margin-top: 15px"><strong>Sender: </strong><span style="padding-left:20px"> {{ $enquiry->fullname }}</span></p>
<p style="font-size: 16px;"><strong>Organization: </strong><span style="padding-left:20px"> {{ $enquiry->organization }}</span></p>
<p style="font-size: 16px;"><strong>Position: </strong> <span style="padding-left:20px">{{ $enquiry->position }}</span></p>
<p style="font-size: 16px;"><strong>Email: </strong><span style="padding-left:20px"> {{ $enquiry->email }}</span></p>
<p style="font-size: 16px;"><strong>Phone: </strong> <span style="padding-left:20px">{{ $enquiry->phone }}</span></p>
<p style="font-size: 16px;"><strong>Subject: </strong><span style="padding-left:20px"> {{ $enquiry->subject }}</span></p>
<p style="font-size: 16px;"><strong>Enquiry:</strong> </p>
<p style="font-size: 16px; padding: 10px">{{ $enquiry->message }}</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
