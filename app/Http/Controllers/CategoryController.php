<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoryController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $categories = Auth::user()->categories()->withCount('expenses')->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:categories,name,NULL,id,user_id,' . Auth::id(),
            'color' => 'required|string|max:7',
            'icon' => 'nullable|string|max:50',
            'type' => 'required|string|in:income,expense,both',
        ]);

        Auth::user()->categories()->create($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): View
    {
        $this->authorize('view', $category);
        $expenses = $category->expenses()->paginate(10);
        return view('categories.show', compact('category', 'expenses'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): View
    {
        $this->authorize('update', $category);
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $this->authorize('update', $category);
        
        $request->validate([
            'name' => 'required|string|max:50|unique:categories,name,' . $category->id . ',id,user_id,' . Auth::id(),
            'color' => 'required|string|max:7',
            'icon' => 'nullable|string|max:50',
            'type' => 'required|string|in:income,expense,both',
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $this->authorize('delete', $category);
        
        // Check if there are expenses in this category
        $expenseCount = $category->expenses()->count();
        
        if ($expenseCount > 0) {
            return back()->with('error', 'Cannot delete category with expenses. Please remove or reassign the expenses first.');
        }
        
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
