<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SavingsGoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'target_amount',
        'current_amount',
        'target_date',
        'description',
        'is_completed'
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'target_date' => 'date',
        'is_completed' => 'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getProgressPercentage(): float
    {
        if ($this->target_amount <= 0) {
            return 100;
        }
        return min(100, ($this->current_amount / $this->target_amount) * 100);
    }

    public function getRemainingAmount(): float
    {
        return max(0, $this->target_amount - $this->current_amount);
    }

    public function predictCompletionDate(): ?string
    {
        if ($this->is_completed || $this->current_amount >= $this->target_amount) {
            return null;
        }

        // Calculate average daily savings based on history
        $daysActive = max(1, now()->diffInDays($this->created_at));
        $dailySavingsRate = $this->current_amount / $daysActive;

        if ($dailySavingsRate <= 0) {
            return null;
        }

        $remainingAmount = $this->getRemainingAmount();
        $daysToComplete = ceil($remainingAmount / $dailySavingsRate);
        
        return now()->addDays($daysToComplete)->format('Y-m-d');
    }
}
