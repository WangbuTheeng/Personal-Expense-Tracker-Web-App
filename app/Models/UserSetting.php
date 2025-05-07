<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'currency',
        'currency_symbol',
        'date_format',
        'locale',
        'notifications_enabled',
        'email_notifications',
        'preferred_notification_time',
        'show_recurring_first',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'notifications_enabled' => 'boolean',
        'email_notifications' => 'boolean',
        'show_recurring_first' => 'boolean',
        'preferred_notification_time' => 'datetime:H:i',
    ];

    /**
     * Available currencies with their symbols
     *
     * @return array<string, array>
     */
    public static function availableCurrencies(): array
    {
        return [
            'INR' => ['name' => 'Indian Rupee', 'symbol' => '₹'],
            'USD' => ['name' => 'US Dollar', 'symbol' => '$'],
            'EUR' => ['name' => 'Euro', 'symbol' => '€'],
            'GBP' => ['name' => 'British Pound', 'symbol' => '£'],
            'JPY' => ['name' => 'Japanese Yen', 'symbol' => '¥'],
        ];
    }

    /**
     * Available date formats
     *
     * @return array<string, string>
     */
    public static function availableDateFormats(): array
    {
        return [
            'Y-m-d' => 'YYYY-MM-DD (e.g., 2023-12-31)',
            'd/m/Y' => 'DD/MM/YYYY (e.g., 31/12/2023)',
            'm/d/Y' => 'MM/DD/YYYY (e.g., 12/31/2023)',
            'd.m.Y' => 'DD.MM.YYYY (e.g., 31.12.2023)',
            'd-M-Y' => 'DD-MMM-YYYY (e.g., 31-Dec-2023)',
        ];
    }

    /**
     * Get user who owns these settings
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
