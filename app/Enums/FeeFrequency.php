<?php

namespace App\Enums;

enum FeeFrequency: string
{
    case OneTime = 'one_time';
    case Monthly = 'monthly';
    case Yearly = 'yearly';
    case Custom = 'custom';

    /**
     * All accepted stored values, useful for validation rules.
     *
     * @return list<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Human-friendly label used across admin and informational surfaces.
     */
    public function label(): string
    {
        return match ($this) {
            self::OneTime => 'One Time',
            self::Monthly => 'Monthly',
            self::Yearly => 'Yearly',
            self::Custom => 'Custom',
        };
    }
}
