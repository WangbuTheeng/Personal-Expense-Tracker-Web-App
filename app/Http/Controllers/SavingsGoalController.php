<?php

namespace App\Http\Controllers;

use App\Models\SavingsGoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SavingsGoalController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $savingsGoals = Auth::user()->savingsGoals()->latest()->paginate(10);
        return view('savings.index', compact('savingsGoals'));
    }

    public function create()
    {
        $savingsGoal = new SavingsGoal();
        return view('savings.create', compact('savingsGoal'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0',
            'current_amount' => 'numeric|min:0',
            'target_date' => 'nullable|date',
            'description' => 'nullable|string|max:1000',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['current_amount'] = $validated['current_amount'] ?? 0;

        Auth::user()->savingsGoals()->create($validated);

        return redirect()->route('savings.index')
            ->with('success', 'Savings goal created successfully.');
    }

    public function show(SavingsGoal $savingsGoal)
    {
        $this->authorize('view', $savingsGoal);
        return view('savings.show', compact('savingsGoal'));
    }

    public function edit(SavingsGoal $savingsGoal)
    {
        $this->authorize('update', $savingsGoal);
        return view('savings.edit', compact('savingsGoal'));
    }

    public function update(Request $request, SavingsGoal $savingsGoal)
    {
        $this->authorize('update', $savingsGoal);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0',
            'current_amount' => 'required|numeric|min:0',
            'target_date' => 'nullable|date',
            'description' => 'nullable|string|max:1000',
            'is_completed' => 'boolean',
        ]);

        $savingsGoal->update($validated);

        return redirect()->route('savings.index')
            ->with('success', 'Savings goal updated successfully.');
    }

    public function destroy(SavingsGoal $savingsGoal)
    {
        $this->authorize('delete', $savingsGoal);
        
        $savingsGoal->delete();

        return redirect()->route('savings.index')
            ->with('success', 'Savings goal deleted successfully.');
    }
}
