<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $expenses = Auth::user()->expenses()->with('category')->latest()->paginate(10);
        return view('expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Auth::user()->categories()->get();
        return view('expenses.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'date' => 'required|date',
            'category_id' => 'nullable|exists:categories,id',
            'notes' => 'nullable|string',
            'is_recurring' => 'boolean',
            'recurring_frequency' => 'required_if:is_recurring,1|nullable|string',
        ]);

        Auth::user()->expenses()->create($request->all());

        return redirect()->route('expenses.index')
            ->with('success', 'Expense created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense): View
    {
        $this->authorize('view', $expense);
        return view('expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense): View
    {
        $this->authorize('update', $expense);
        $categories = Auth::user()->categories()->get();
        return view('expenses.edit', compact('expense', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense): RedirectResponse
    {
        $this->authorize('update', $expense);

        $request->validate([
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'date' => 'required|date',
            'category_id' => 'nullable|exists:categories,id',
            'notes' => 'nullable|string',
            'is_recurring' => 'boolean',
            'recurring_frequency' => 'required_if:is_recurring,1|nullable|string',
        ]);

        $expense->update($request->all());

        return redirect()->route('expenses.index')
            ->with('success', 'Expense updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense): RedirectResponse
    {
        $this->authorize('delete', $expense);
        $expense->delete();

        return redirect()->route('expenses.index')
            ->with('success', 'Expense deleted successfully.');
    }
}
