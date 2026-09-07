@props([
    'name' => 'layers',
])

@php
    $key = $name ?: 'layers';
@endphp

<svg {{ $attributes->merge(['class' => 'h-full w-full', 'viewBox' => '0 0 640 420', 'fill' => 'none', 'xmlns' => 'http://www.w3.org/2000/svg']) }} aria-hidden="true">
    <rect width="640" height="420" class="fill-ink-mid" />
    <g class="stroke-white/15" stroke-width="0.8">
        @for ($i = 0; $i <= 16; $i++)
            <path d="M{{ $i * 40 }} 0v420" />
        @endfor
        @for ($i = 0; $i <= 10; $i++)
            <path d="M0 {{ $i * 42 }}h640" />
        @endfor
    </g>

    @switch($key)
        @case('code')
            <g class="stroke-signal" stroke-width="1.4">
                <path d="M210 120 140 210l70 90M430 120l70 90-70 90M360 96 280 324" />
            </g>
        @break
        @case('headset')
            <g class="stroke-signal" stroke-width="1.4">
                <circle cx="320" cy="210" r="92" />
                <circle cx="320" cy="210" r="54" />
                <path d="M320 118v184M228 210h184" />
            </g>
        @break
        @case('cpu')
            <g class="stroke-signal" stroke-width="1.3">
                <rect x="230" y="130" width="180" height="160" />
                <rect x="270" y="170" width="100" height="80" />
                <path d="M260 130v-28M320 130v-28M380 130v-28M260 290v28M320 290v28M380 290v28M230 180h-28M230 210h-28M230 240h-28M410 180h28M410 210h28M410 240h28" />
            </g>
        @break
        @case('building')
            <g class="stroke-signal" stroke-width="1.3">
                <path d="M180 330V150l140-40 140 40v180" />
                <path d="M250 330V190M390 330V190M180 230h280" />
                <path d="M220 210h16M220 250h16M300 200h16M300 240h16M380 210h16M380 250h16" />
            </g>
        @break
        @case('factory')
            <g class="stroke-signal" stroke-width="1.3">
                <path d="M140 330h360M170 330V190l90 50V190l90 50V170h110v160" />
                <path d="M430 170v-40M470 170v-56" />
            </g>
        @break
        @default
            <g class="stroke-signal" stroke-width="1.3">
                <path d="M160 300 320 120 480 300" />
                <path d="M200 300 320 168 440 300" />
                <path d="M240 300 320 216 400 300" />
            </g>
    @endswitch

    <path class="stroke-signal" stroke-width="1.5" d="M24 24h36M24 24v36M616 24h-36M616 24v36M24 396h36M24 396v-36M616 396h-36M616 396v-36" />
</svg>
