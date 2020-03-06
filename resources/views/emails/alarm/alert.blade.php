@component('mail::message')
# <span style="color: #ff0000;">Alert!!!</span>

Hello,
Trust this meets you well.
This is to inform you that the sensor below requires attention:
<br />
<b>Sensor:</b> {{ $device->sensor_name }}
<br />
<b>Sensor ID:</b> {{ $device->sensor_id }}
<br />
<b>Alarm Time:</b> {{ date('Y-m-d H:i:s') }}
<br />
<br />
Please click the button below to login to your dashboard.

<br />
<br />
<b>Current reading:</b> {{ $reading }}

<h4 align="center"><u>Thresholds</u></h4>
<b>Min Threshold:</b> {{ $min_threshold }}
<br />
<b>Max Threshold:</b> {{ $max_threshold }}

<br />

@component('mail::button', ['url' => route('acknowledge', [$device->sensor_id, $reading, $min_threshold, $max_threshold])])
Acknowledge Alarm
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
