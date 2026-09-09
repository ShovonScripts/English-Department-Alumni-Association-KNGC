<?php

namespace App\Models;

use App\Enums\ExpenseStatus;
use Database\Factories\ExpenseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    /** @use HasFactory<ExpenseFactory> */
    use HasFactory;

    protected $fillable = [
        'expense_category_id',
        'expense_number',
        'amount',
        'currency',
        'status',
        'expense_date',
        'title',
        'description',
        'reference',
        'recorded_by',
    ];

    protected static function booted(): void
    {
        // Safety net: every expense always receives a unique number, even
        // when it is not assigned explicitly by the controller.
        static::creating(function (Expense $expense) {
            if (blank($expense->expense_number)) {
                $expense->expense_number = static::generateExpenseNumber();
            }
        });
    }

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'status' => ExpenseStatus::class,
            'expense_date' => 'date',
            'voided_at' => 'datetime',
        ];
    }

    /**
     * Expenses are addressed by their stable financial identifier, never
     * the raw database ID.
     */
    public function getRouteKeyName(): string
    {
        return 'expense_number';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function voidedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'voided_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes — all financial aggregation must flow through these.
    |--------------------------------------------------------------------------
    */

    /**
     * Expenses that represent money actually spent by the association
     * (recorded only). Void expenses are retained for audit but excluded.
     */
    public function scopeValid(Builder $query): Builder
    {
        return $query->where('status', ExpenseStatus::Recorded->value);
    }

    public function scopeRecorded(Builder $query): Builder
    {
        return static::scopeValid($query);
    }

    public function scopeVoid(Builder $query): Builder
    {
        return $query->where('status', ExpenseStatus::Void->value);
    }

    public function scopeForCategory(Builder $query, int $categoryId): Builder
    {
        return $query->where('expense_category_id', $categoryId);
    }

    /*
    |--------------------------------------------------------------------------
    | Number generation
    |--------------------------------------------------------------------------
    */

    /**
     * Generate the next sequential, unique expense number (EDAA-EXP-000001).
     *
     * Numbers are fixed-width so descending string order equals numeric
     * order. Voided records keep their numbers forever; the unique
     * constraint is the final race-condition guard.
     */
    public static function generateExpenseNumber(): string
    {
        $attempts = 0;

        do {
            $latest = static::query()->orderByDesc('expense_number')->value('expense_number');
            $sequence = $latest !== null ? (int) substr($latest, 9) : 0;
            $number = 'EDAA-EXP-'.str_pad((string) ($sequence + 1), 6, '0', STR_PAD_LEFT);

            if (! static::query()->where('expense_number', $number)->exists()) {
                return $number;
            }

            $attempts++;
        } while ($attempts < 25);

        throw new \RuntimeException('Unable to generate a unique expense number.');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function formattedAmount(): string
    {
        return '৳'.number_format((float) $this->amount);
    }

    public function isVoid(): bool
    {
        return $this->status->isVoid();
    }
}
