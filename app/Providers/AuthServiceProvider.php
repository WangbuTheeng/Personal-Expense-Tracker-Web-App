<?php

namespace App\Providers;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Expense;
use App\Models\SavingsGoal;
use App\Policies\BudgetPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\ExpensePolicy;
use App\Policies\SavingsGoalPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Category::class => CategoryPolicy::class,
        Expense::class => ExpensePolicy::class,
        Budget::class => BudgetPolicy::class,
        SavingsGoal::class => SavingsGoalPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
} 