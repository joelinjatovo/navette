@component('mail::message')
# Message de support

Un client a demandé un support.

{{ $object }}<br>
{{ $content }}

Merci,<br>
{{ config('app.name') }}
@endcomponent
