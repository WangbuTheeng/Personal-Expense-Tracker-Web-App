<?php

namespace App\Http\Controllers;

use App\Exports\ExpensesExport;
use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        $categories = Auth::user()->categories;
        return view('reports.index', compact('categories'));
    }

    public function exportExcel(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        $startDate = $validated['start_date'] ?? null;
        $endDate = $validated['end_date'] ?? null;
        $categoryId = $validated['category_id'] ?? null;
        
        $filename = 'expenses_' . now()->format('Y-m-d') . '.xlsx';
        
        return Excel::download(
            new ExpensesExport($startDate, $endDate, $categoryId), 
            $filename
        );
    }
    
    public function exportPdf(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        $query = Auth::user()->expenses()->with('category');
        
        if (!empty($validated['start_date']) && !empty($validated['end_date'])) {
            $query->whereBetween('date', [$validated['start_date'], $validated['end_date']]);
        }
        
        if (!empty($validated['category_id'])) {
            $query->where('category_id', $validated['category_id']);
        }
        
        $expenses = $query->latest('date')->get();
        $startDate = $validated['start_date'] ?? 'All time';
        $endDate = $validated['end_date'] ?? 'Present';
        $category = null;
        
        if (!empty($validated['category_id'])) {
            $category = Category::find($validated['category_id'])->name;
        }
        
        $pdf = PDF::loadView('reports.pdf', compact('expenses', 'startDate', 'endDate', 'category'));
        
        return $pdf->download('expenses_report_' . now()->format('Y-m-d') . '.pdf');
    }
} 