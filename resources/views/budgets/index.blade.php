<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Budgets') }}
            </h2>
            <a href="{{ route('budgets.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Create Budget') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Session Status -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (count($budgets) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($budgets as $budget)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <a href="{{ route('budgets.show', $budget) }}" class="text-xl font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                                            {{ $budget->name }}
                                        </a>
                                        <div class="text-gray-500 dark:text-gray-400 text-sm">
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
                                        <div class="text-gray-500 dark:text-gray-400 text-sm">
                                            {{ $budget->start_date->format('M d, Y') }} 
                                            @if ($budget->end_date)
                                                - {{ $budget->end_date->format('M d, Y') }}
                                            @else
                                                - {{ __('Ongoing') }}
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <div class="inline-flex">
                                            <a href="{{ route('budgets.edit', $budget) }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 mr-3">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('budgets.destroy', $budget) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this budget?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Progress bar -->
                                <div class="mb-2">
                                    <div class="w-full h-4 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                        <div class="h-full {{ $budget->isOverBudget ? 'bg-red-500' : 'bg-green-500' }}" style="width: {{ $budget->percentageUsed }}%"></div>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between items-center">
                                    <div>
                                        <div class="text-xl font-bold">NRs {{ number_format($budget->amount, 2) }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            <span>NRs {{ number_format($budget->usedAmount, 2) }} spent</span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-right">
                                            @if ($budget->isOverBudget)
                                                <div class="text-sm text-red-500 dark:text-red-400">
                                                    {{ __('Over budget by') }} NRs {{ number_format($budget->usedAmount - $budget->amount, 2) }}
                                                </div>
                                            @else
                                                <div class="text-sm text-green-500 dark:text-green-400">
                                                    NRs {{ number_format($budget->amount - $budget->usedAmount, 2) }} {{ __('remaining') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                        <p class="mb-4">{{ __('No budgets found. Create your first budget to start tracking your spending!') }}</p>
                        <a href="{{ route('budgets.create') }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Create First Budget') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout> 