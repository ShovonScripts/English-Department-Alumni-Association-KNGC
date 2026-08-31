<?php

namespace App\Enums;

enum ApplicationStatus: string
{
    case Pending = 'pending';
    case UnderReview = 'under_review';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case ChangesRequested = 'changes_requested';
    case Cancelled = 'cancelled';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function activeValues(): array
    {
        return [self::Pending->value, self::UnderReview->value];
    }

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::UnderReview => 'Under Review',
            self::Approved => 'Approved',
            self::Rejected => 'Rejected',
            self::ChangesRequested => 'Changes Requested',
            self::Cancelled => 'Cancelled',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'gold',
            self::UnderReview => 'navy',
            self::Approved => 'emerald',
            self::Rejected => 'maroon',
            self::ChangesRequested => 'amber',
            self::Cancelled => 'navy',
        };
    }
}
