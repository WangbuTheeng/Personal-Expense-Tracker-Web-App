<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Expense Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        h1 {
            color: #4F46E5;
            font-size: 24px;
            margin-bottom: 5px;
        }
        .subtitle {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
        }
        .meta {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9fafb;
            border-radius: 5px;
        }
        .meta p {
            margin: 5px 0;
            font-size: 13px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th {
            background-color: #4F46E5;
            color: white;
            font-weight: bold;
            text-align: left;
            padding: 10px;
            font-size: 14px;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            font-size: 13px;
        }
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .summary {
            margin-top: 30px;
            text-align: right;
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            font-size: 12px;
            text-align: center;
            color: #666;
        }
        .income {
            color: #10B981;
        }
        .expense {
            color: #EF4444;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Expense Report</h1>
        <div class="subtitle">Personal Expense Tracker</div>
    </div>
    
    <div class="meta">
        <p><strong>Report Period:</strong> {{ $startDate }} to {{ $endDate }}</p>
        @if($category)
        <p><strong>Category:</strong> {{ $category }}</p>
        @else
        <p><strong>Category:</strong> All Categories</p>
        @endif
        <p><strong>Generated On:</strong> {{ now()->format('F d, Y h:i A') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Category</th>
                <th>Amount (₹)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalIncome = 0;
                $totalExpense = 0;
            @endphp
            
            @forelse ($expenses as $expense)
                <tr>
                    <td>{{ $expense->date->format('Y-m-d') }}</td>
                    <td>{{ $expense->description }}</td>
                    <td>{{ $expense->category->name ?? 'Uncategorized' }}</td>
                    <td class="{{ $expense->amount > 0 ? 'income' : 'expense' }}">
                        {{ $expense->amount > 0 ? '+' : '-' }} ₹{{ number_format(abs($expense->amount), 2) }}
                    </td>
                </tr>
                @php
                    if($expense->amount > 0) {
                        $totalIncome += $expense->amount;
                    } else {
                        $totalExpense += abs($expense->amount);
                    }
                @endphp
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">No expense records found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="summary">
        <p>Total Income: <span class="income">₹{{ number_format($totalIncome, 2) }}</span></p>
        <p>Total Expenses: <span class="expense">₹{{ number_format($totalExpense, 2) }}</span></p>
        <p>Net: <span class="{{ $totalIncome - $totalExpense >= 0 ? 'income' : 'expense' }}">₹{{ number_format($totalIncome - $totalExpense, 2) }}</span></p>
    </div>
    
    <div class="footer">
        <p>This report was generated from Personal Expense Tracker.</p>
    </div>
</body>
</html> 