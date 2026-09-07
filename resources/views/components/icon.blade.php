@props([
    'name' => 'layers',
])

@php
    $paths = [
        'code' => '<path d="M8 8 4 12l4 4M16 8l4 4-4 4M14 4l-4 16"/>',
        'globe' => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a14 14 0 0 1 0 18M12 3a14 14 0 0 0 0 18"/>',
        'layers' => '<path d="m12 3 9 5-9 5-9-5 9-5ZM3 12l9 5 9-5M3 16l9 5 9-5"/>',
        'share' => '<circle cx="18" cy="5" r="2.5"/><circle cx="6" cy="12" r="2.5"/><circle cx="18" cy="19" r="2.5"/><path d="M8.2 13.2 15.8 17.8M15.8 6.2 8.2 10.8"/>',
        'database' => '<ellipse cx="12" cy="6" rx="7" ry="3"/><path d="M5 6v6c0 1.7 3.1 3 7 3s7-1.3 7-3V6M5 12v6c0 1.7 3.1 3 7 3s7-1.3 7-3v-6"/>',
        'cpu' => '<rect x="7" y="7" width="10" height="10" rx="1"/><path d="M9 1v3M15 1v3M9 20v3M15 20v3M1 9h3M1 15h3M20 9h3M20 15h3"/>',
        'wrench' => '<path d="M14.7 6.3a4 4 0 0 0-5.4 5.4L3 18l3 3 6.3-6.3a4 4 0 0 0 5.4-5.4L15 12l-3-3 2.7-2.7Z"/>',
        'headset' => '<path d="M4 13v3a2 2 0 0 0 2 2h1v-7H6a2 2 0 0 0-2 2Zm13-2h1a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1ZM4 13a8 8 0 0 1 16 0"/><path d="M19 18v1a3 3 0 0 1-3 3h-2"/>',
        'search' => '<circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>',
        'monitor' => '<rect x="3" y="4" width="18" height="12" rx="1"/><path d="M8 20h8M12 16v4"/>',
        'map' => '<path d="M9 4 3 6v14l6-2 6 2 6-2V4l-6 2-6-2Z"/><path d="M9 4v14M15 6v14"/>',
        'sliders' => '<path d="M4 21v-7M4 10V3M12 21v-9M12 8V3M20 21v-5M20 12V3M1 14h6M9 8h6M17 16h6"/>',
        'clipboard' => '<rect x="7" y="4" width="10" height="16" rx="1"/><path d="M9 4V3h6v1"/>',
        'smartphone' => '<rect x="7" y="2" width="10" height="20" rx="2"/><path d="M11 18h2"/>',
        'tablet' => '<rect x="4" y="3" width="16" height="18" rx="2"/><path d="M11 17h2"/>',
        'building' => '<path d="M4 21V5l8-2 8 2v16M4 21h16M9 9h.01M15 9h.01M9 13h.01M15 13h.01M9 17h.01M15 17h.01"/>',
        'factory' => '<path d="M3 21h18M5 21V10l5 4V10l5 4V8h4v13"/>',
        'compass' => '<circle cx="12" cy="12" r="9"/><path d="m16 8-2.5 6.5L7 17l2.5-6.5L16 8Z"/>',
        'menu' => '<path d="M4 7h16M4 12h16M4 17h16"/>',
    ];
@endphp

<svg {{ $attributes->merge(['class' => 'h-5 w-5', 'viewBox' => '0 0 24 24', 'fill' => 'none', 'xmlns' => 'http://www.w3.org/2000/svg']) }} aria-hidden="true">
    <g stroke="currentColor" stroke-width="1.6" stroke-linecap="square" stroke-linejoin="miter">
        {!! $paths[$name] ?? $paths['layers'] !!}
    </g>
</svg>
