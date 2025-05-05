<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use App\Models\Expense;

class Budget extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'amount',
        'period',
        'start_date',
        'end_date',
        'description',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];
    
    /**
     * Get the user that owns the budget.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the category of the budget.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    
    /**
     * Calculate the used amount of the budget.
     */
    public function getUsedAmount()
    {
        $query = Expense::where('user_id', $this->user_id)
            ->whereBetween('date', [$this->start_date, $this->end_date ?? now()]);
            
        if ($this->category_id) {
            $query->where('category_id', $this->category_id);
        }
        
        return $query->sum('amount');
    }
    
    /**
     * Calculate the remaining amount of the budget.
     */
    public function getRemainingAmount()
    {
        return max(0, $this->amount - $this->getUsedAmount());
    }
    
    /**
     * Calculate the percentage used of the budget.
     */
    public function getPercentageUsed()
    {
        if ($this->amount <= 0) {
            return 100;
        }
        
        return min(100, ($this->getUsedAmount() / $this->amount) * 100);
    }
    
    /**
     * Check if the budget is over the limit.
     */
    public function isOverBudget()
    {
        return $this->getUsedAmount() > $this->amount;
    }
}
