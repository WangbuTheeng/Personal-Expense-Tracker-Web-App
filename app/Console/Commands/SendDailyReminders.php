<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Expense;
use App\Models\Budget;
use App\Models\SavingsGoal;
use App\Notifications\ExpenseReminder;
use App\Notifications\BudgetLimitReminder;
use App\Notifications\SavingsGoalAchieved;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendDailyReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-daily-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily reminders for upcoming expenses, budget limits, and savings goals';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to send daily reminders...');
        
        // Send expense reminders
        $this->sendExpenseReminders();
        
        // Send budget limit notifications
        $this->sendBudgetLimitNotifications();
        
        // Send savings goal achievement notifications
        $this->checkSavingsGoalAchievements();
        
        $this->info('Daily reminders sent successfully.');
        return Command::SUCCESS;
    }
    
    /**
     * Send reminders for upcoming expenses
     */
    private function sendExpenseReminders()
    {
        $this->info('Sending expense reminders...');
        
        // Check for expenses due today
        $today = Carbon::today();
        $dueTodayExpenses = Expense::with(['user', 'category'])
            ->whereDate('date', $today)
            ->where('is_recurring', true)
            ->get();
            
        foreach ($dueTodayExpenses as $expense) {
            try {
                $expense->user->notify(new ExpenseReminder($expense, 0));
                $this->line("Sent reminder for expense due today: {$expense->description} to {$expense->user->email}");
            } catch (\Exception $e) {
                Log::error("Failed to send expense reminder: {$e->getMessage()}");
                $this->error("Failed to send expense reminder: {$e->getMessage()}");
            }
        }
        
        // Check for expenses due in 3 days
        $threeDaysFromNow = Carbon::today()->addDays(3);
        $upcomingExpenses = Expense::with(['user', 'category'])
            ->whereDate('date', $threeDaysFromNow)
            ->where('is_recurring', true)
            ->get();
            
        foreach ($upcomingExpenses as $expense) {
            try {
                $expense->user->notify(new ExpenseReminder($expense, 3));
                $this->line("Sent reminder for upcoming expense: {$expense->description} to {$expense->user->email}");
            } catch (\Exception $e) {
                Log::error("Failed to send upcoming expense reminder: {$e->getMessage()}");
                $this->error("Failed to send upcoming expense reminder: {$e->getMessage()}");
            }
        }
    }
    
    /**
     * Send budget limit notifications
     */
    private function sendBudgetLimitNotifications()
    {
        $this->info('Checking budget limits...');
        
        $budgets = Budget::with(['user', 'category'])->get();
        
        foreach ($budgets as $budget) {
            $percentUsed = $budget->getPercentUsed();
            
            try {
                // Check if budget is exceeded (over 100%)
                if ($percentUsed > 100 && !$budget->notified_exceeded) {
                    $budget->user->notify(new BudgetLimitReminder($budget, $percentUsed, true));
                    $this->line("Sent budget exceeded notification for {$budget->category->name} to {$budget->user->email}");
                    
                    // Mark as notified so we don't send again
                    $budget->notified_exceeded = true;
                    $budget->save();
                }
                // Check if approaching limit (over 80% but less than 100%)
                elseif ($percentUsed >= 80 && $percentUsed <= 100 && !$budget->notified_approaching) {
                    $budget->user->notify(new BudgetLimitReminder($budget, $percentUsed, false));
                    $this->line("Sent approaching budget limit notification for {$budget->category->name} to {$budget->user->email}");
                    
                    // Mark as notified so we don't send again
                    $budget->notified_approaching = true;
                    $budget->save();
                }
            } catch (\Exception $e) {
                Log::error("Failed to send budget notification: {$e->getMessage()}");
                $this->error("Failed to send budget notification: {$e->getMessage()}");
            }
        }
    }
    
    /**
     * Check for savings goal achievements
     */
    private function checkSavingsGoalAchievements()
    {
        $this->info('Checking savings goal achievements...');
        
        $savingsGoals = SavingsGoal::with('user')
            ->where('is_completed', false)
            ->get();
            
        foreach ($savingsGoals as $goal) {
            try {
                // Check if current amount meets or exceeds target
                if ($goal->current_amount >= $goal->target_amount) {
                    $goal->user->notify(new SavingsGoalAchieved($goal));
                    $this->line("Sent savings goal achievement notification for {$goal->name} to {$goal->user->email}");
                    
                    // Mark as completed
                    $goal->is_completed = true;
                    $goal->save();
                }
            } catch (\Exception $e) {
                Log::error("Failed to send savings goal notification: {$e->getMessage()}");
                $this->error("Failed to send savings goal notification: {$e->getMessage()}");
            }
        }
    }
}
