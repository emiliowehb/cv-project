<?php

namespace App\Traits;

trait EnumTrait
{
    public static function values()
    {
        return array_map(function ($case) {
            return $case->value;
        }, static::class::cases());
    }

    public static function hash()
    {
        return array_map(function ($case) {
            return ['key' => $case->value, 'value' => $case->label()];
        }, static::class::cases());
    }

    public static function hash_excluding($excludeValue)
    {
        return array_map(function ($case) use ($excludeValue) {
            if ($excludeValue === $case->value) {
                return null;
            }

            return ['key' => $case->value, 'value' => $case->label()];
        }, static::class::cases());
    }
}
