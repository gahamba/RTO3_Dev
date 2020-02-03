@component('mail::message')
# <span style="color: #ff0000;">Alert!!!</span>

Hello,
Trust this meets you well.
Your sensor: {{ $device->sensor_name }}, Sensor ID: {{ $device->sensor_id }}
This is to inform you that your sensor requires urgent attention.
Please click the button below to login to your dashboard.

@component('mail::button', ['url' => route('home')])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
