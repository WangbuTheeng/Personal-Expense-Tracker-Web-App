<?php

namespace App\Http\Controllers;

use App\Models\UserSetting;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    /**
     * Display the user settings page.
     */
    public function index()
    {
        // Get current user settings or create default ones if they don't exist
        $settings = Auth::user()->settings;
        
        // Get the recurring expenses for this user for the recurring settings section
        $recurringExpenses = Expense::where('user_id', Auth::id())
            ->where('is_recurring', true)
            ->latest()
            ->get();
        
        return view('settings.index', [
            'settings' => $settings,
            'recurringExpenses' => $recurringExpenses,
            'currencies' => UserSetting::availableCurrencies(),
            'dateFormats' => UserSetting::availableDateFormats(),
        ]);
    }

    /**
     * Update the user settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'currency' => 'required|string|size:3',
            'date_format' => 'required|string|max:20',
            'notifications_enabled' => 'boolean',
            'email_notifications' => 'boolean',
            'preferred_notification_time' => 'required|date_format:H:i',
            'show_recurring_first' => 'boolean',
        ]);
        
        // Get currency symbol based on selected currency
        $currencies = UserSetting::availableCurrencies();
        $currencySymbol = $currencies[$validated['currency']]['symbol'] ?? '₹';
        
        // Add the currency symbol to the validated data
        $validated['currency_symbol'] = $currencySymbol;
        
        // Boolean fields that might not be present in the request if unchecked
        $validated['notifications_enabled'] = $request->has('notifications_enabled');
        $validated['email_notifications'] = $request->has('email_notifications');
        $validated['show_recurring_first'] = $request->has('show_recurring_first');
        
        // Update or create settings
        Auth::user()->settings()->updateOrCreate(
            ['user_id' => Auth::id()],
            $validated
        );
        
        return redirect()->route('settings.index')->with('success', 'Settings updated successfully!');
    }
    
    /**
     * Export user data.
     */
    public function exportData()
    {
        // This would be implemented to export user data in a JSON or CSV format
        // For now, we'll just return a message
        return redirect()->route('settings.index')
            ->with('info', 'Data export feature will be available soon.');
    }
    
    /**
     * Import user data.
     */
    public function importData(Request $request)
    {
        // This would be implemented to import user data from a JSON or CSV file
        // For now, we'll just return a message
        return redirect()->route('settings.index')
            ->with('info', 'Data import feature will be available soon.');
    }
}
