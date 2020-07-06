@component('mail::message')
# Message de support

Un client a demandé un support.

Object: {{ $object }}<br>
Message: {{ $content }}

Merci,<br>
{{ config('app.name') }}
@endcomponent
