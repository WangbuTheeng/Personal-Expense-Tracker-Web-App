<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Budget Details') }}: {{ $budget->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Budget Details Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-2xl font-semibold mb-2">{{ $budget->name }}</h3>
                            <div class="text-gray-500 dark:text-gray-400">
                                {{ ucfirst($budget->period) }} Budget
                                @if ($budget->category)
                                    for 
                                    <span class="inline-flex items-center">
                                        <span class="w-3 h-3 rounded-full mr-1" style="background-color: {{ $budget->category->color }}"></span>
                                        {{ $budget->category->name }}
                                    </span>
                                @else
                                    ({{ __('All Categories') }})
                                @endif
                            </div>
                            <div class="text-gray-500 dark:text-gray-400 mt-1">
                                {{ $budget->start_date->format('M d, Y') }} 
                                @if ($budget->end_date)
                                    - {{ $budget->end_date->format('M d, Y') }}
                                @else
                                    - {{ __('Ongoing') }}
                                @endif
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('budgets.edit', $budget) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Edit') }}
                            </a>
                            <form action="{{ route('budgets.destroy', $budget) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this budget?')" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Delete') }}
                                </button>
                            </form>
                        </div>
                    </div>

                    @if ($budget->description)
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ __('Description') }}</h4>
                            <p class="text-gray-900 dark:text-gray-100">{{ $budget->description }}</p>
                        </div>
                    @endif

                    <div class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Budget Amount') }}</div>
                                <div class="mt-1 text-2xl font-bold text-gray-900 dark:text-gray-100">NRs {{ number_format($budget->amount, 2) }}</div>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Amount Used') }}</div>
                                <div class="mt-1 text-2xl font-bold {{ $isOverBudget ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-gray-100' }}">NRs {{ number_format($usedAmount, 2) }}</div>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Remaining') }}</div>
                                <div class="mt-1 text-2xl font-bold {{ $isOverBudget ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                    {{ $isOverBudget ? '-' : '' }}NRs {{ number_format($remainingAmount, 2) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ __('Progress') }}</h4>
                        <div class="mt-1 w-full bg-gray-200 dark:bg-gray-600 rounded-full h-4">
                            <div class="h-4 rounded-full {{ $isOverBudget ? 'bg-red-500' : 'bg-indigo-600' }}" 
                                style="width: {{ min(100, $percentageUsed) }}%"></div>
                        </div>
                        <div class="flex justify-between mt-2 text-sm">
                            <div>{{ number_format($percentageUsed, 1) }}% {{ __('used') }}</div>
                            @if ($isOverBudget)
                                <div class="text-red-500 font-medium">
                                    {{ __('Over budget by') }} NRs {{ number_format($usedAmount - $budget->amount, 2) }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Expenses -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Related Expenses') }}</h3>

                    @if ($expenses->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Date') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Description') }}
                                        </th>
                                        @if (!$budget->category_id)
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                {{ __('Category') }}
                                            </th>
                                        @endif
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Amount') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ __('Actions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($expenses as $expense)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $expense->date->format('M d, Y') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $expense->description }}
                                                </div>
                                            </td>
                                            @if (!$budget->category_id)
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if ($expense->category)
                                                        <div class="flex items-center">
                                                            <div class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $expense->category->color }}"></div>
                                                            <div class="text-sm text-gray-900 dark:text-gray-100">
                                                                {{ $expense->category->name }}
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                                            {{ __('Uncategorized') }}
                                                        </div>
                                                    @endif
                                                </td>
                                            @endif
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    NRs {{ number_format($expense->amount, 2) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('expenses.show', $expense) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600">
                                                    {{ __('View') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            {{ $expenses->links() }}
                        </div>
                    @else
                        <div class="text-center p-6">
                            <p class="text-gray-500 dark:text-gray-400">{{ __('No expenses found for this budget period.') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('budgets.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:bg-gray-300 dark:focus:bg-gray-600 active:bg-gray-400 dark:active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Back to Budgets') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout> 