<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DateService
{
    /**
     * Format a date based on user settings
     *
     * @param mixed $date Date to format (string, Carbon instance, or DateTime)
     * @return string
     */
    public static function format($date)
    {
        $user = Auth::user();
        
        if (!$user) {
            // Default formatting if no user is authenticated
            return Carbon::parse($date)->format('Y-m-d');
        }
        
        $settings = $user->settings;
        
        // Convert to Carbon if not already
        if (!($date instanceof Carbon)) {
            $date = Carbon::parse($date);
        }
        
        // Format the date according to user preference
        return $date->format($settings->date_format);
    }
    
    /**
     * Parse a date string according to user's date format
     *
     * @param string $dateString Date string in user's preferred format
     * @return Carbon
     */
    public static function parse($dateString)
    {
        $user = Auth::user();
        
        if (!$user) {
            // Default parsing if no user is authenticated
            return Carbon::parse($dateString);
        }
        
        $settings = $user->settings;
        
        // Create a Carbon instance from the date string using the user's format
        return Carbon::createFromFormat($settings->date_format, $dateString);
    }
} 