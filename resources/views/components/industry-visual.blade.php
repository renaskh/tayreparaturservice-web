@props([
    'kind' => 'tech',
])

<svg {{ $attributes->merge(['viewBox' => '0 0 640 400', 'fill' => 'none', 'xmlns' => 'http://www.w3.org/2000/svg']) }} aria-hidden="true">
    <g class="stroke-white/12" stroke-width="0.8">
        @for ($i = 0; $i <= 12; $i++)
            <path d="M{{ $i * 54 }} 0v400" />
        @endfor
    </g>
    @switch($kind)
        @case('tech')
            <g class="stroke-signal/70" stroke-width="1.3">
                <rect x="90" y="70" width="180" height="240" />
                <rect x="310" y="110" width="220" height="200" />
                <path d="M90 150h180M310 190h220" />
            </g>
        @break
        @case('manufacturing')
            <g class="stroke-signal/70" stroke-width="1.3">
                <path d="M70 320h500M110 320V180l80 40V170l90 48V150h160v170" />
                <path d="M440 150v-50M490 150v-70" />
            </g>
        @break
        @case('lab')
            <g class="stroke-signal/70" stroke-width="1.3">
                <rect x="160" y="80" width="320" height="220" />
                <circle cx="320" cy="190" r="58" />
                <path d="M320 80v220M160 190h320" />
            </g>
        @break
        @case('business')
            <g class="stroke-signal/70" stroke-width="1.3">
                <path d="M80 300 320 90 560 300" />
                <path d="M160 300V170h80v130M320 300V140h80v160M480 300V190h60v110" />
            </g>
        @break
        @case('workshop')
            <g class="stroke-signal/70" stroke-width="1.3">
                <rect x="140" y="100" width="360" height="200" />
                <path d="M140 200h360M260 100v200M420 100v200" />
            </g>
        @break
        @default
            <g class="stroke-signal/70" stroke-width="1.3">
                <rect x="120" y="90" width="400" height="220" />
                <path d="M120 160h400M200 90v220M440 90v220" />
            </g>
    @endswitch
</svg>
