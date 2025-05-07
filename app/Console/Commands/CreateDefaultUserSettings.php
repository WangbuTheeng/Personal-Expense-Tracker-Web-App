<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Console\Command;

class CreateDefaultUserSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-default-user-settings {--user=} {--all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create default settings for users who don\'t have settings yet';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('all')) {
            $this->info('Creating default settings for all users without settings...');
            
            $usersWithoutSettings = User::whereDoesntHave('settings')->get();
            
            $count = 0;
            foreach ($usersWithoutSettings as $user) {
                $this->createSettingsForUser($user);
                $count++;
            }
            
            $this->info("Created default settings for {$count} users.");
            return Command::SUCCESS;
        }
        
        $userId = $this->option('user');
        if ($userId) {
            $user = User::find($userId);
            
            if (!$user) {
                $this->error("User with ID {$userId} not found.");
                return Command::FAILURE;
            }
            
            if ($user->settings()->exists()) {
                $this->info("User already has settings. Use --force to override.");
                return Command::SUCCESS;
            }
            
            $this->createSettingsForUser($user);
            $this->info("Created default settings for user {$user->name}.");
            return Command::SUCCESS;
        }
        
        $this->error("Please specify a user ID with --user=ID or use --all to create settings for all users without settings.");
        return Command::FAILURE;
    }
    
    /**
     * Create default settings for a user
     */
    private function createSettingsForUser(User $user)
    {
        $defaultCurrency = 'INR';
        $defaultSymbol = '₹';
        
        UserSetting::create([
            'user_id' => $user->id,
            'currency' => $defaultCurrency,
            'currency_symbol' => $defaultSymbol,
            'date_format' => 'Y-m-d',
            'notifications_enabled' => true,
            'email_notifications' => true,
            'preferred_notification_time' => '08:00:00',
            'show_recurring_first' => false,
        ]);
        
        $this->line("Created settings for {$user->name} (ID: {$user->id})");
    }
}
