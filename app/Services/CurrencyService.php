<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class CurrencyService
{
    /**
     * Format a number as currency based on user settings
     *
     * @param float $amount The amount to format
     * @param bool $includeSymbol Whether to include the currency symbol
     * @return string
     */
    public static function format($amount, $includeSymbol = true)
    {
        $user = Auth::user();
        
        if (!$user) {
            // Default formatting if no user is authenticated
            return '₹' . number_format(abs($amount), 2);
        }
        
        $settings = $user->settings;
        
        // Format the number (2 decimal places, with thousand separators)
        $formattedAmount = number_format(abs($amount), 2);
        
        // Return with or without symbol
        if ($includeSymbol) {
            return $settings->currency_symbol . $formattedAmount;
        }
        
        return $formattedAmount;
    }
} 