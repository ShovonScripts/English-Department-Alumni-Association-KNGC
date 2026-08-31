<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Paid = 'paid';
    case Partial = 'partial';
    case Waived = 'waived';
    case Void = 'void';

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
     * Statuses that represent money actually collected.
     *
     * @return list<string>
     */
    public static function collectibleValues(): array
    {
        return [self::Paid->value, self::Partial->value];
    }

    public function label(): string
    {
        return match ($this) {
            self::Paid => 'Paid',
            self::Partial => 'Partial',
            self::Waived => 'Waived',
            self::Void => 'Void',
        };
    }

    public function isVoid(): bool
    {
        return $this === self::Void;
    }
}
