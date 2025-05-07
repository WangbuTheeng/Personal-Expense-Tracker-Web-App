<?php

namespace App\Listeners;

use App\Models\UserSetting;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class CreateUserSettings implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $user = $event->user;
        
        // Skip if the user already has settings
        if ($user->settings()->exists()) {
            return;
        }
        
        try {
            // Create default settings for the user
            UserSetting::create([
                'user_id' => $user->id,
                'currency' => 'INR',
                'currency_symbol' => '₹',
                'date_format' => 'Y-m-d',
                'notifications_enabled' => true,
                'email_notifications' => true,
                'preferred_notification_time' => '08:00:00',
                'show_recurring_first' => false,
            ]);
            
            Log::info("Default settings created for user {$user->id}");
        } catch (\Exception $e) {
            Log::error("Failed to create default settings for user {$user->id}: {$e->getMessage()}");
        }
    }
}
