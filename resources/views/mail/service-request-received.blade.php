<x-mail::message>
# Neue Serviceanfrage

Eine neue Anfrage ist über die Website eingegangen.

**Name:** {{ $serviceRequest->name }}  
**Unternehmen:** {{ $serviceRequest->company ?: '–' }}  
**E-Mail:** {{ $serviceRequest->email }}  
**Telefon:** {{ $serviceRequest->phone ?: '–' }}  
**Kategorie:** {{ $serviceRequest->category?->translated('name', 'de') ?: '–' }}  
**Leistung:** {{ $serviceRequest->service?->translated('name', 'de') ?: '–' }}  
**Sprache:** {{ $serviceRequest->locale?->label() ?? $serviceRequest->locale?->value }}  
**Status:** {{ $serviceRequest->status->label() }}

**Nachricht:**  
{{ $serviceRequest->message }}

Diese Nachricht wurde automatisch erzeugt.
</x-mail::message>
