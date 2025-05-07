<?php

namespace App\Console\Commands;

use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateRecurringExpenses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expenses:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate recurring expenses based on frequency';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating recurring expenses...');

        $recurringExpenses = Expense::where('is_recurring', true)->get();
        $today = Carbon::today();
        $count = 0;

        foreach ($recurringExpenses as $expense) {
            $lastDate = $expense->date;
            $nextDate = null;

            // Calculate next date based on frequency
            switch ($expense->recurring_frequency) {
                case 'daily':
                    $nextDate = $lastDate->addDay();
                    break;
                case 'weekly':
                    $nextDate = $lastDate->addWeek();
                    break;
                case 'biweekly':
                    $nextDate = $lastDate->addWeeks(2);
                    break;
                case 'monthly':
                    $nextDate = $lastDate->addMonth();
                    break;
                case 'quarterly':
                    $nextDate = $lastDate->addMonths(3);
                    break;
                case 'yearly':
                    $nextDate = $lastDate->addYear();
                    break;
            }

            // Check if we should generate a new expense
            if ($nextDate && $nextDate->lte($today)) {
                if ($expense->skip_next) {
                    // If skip_next is true, just update the date and reset skip_next
                    $expense->date = $nextDate;
                    $expense->skip_next = false;
                    $expense->save();
                    
                    $this->info("Skipped expense: {$expense->description} for {$nextDate->format('Y-m-d')}");
                } else {
                    // Create new expense with the same details but updated date
                    $newExpense = $expense->replicate();
                    $newExpense->date = $nextDate;
                    $newExpense->is_recurring = false; // This instance won't be recurring
                    $newExpense->skip_next = false;
                    $newExpense->save();

                    // Update original expense's date
                    $expense->date = $nextDate;
                    $expense->save();

                    $count++;
                    $this->info("Generated expense: {$expense->description} for {$nextDate->format('Y-m-d')}");
                }
            }
        }

        $this->info("Generated {$count} recurring expenses.");
    }
}
