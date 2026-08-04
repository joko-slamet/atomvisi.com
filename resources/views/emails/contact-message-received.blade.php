<x-mail::message>
# Pesan Kontak Baru

Anda menerima pesan baru melalui form kontak website Atom Visi Indonesia.

**Nama:** {{ $contactMessage->name }}
**Email:** {{ $contactMessage->email }}
@if ($contactMessage->phone)
**Telepon:** {{ $contactMessage->phone }}
@endif
@if ($contactMessage->subject)
**Subjek:** {{ $contactMessage->subject }}
@endif

**Pesan:**

{{ $contactMessage->message }}

<x-mail::button :url="url('/admin/contact-messages/'.$contactMessage->id.'/edit')">
Lihat di Admin Panel
</x-mail::button>

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
