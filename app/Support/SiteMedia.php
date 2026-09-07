<?php

namespace App\Support;

final class SiteMedia
{
    /**
     * @return array{file: string, width: int, height: int, alt: string}|null
     */
    public static function definition(string $name): ?array
    {
        return match ($name) {
            'infrastructure-servers' => [
                'file' => 'infrastructure-servers',
                'width' => 1920,
                'height' => 1077,
                'alt' => 'media.alt.infrastructure-servers',
            ],
            'technical-office' => [
                'file' => 'technical-office',
                'width' => 1600,
                'height' => 1067,
                'alt' => 'media.alt.technical-office',
            ],
            'software-code' => [
                'file' => 'software-code',
                'width' => 1400,
                'height' => 933,
                'alt' => 'media.alt.software-code',
            ],
            'technical-workstation' => [
                'file' => 'technical-workstation',
                'width' => 1600,
                'height' => 1067,
                'alt' => 'media.alt.technical-workstation',
            ],
            'electronics-chip' => [
                'file' => 'electronics-chip',
                'width' => 1400,
                'height' => 933,
                'alt' => 'media.alt.electronics-chip',
            ],
            'industrial-testing' => [
                'file' => 'industrial-testing',
                'width' => 1600,
                'height' => 1067,
                'alt' => 'media.alt.industrial-testing',
            ],
            'electronics-board' => [
                'file' => 'electronics-board',
                'width' => 1400,
                'height' => 933,
                'alt' => 'media.alt.electronics-board',
            ],
            'abstract-tech' => [
                'file' => 'abstract-tech',
                'width' => 1600,
                'height' => 900,
                'alt' => 'media.alt.abstract-tech',
            ],
            'source-code' => [
                'file' => 'source-code',
                'width' => 1600,
                'height' => 1067,
                'alt' => 'media.alt.source-code',
            ],
            'hardware-board' => [
                'file' => 'hardware-board',
                'width' => 1400,
                'height' => 875,
                'alt' => 'media.alt.hardware-board',
            ],
            'motherboard-detail' => [
                'file' => 'motherboard-detail',
                'width' => 1600,
                'height' => 1068,
                'alt' => 'media.alt.motherboard-detail',
            ],
            'business-dashboard' => [
                'file' => 'business-dashboard',
                'width' => 1600,
                'height' => 1060,
                'alt' => 'media.alt.business-dashboard',
            ],
            'laboratory-work' => [
                'file' => 'laboratory-work',
                'width' => 1600,
                'height' => 900,
                'alt' => 'media.alt.laboratory-work',
            ],
            'workshop-tools' => [
                'file' => 'workshop-tools',
                'width' => 1600,
                'height' => 1067,
                'alt' => 'media.alt.workshop-tools',
            ],
            'engineering-work' => [
                'file' => 'engineering-work',
                'width' => 1600,
                'height' => 1067,
                'alt' => 'media.alt.engineering-work',
            ],
            'workshop-planning' => [
                'file' => 'workshop-planning',
                'width' => 1600,
                'height' => 1067,
                'alt' => 'media.alt.workshop-planning',
            ],
            'code-review' => [
                'file' => 'code-review',
                'width' => 1600,
                'height' => 1067,
                'alt' => 'media.alt.code-review',
            ],
            'engineering-lab' => [
                'file' => 'engineering-lab',
                'width' => 1600,
                'height' => 1067,
                'alt' => 'media.alt.engineering-lab',
            ],
            'circuit-glow' => [
                'file' => 'circuit-glow',
                'width' => 1600,
                'height' => 1060,
                'alt' => 'media.alt.circuit-glow',
            ],
            'memory-modules' => [
                'file' => 'memory-modules',
                'width' => 1600,
                'height' => 1067,
                'alt' => 'media.alt.memory-modules',
            ],
            'laptop-code' => [
                'file' => 'laptop-code',
                'width' => 1600,
                'height' => 1067,
                'alt' => 'media.alt.laptop-code',
            ],
            default => null,
        };
    }

    public static function webpUrl(string $name): ?string
    {
        $definition = self::definition($name);

        if ($definition === null) {
            return null;
        }

        return asset('images/'.$definition['file'].'.webp');
    }

    public static function jpgUrl(string $name): ?string
    {
        $definition = self::definition($name);

        if ($definition === null) {
            return null;
        }

        return asset('images/'.$definition['file'].'.jpg');
    }

    public static function absoluteJpgUrl(string $name): ?string
    {
        $definition = self::definition($name);

        if ($definition === null) {
            return null;
        }

        return asset('images/'.$definition['file'].'.jpg', true);
    }

    public static function forCategory(string $key): ?string
    {
        return match ($key) {
            'software-it' => 'software-code',
            'technical-support' => 'technical-workstation',
            'repair-electronics' => 'electronics-chip',
            'business-industry' => 'industrial-testing',
            'technology-companies' => 'source-code',
            default => null,
        };
    }

    public static function forIndustry(string $kind): ?string
    {
        return match ($kind) {
            'tech' => 'abstract-tech',
            'manufacturing' => 'hardware-board',
            'lab' => 'laboratory-work',
            'business' => 'business-dashboard',
            'workshop' => 'workshop-tools',
            'commercial' => 'laptop-code',
            default => null,
        };
    }
}
