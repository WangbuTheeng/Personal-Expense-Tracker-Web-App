<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $budgets = Auth::user()->budgets()->with('category')->get();
        
        // Calculate used amount for each budget
        $budgets = $budgets->map(function($budget) {
            $budget->usedAmount = $budget->getUsedAmount();
            $budget->percentageUsed = $budget->getPercentageUsed();
            $budget->remainingAmount = $budget->getRemainingAmount();
            $budget->isOverBudget = $budget->isOverBudget();
            return $budget;
        });
        
        return view('budgets.index', compact('budgets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Auth::user()->categories()->get();
        return view('budgets.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'period' => 'required|string|in:weekly,monthly,yearly',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
        ]);

        Auth::user()->budgets()->create($request->all());

        return redirect()->route('budgets.index')
            ->with('success', 'Budget created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Budget $budget): View
    {
        $this->authorize('view', $budget);
        
        // Calculate used amount and percentage
        $usedAmount = $budget->getUsedAmount();
        $percentageUsed = $budget->getPercentageUsed();
        $remainingAmount = $budget->getRemainingAmount();
        $isOverBudget = $budget->isOverBudget();
        
        // Get related expenses
        $expenses = [];
        $query = Auth::user()->expenses()->with('category')
            ->whereBetween('date', [$budget->start_date, $budget->end_date ?? now()]);
        
        if ($budget->category_id) {
            $query->where('category_id', $budget->category_id);
        }
        
        $expenses = $query->paginate(10);
        
        return view('budgets.show', compact('budget', 'usedAmount', 'percentageUsed', 'remainingAmount', 'isOverBudget', 'expenses'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Budget $budget): View
    {
        $this->authorize('update', $budget);
        $categories = Auth::user()->categories()->get();
        return view('budgets.edit', compact('budget', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Budget $budget): RedirectResponse
    {
        $this->authorize('update', $budget);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'period' => 'required|string|in:weekly,monthly,yearly',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
        ]);

        $budget->update($request->all());

        return redirect()->route('budgets.index')
            ->with('success', 'Budget updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget): RedirectResponse
    {
        $this->authorize('delete', $budget);
        $budget->delete();

        return redirect()->route('budgets.index')
            ->with('success', 'Budget deleted successfully.');
    }
}
