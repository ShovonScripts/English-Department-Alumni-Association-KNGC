<?php

namespace App\Enums;

enum ExpenseStatus: string
{
    case Recorded = 'recorded';
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
     * Statuses that represent a valid association expense.
     *
     * @return list<string>
     */
    public static function validValues(): array
    {
        return [self::Recorded->value];
    }

    public function label(): string
    {
        return match ($this) {
            self::Recorded => 'Recorded',
            self::Void => 'Void',
        };
    }

    public function isVoid(): bool
    {
        return $this === self::Void;
    }
}
