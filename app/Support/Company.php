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
        if (self::hasStored($key)) {
            $stored = self::stored($key);

            return filled($stored) ? (string) $stored : ($placeholder ?? '');
        }

        $configured = config('company.'.$key);

        if (filled($configured)) {
            return (string) $configured;
        }

        return $placeholder ?? __('legal.placeholder');
    }

    public static function has(string $key): bool
    {
        if (self::hasStored($key)) {
            return filled(self::stored($key));
        }

        return filled(config('company.'.$key));
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
            $values[$key] = self::hasStored($key)
                ? (string) (self::stored($key) ?? '')
                : (string) (config('company.'.$key) ?: '');
        }

        return $values;
    }

    /**
     * @return array<string, string>
     */
    public static function replacements(): array
    {
        return [
            'brand' => self::value('name', __('common.brand')),
            'legal_name' => self::value('legal_name', ''),
            'legal_form' => self::value('legal_form', ''),
            'owner' => self::value('owner', ''),
            'street' => self::value('street', ''),
            'postal_code' => self::value('postal_code', ''),
            'city' => self::value('city', ''),
            'country' => self::value('country', ''),
            'email' => self::value('email', ''),
            'phone' => self::value('phone', ''),
            'website' => self::value('website', ''),
            'hosting_provider' => self::value('hosting_provider', ''),
            'address' => trim(self::value('street', '').', '.self::value('postal_code', '').' '.self::value('city', ''), ', '),
        ];
    }

    private static function hasStored(string $key): bool
    {
        if (! Schema::hasTable('settings')) {
            return false;
        }

        return array_key_exists($key, Setting::dictionary());
    }

    private static function stored(string $key): ?string
    {
        if (! Schema::hasTable('settings')) {
            return null;
        }

        return Setting::get($key);
    }
}
