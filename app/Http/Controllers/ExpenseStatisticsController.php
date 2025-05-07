<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use App\Models\SavingsGoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class ExpenseStatisticsController extends Controller
{
    /**
     * Show the dashboard with statistics.
     */
    public function dashboard(): View
    {
        $user = Auth::user();
        
        // Calculate basic statistics
        $totalCategories = $user->categories()->count();
        $activeGoals = $user->savingsGoals()->where('is_completed', false)->count();
        
        // Get monthly stats
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        
        $monthlyExpenses = $user->expenses()
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->get();
            
        $monthlyTotal = $monthlyExpenses->sum('amount');
        $dailyAverage = $monthlyTotal / now()->daysInMonth;

        // Get weekly stats
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();
        
        $weeklyExpenses = $user->expenses()
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->get();
            
        $weeklyTotal = $weeklyExpenses->sum('amount');
        $weeklyAverage = $weeklyTotal / 7;

        // Get daily stats (today)
        $startOfDay = now()->startOfDay();
        $endOfDay = now()->endOfDay();
        
        $dailyExpenses = $user->expenses()
            ->whereBetween('date', [$startOfDay, $endOfDay])
            ->get();
            
        $dailyTotal = $dailyExpenses->sum('amount');

        // Get total income (positive transactions)
        $monthlyIncome = $user->expenses()
            ->where('type', 'income')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $weeklyIncome = $user->expenses()
            ->where('type', 'income')
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->sum('amount');

        $dailyIncome = $user->expenses()
            ->where('type', 'income')
            ->whereBetween('date', [$startOfDay, $endOfDay])
            ->sum('amount');

        // Get total expenses (negative transactions)
        $monthlyExpenses = abs($user->expenses()
            ->where('type', 'expense')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount'));

        $weeklyExpenses = abs($user->expenses()
            ->where('type', 'expense')
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->sum('amount'));

        $dailyExpenses = abs($user->expenses()
            ->where('type', 'expense')
            ->whereBetween('date', [$startOfDay, $endOfDay])
            ->sum('amount'));

        // Calculate net savings
        $monthlyNetSavings = $monthlyIncome - $monthlyExpenses;
        $weeklyNetSavings = $weeklyIncome - $weeklyExpenses;
        $dailyNetSavings = $dailyIncome - $dailyExpenses;

        // Get recent transactions
        $recentTransactions = $user->expenses()
            ->with('category')
            ->latest('date')
            ->take(5)
            ->get();

        // Get expense distribution by category
        $expenseData = $user->categories()
            ->withSum(['expenses' => function ($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('date', [$startOfMonth, $endOfMonth]);
            }], 'amount')
            ->get()
            ->map(function ($category) {
                return [
                    'category' => $category->name,
                    'total' => abs($category->expenses_sum_amount ?? 0)
                ];
            });

        // Get savings goals data
        $savingsData = collect();
        if (method_exists($user, 'savingsGoals')) {
            $savingsData = $user->savingsGoals()
                ->where('is_completed', false)
                ->get()
                ->map(function ($goal) {
                    $result = new \stdClass();
                    $result->name = $goal->name;
                    $result->current = $goal->current_amount;
                    $result->target = $goal->target_amount;
                    $result->projected_completion = $this->calculateProjectedCompletion($goal);
                    return $result;
                });
        }

        return view('dashboard', compact(
            'totalCategories',
            'activeGoals',
            'monthlyTotal',
            'dailyAverage',
            'weeklyTotal',
            'weeklyAverage',
            'dailyTotal',
            'monthlyIncome',
            'monthlyExpenses',
            'monthlyNetSavings',
            'weeklyIncome',
            'weeklyExpenses',
            'weeklyNetSavings',
            'dailyIncome',
            'dailyExpenses',
            'dailyNetSavings',
            'recentTransactions',
            'expenseData',
            'savingsData'
        ));
    }

    /**
     * Calculate projected completion date for a savings goal based on current saving rate.
     */
    private function calculateProjectedCompletion($goal)
    {
        if ($goal->current_amount >= $goal->target_amount) {
            return 'Completed';
        }
        
        // Calculate average monthly savings rate based on current progress
        $daysActive = max(1, now()->diffInDays($goal->created_at));
        $dailySavingsRate = $goal->current_amount / $daysActive;
        $monthlySavingsRate = $dailySavingsRate * 30; // Approximate monthly rate
        
        if ($monthlySavingsRate <= 0) {
            return 'Insufficient data';
        }

        $remaining = $goal->target_amount - $goal->current_amount;
        $monthsToComplete = ceil($remaining / $monthlySavingsRate);
        
        return now()->addMonths($monthsToComplete)->format('F Y');
    }

    /**
     * Get category distribution data for charts.
     */
    public function categoryDistribution()
    {
        $user = Auth::user();
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        
        $categoryData = $user->categories()
            ->withSum(['expenses' => function ($query) use ($startOfMonth, $endOfMonth) {
                $query->where('type', 'expense')
                    ->whereBetween('date', [$startOfMonth, $endOfMonth]);
            }], 'amount')
            ->get()
            ->map(function ($category) {
                return [
                    'name' => $category->name,
                    'amount' => abs($category->expenses_sum_amount ?? 0),
                    'color' => $category->color ?? '#4F46E5'
                ];
            })
            ->filter(function ($category) {
                return $category['amount'] > 0;
            })
            ->values();
            
        return response()->json($categoryData);
    }

    /**
     * Get expense trends data for charts.
     */
    public function expenseTrends($period = 'monthly')
    {
        $user = Auth::user();
        $data = [];
        
        switch ($period) {
            case 'daily':
                $startDate = now()->subDays(30);
                $endDate = now();
                $dateFormat = 'M d';
                $groupFormat = 'Y-m-d';
                break;
                
            case 'weekly':
                $startDate = now()->subWeeks(12);
                $endDate = now();
                $dateFormat = 'W';
                $groupFormat = 'Y-W';
                break;
                
            case 'monthly':
            default:
                $startDate = now()->subMonths(12);
                $endDate = now();
                $dateFormat = 'M Y';
                $groupFormat = 'Y-m';
                break;
        }
        
        $expenses = $user->expenses()
            ->where('type', 'expense')
            ->whereBetween('date', [$startDate, $endDate])
            ->get()
            ->groupBy(function ($expense) use ($groupFormat) {
                return $expense->date->format($groupFormat);
            })
            ->map(function ($group) {
                return abs($group->sum('amount'));
            });
            
        $dates = [];
        $current = clone $startDate;
        
        while ($current <= $endDate) {
            $key = $current->format($groupFormat);
            $label = $current->format($dateFormat);
            
            $dates[] = [
                'date' => $label,
                'amount' => $expenses[$key] ?? 0
            ];
            
            if ($period === 'daily') {
                $current->addDay();
            } elseif ($period === 'weekly') {
                $current->addWeek();
            } else {
                $current->addMonth();
            }
        }
        
        return response()->json($dates);
    }

    /**
     * Get month comparison data for charts.
     */
    public function monthComparison()
    {
        $user = Auth::user();
        
        $currentMonth = now()->month;
        $previousMonth = now()->subMonth()->month;
        $currentYear = now()->year;
        $previousYear = now()->subMonth()->year;
        
        $currentMonthData = $user->expenses()
            ->where('type', 'expense')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->with('category')
            ->get()
            ->groupBy(function ($expense) {
                return $expense->category ? $expense->category->name : 'Uncategorized';
            })
            ->map(function ($group) {
                return abs($group->sum('amount'));
            });
            
        $previousMonthData = $user->expenses()
            ->where('type', 'expense')
            ->whereMonth('date', $previousMonth)
            ->whereYear('date', $previousYear)
            ->with('category')
            ->get()
            ->groupBy(function ($expense) {
                return $expense->category ? $expense->category->name : 'Uncategorized';
            })
            ->map(function ($group) {
                return abs($group->sum('amount'));
            });
            
        return response()->json([
            'current' => $currentMonthData,
            'previous' => $previousMonthData
        ]);
    }

    /**
     * Get savings progress data for charts.
     */
    public function savingsProgress()
    {
        $user = Auth::user();
        
        $savingsData = $user->savingsGoals()
            ->where('is_completed', false)
            ->get()
            ->map(function ($goal) {
                $percentage = min(100, ($goal->current_amount / max(1, $goal->target_amount)) * 100);
                
                return [
                    'name' => $goal->name,
                    'current' => $goal->current_amount,
                    'target' => $goal->target_amount,
                    'percentage' => round($percentage, 1),
                    'projected_completion' => $this->calculateProjectedCompletion($goal)
                ];
            });
            
        return response()->json($savingsData);
    }
}
