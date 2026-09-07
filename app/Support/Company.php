<?php

namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;

final class Company
{
    /**
     * @return list<string>
     */
    public static function keys(): array
    {
        return [
            'name',
            'legal_name',
            'legal_form',
            'owner',
            'street',
            'postal_code',
            'city',
            'country',
            'email',
            'phone',
            'website',
            'vat_id',
            'register_court',
            'register_number',
            'responsible',
            'hosting_provider',
        ];
    }

    public static function value(string $key, ?string $placeholder = null): string
    {
        $stored = self::stored($key);

        if (filled($stored)) {
            return (string) $stored;
        }

        $configured = config('company.'.$key);

        if (filled($configured)) {
            return (string) $configured;
        }

        return $placeholder ?? __('legal.placeholder');
    }

    public static function has(string $key): bool
    {
        return filled(self::stored($key)) || filled(config('company.'.$key));
    }

    public static function telHref(): ?string
    {
        if (! self::has('phone')) {
            return null;
        }

        return 'tel:'.preg_replace('/[^\d+]/', '', self::value('phone'));
    }

    /**
     * @return array<string, string>
     */
    public static function values(): array
    {
        $values = [];

        foreach (self::keys() as $key) {
            $values[$key] = self::has($key) ? self::value($key, '') : '';
        }

        return $values;
    }

    private static function stored(string $key): ?string
    {
        if (! Schema::hasTable('settings')) {
            return null;
        }

        return Setting::get($key);
    }
}
