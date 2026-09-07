<x-mail::message>
# Neue Serviceanfrage

Eine neue Anfrage ist über die Website eingegangen.

**Name:** {{ $serviceRequest->name }}  
**Unternehmen:** {{ $serviceRequest->company ?: '–' }}  
**E-Mail:** {{ $serviceRequest->email }}  
**Telefon:** {{ $serviceRequest->phone ?: '–' }}  
**Sprache:** {{ $serviceRequest->locale->value }}  
**Status:** {{ $serviceRequest->status->value }}

**Nachricht:**  
{{ $serviceRequest->message }}

Diese Nachricht wurde automatisch erzeugt.
</x-mail::message>
