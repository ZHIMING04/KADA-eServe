@component('mail::message')
# Selamat Datang ke Koperasi Kami

Kepada {{ $user->name }},

Akaun keahlian anda telah dicipta. Sila gunakan maklumat berikut untuk log masuk:

Emel: {{ $user->email }}
Kata Laluan Sementara: {{ $tempPassword }}

Sila tekan butang di bawah untuk log masuk

@component('mail::button', ['url' => route('verification.notice')])
KADA-eServe
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent 