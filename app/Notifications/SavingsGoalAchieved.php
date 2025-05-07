<?php

namespace App\Notifications;

use App\Models\SavingsGoal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SavingsGoalAchieved extends Notification implements ShouldQueue
{
    use Queueable;

    protected $savingsGoal;

    /**
     * Create a new notification instance.
     */
    public function __construct(SavingsGoal $savingsGoal)
    {
        $this->savingsGoal = $savingsGoal;
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
        return (new MailMessage)
            ->subject("Congratulations! You've Achieved Your Savings Goal")
            ->greeting('Congratulations!')
            ->line("You've successfully reached your savings goal: {$this->savingsGoal->name}!")
            ->line("Target Amount: ₹" . number_format($this->savingsGoal->target_amount, 2))
            ->line("Current Amount: ₹" . number_format($this->savingsGoal->current_amount, 2))
            ->line("This is a fantastic achievement. Keep up the good work with your financial goals!")
            ->action('View Savings Goal', url('/savings/' . $this->savingsGoal->id))
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
            'savings_goal_id' => $this->savingsGoal->id,
            'name' => $this->savingsGoal->name,
            'target_amount' => $this->savingsGoal->target_amount,
            'current_amount' => $this->savingsGoal->current_amount,
            'achieved_date' => now()->format('Y-m-d'),
            'type' => 'savings_goal_achieved'
        ];
    }
}
