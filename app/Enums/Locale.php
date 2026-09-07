<?php

namespace App\Enums;

enum Locale: string
{
    case German = 'de';
    case English = 'en';

    public function label(): string
    {
        return match ($this) {
            self::German => 'Deutsch',
            self::English => 'English',
        };
    }

    public function hreflang(): string
    {
        return config('localization.hreflang.'.$this->value, $this->value);
    }

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
