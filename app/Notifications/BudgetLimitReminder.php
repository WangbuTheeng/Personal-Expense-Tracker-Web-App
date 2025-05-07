<?php

namespace App\Notifications;

use App\Models\Budget;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BudgetLimitReminder extends Notification implements ShouldQueue
{
    use Queueable;

    protected $budget;
    protected $percentUsed;
    protected $isExceeded;

    /**
     * Create a new notification instance.
     */
    public function __construct(Budget $budget, float $percentUsed, bool $isExceeded = false)
    {
        $this->budget = $budget;
        $this->percentUsed = $percentUsed;
        $this->isExceeded = $isExceeded;
        $this->afterCommit();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject($this->getSubject())
            ->greeting('Hello!');

        if ($this->isExceeded) {
            $message->line("You have exceeded your budget for {$this->budget->category->name}.");
            $message->line("Budget Limit: ₹" . number_format($this->budget->amount, 2));
            $message->line("Current Spending: ₹" . number_format($this->budget->getCurrentSpending(), 2));
            $message->line("You are " . number_format($this->percentUsed, 0) . "% over your budget limit.");
            $message->line("Consider adjusting your spending or revising your budget.");
        } else {
            $message->line("You are approaching your budget limit for {$this->budget->category->name}.");
            $message->line("Budget Limit: ₹" . number_format($this->budget->amount, 2));
            $message->line("Current Spending: ₹" . number_format($this->budget->getCurrentSpending(), 2));
            $message->line("You've used " . number_format($this->percentUsed, 0) . "% of your budget.");
        }

        return $message
            ->action('View Budget', url('/budgets/' . $this->budget->id))
            ->line('Thank you for using our Personal Expense Tracker!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'budget_id' => $this->budget->id,
            'category' => $this->budget->category->name,
            'budget_amount' => $this->budget->amount,
            'current_spending' => $this->budget->getCurrentSpending(),
            'percent_used' => $this->percentUsed,
            'is_exceeded' => $this->isExceeded,
            'type' => 'budget_limit'
        ];
    }

    /**
     * Get the notification subject based on budget status.
     */
    private function getSubject(): string
    {
        if ($this->isExceeded) {
            return "Budget Alert: You've exceeded your {$this->budget->category->name} budget!";
        }
        
        return "Budget Alert: Approaching {$this->budget->category->name} budget limit";
    }
}
