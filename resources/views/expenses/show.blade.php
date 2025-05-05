<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Expense Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <div class="flex justify-between mb-6">
                            <h3 class="text-2xl font-semibold">{{ $expense->description }}</h3>
                            <div class="flex space-x-2">
                                <a href="{{ route('expenses.edit', $expense) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Edit') }}
                                </a>
                                <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this expense?')" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        {{ __('Delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Amount') }}</div>
                                <div class="mt-1 text-2xl font-bold text-gray-900 dark:text-gray-100">NRs {{ number_format($expense->amount, 2) }}</div>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Date') }}</div>
                                <div class="mt-1 text-lg font-medium text-gray-900 dark:text-gray-100">{{ $expense->date->format('F j, Y') }}</div>
                            </div>
                            
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Category') }}</div>
                                <div class="mt-1 font-medium text-gray-900 dark:text-gray-100">
                                    @if ($expense->category)
                                        <div class="flex items-center">
                                            <div class="w-4 h-4 rounded-full mr-2" style="background-color: {{ $expense->category->color }}"></div>
                                            <span>{{ $expense->category->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-500 dark:text-gray-400">{{ __('Uncategorized') }}</span>
                                    @endif
                                </div>
                            </div>

                            @if ($expense->is_recurring)
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Recurring') }}</div>
                                <div class="mt-1 font-medium text-gray-900 dark:text-gray-100">
                                    {{ __(ucfirst($expense->recurring_frequency)) }}
                                </div>
                            </div>
                            @endif
                        </div>

                        @if ($expense->notes)
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6">
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ __('Notes') }}</div>
                            <div class="text-gray-900 dark:text-gray-100 whitespace-pre-line">{{ $expense->notes }}</div>
                        </div>
                        @endif

                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Created') }}: {{ $expense->created_at->format('F j, Y, g:i a') }}
                            </div>
                            @if($expense->created_at != $expense->updated_at)
                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {{ __('Last Updated') }}: {{ $expense->updated_at->format('F j, Y, g:i a') }}
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex justify-between mt-6">
                        <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:bg-gray-300 dark:focus:bg-gray-600 active:bg-gray-400 dark:active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Back') }}
                        </a>
                        <a href="{{ route('expenses.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('All Expenses') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 