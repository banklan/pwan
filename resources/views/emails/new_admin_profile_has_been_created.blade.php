@component('mail::message')
# New Admin has been created!

This is an auto-email to notify all admins on the PWANPlatinum platform that a new admin (user with administrative priviledges) have been created.
The details is as follow:<br>

NAME OF NEW ADMIN: {{ $admin->fullname }}.
EMAIL OF NEW ADMIN: {{ $admin->email }}.
New Admin was created by: {{ $admin->creator->fullname }}.
New Admin was authorized by: {{ $admin->authorizer->fullname }}.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
