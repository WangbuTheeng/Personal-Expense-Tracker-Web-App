<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class IncomeController extends Controller
{
    /**
     * Display a listing of the income records.
     */
    public function index(): View
    {
        $user = Auth::user();
        $incomes = $user->expenses()
            ->where('type', 'income')
            ->with('category')
            ->orderBy('date', 'desc')
            ->paginate(10);
            
        $categories = $user->categories()
            ->where(function($query) {
                $query->where('type', 'income')
                      ->orWhere('type', 'both');
            })
            ->orderBy('name')
            ->get();
        
        return view('income.index', compact('incomes', 'categories'));
    }

    /**
     * Show the form for creating a new income record.
     */
    public function create(): View
    {
        $categories = Auth::user()->categories()
            ->where(function($query) {
                $query->where('type', 'income')
                      ->orWhere('type', 'both');
            })
            ->orderBy('name')
            ->get();
        
        return view('income.create', compact('categories'));
    }

    /**
     * Store a newly created income record in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'date' => 'required|date',
            'notes' => 'nullable|string',
            'is_recurring' => 'sometimes|boolean',
            'recurring_frequency' => 'required_if:is_recurring,1|in:weekly,monthly,yearly',
        ]);
        
        // Make sure amount is positive for income
        $validated['amount'] = abs($validated['amount']);
        // Set type as income
        $validated['type'] = 'income';
        
        $user = Auth::user();
        $validated['user_id'] = $user->id;
        
        Expense::create($validated);
        
        return redirect()->route('income.index')
            ->with('success', 'Income added successfully.');
    }

    /**
     * Display the specified income record.
     */
    public function show(Expense $income): View
    {
        // Confirm it belongs to the authenticated user
        $this->authorize('view', $income);
        
        return view('income.show', compact('income'));
    }

    /**
     * Show the form for editing the specified income record.
     */
    public function edit(Expense $income): View
    {
        // Confirm it belongs to the authenticated user
        $this->authorize('update', $income);
        
        $categories = Auth::user()->categories()
            ->where(function($query) {
                $query->where('type', 'income')
                      ->orWhere('type', 'both');
            })
            ->orderBy('name')
            ->get();
        
        return view('income.edit', compact('income', 'categories'));
    }

    /**
     * Update the specified income record in storage.
     */
    public function update(Request $request, Expense $income)
    {
        // Confirm it belongs to the authenticated user
        $this->authorize('update', $income);
        
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'date' => 'required|date',
            'notes' => 'nullable|string',
            'is_recurring' => 'sometimes|boolean',
            'recurring_frequency' => 'required_if:is_recurring,1|in:weekly,monthly,yearly',
        ]);
        
        // Make sure amount is positive for income
        $validated['amount'] = abs($validated['amount']);
        // Set type as income
        $validated['type'] = 'income';
        
        $income->update($validated);
        
        return redirect()->route('income.index')
            ->with('success', 'Income updated successfully.');
    }

    /**
     * Remove the specified income record from storage.
     */
    public function destroy(Expense $income)
    {
        // Confirm it belongs to the authenticated user
        $this->authorize('delete', $income);
        
        $income->delete();
        
        return redirect()->route('income.index')
            ->with('success', 'Income deleted successfully.');
    }
} 