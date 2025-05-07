<?php

namespace App\Notifications;

use App\Models\Expense;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExpenseReminder extends Notification implements ShouldQueue
{
    use Queueable;

    protected $expense;
    protected $daysUntilDue;

    /**
     * Create a new notification instance.
     */
    public function __construct(Expense $expense, int $daysUntilDue)
    {
        $this->expense = $expense;
        $this->daysUntilDue = $daysUntilDue;
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
        $dueText = $this->daysUntilDue === 0 
            ? 'due today' 
            : "due in {$this->daysUntilDue} " . ($this->daysUntilDue === 1 ? 'day' : 'days');

        return (new MailMessage)
            ->subject("Expense Reminder: {$this->expense->description} {$dueText}")
            ->greeting('Hello!')
            ->line("This is a reminder that your expense '{$this->expense->description}' is {$dueText}.")
            ->line("Amount: ₹" . number_format(abs($this->expense->amount), 2))
            ->line("Category: " . ($this->expense->category->name ?? 'Uncategorized'))
            ->action('View Expense', url('/expenses/' . $this->expense->id))
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
            'expense_id' => $this->expense->id,
            'description' => $this->expense->description,
            'amount' => $this->expense->amount,
            'due_date' => $this->expense->date->format('Y-m-d'),
            'days_until_due' => $this->daysUntilDue,
            'category' => $this->expense->category->name ?? 'Uncategorized',
            'type' => 'expense_reminder'
        ];
    }
}
