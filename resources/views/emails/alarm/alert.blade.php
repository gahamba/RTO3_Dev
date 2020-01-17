@component('mail::message')
# Introduction

Hello,
Trust this meets you well.
This is to inform you that your sensor requires urgent attention.
Please click the button below to login to your dashboard.

@component('mail::button', ['url' => route('home')])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
