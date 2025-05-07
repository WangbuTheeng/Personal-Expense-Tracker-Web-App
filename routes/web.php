<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\SavingsGoalController;
use App\Http\Controllers\ExpenseStatisticsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\IncomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Expense Routes
    Route::resource('expenses', ExpenseController::class);
    Route::patch('/expenses/{expense}/toggle-skip', [ExpenseController::class, 'toggleSkip'])->name('expenses.toggle-skip');
    
    // Income Routes
    Route::resource('income', IncomeController::class);
    
    // Category Routes
    Route::resource('categories', CategoryController::class);
    
    // Budget Routes
    Route::resource('budgets', BudgetController::class);
    
    // Savings Goal Routes
    Route::resource('savings', SavingsGoalController::class);
    
    // Dashboard & Chart Routes
    Route::get('/dashboard', [ExpenseStatisticsController::class, 'dashboard'])->name('dashboard');
    Route::get('/api/stats/category-distribution', [ExpenseStatisticsController::class, 'categoryDistribution']);
    Route::get('/api/stats/expense-trends/{period?}', [ExpenseStatisticsController::class, 'expenseTrends']);
    Route::get('/api/stats/month-comparison', [ExpenseStatisticsController::class, 'monthComparison']);
    Route::get('/api/stats/savings-progress', [ExpenseStatisticsController::class, 'savingsProgress']);
});

// Reports & Exports
Route::middleware('auth')->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports/excel', [ReportController::class, 'exportExcel'])->name('reports.excel');
    Route::post('/reports/pdf', [ReportController::class, 'exportPdf'])->name('reports.pdf');
});

// Notifications
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/notifications', [NotificationController::class, 'deleteAll'])->name('notifications.delete-all');
});

// Settings
Route::middleware('auth')->group(function () {
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::get('/settings/export', [SettingsController::class, 'exportData'])->name('settings.export');
    Route::post('/settings/import', [SettingsController::class, 'importData'])->name('settings.import');
});

require __DIR__.'/auth.php';
