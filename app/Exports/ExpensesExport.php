<?php

namespace App\Exports;

use App\Models\Expense;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Auth;

class ExpensesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;
    protected $categoryId;

    public function __construct($startDate = null, $endDate = null, $categoryId = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->categoryId = $categoryId;
    }

    public function collection()
    {
        $query = Auth::user()->expenses()->with('category');

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('date', [$this->startDate, $this->endDate]);
        }

        if ($this->categoryId) {
            $query->where('category_id', $this->categoryId);
        }

        return $query->latest('date')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Date',
            'Description',
            'Amount (₹)',
            'Category',
            'Notes'
        ];
    }

    public function map($expense): array
    {
        return [
            $expense->id,
            $expense->date->format('Y-m-d'),
            $expense->description,
            $expense->amount < 0 ? abs($expense->amount) : $expense->amount,
            $expense->category->name ?? 'Uncategorized',
            $expense->notes ?? ''
        ];
    }
} 