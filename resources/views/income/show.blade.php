<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Income Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('income.edit', $income) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    {{ __('Edit') }}
                </a>
                <form action="{{ route('income.destroy', $income) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" onclick="return confirm('Are you sure you want to delete this income?')">
                        {{ __('Delete') }}
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="max-w-3xl mx-auto">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Details Card -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg">
                                <h3 class="text-lg font-medium mb-4 text-gray-900 dark:text-gray-100">{{ __('Basic Information') }}</h3>
                                
                                <div class="mb-4">
                                    <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Description') }}</span>
                                    <span class="block mt-1 text-gray-900 dark:text-gray-100">{{ $income->description }}</span>
                                </div>
                                
                                <div class="mb-4">
                                    <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Amount') }}</span>
                                    <span class="block mt-1 text-green-600 dark:text-green-400 font-bold text-lg">₹{{ number_format($income->amount, 2) }}</span>
                                </div>
                                
                                <div class="mb-4">
                                    <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Date') }}</span>
                                    <span class="block mt-1 text-gray-900 dark:text-gray-100">{{ $income->date->format('F d, Y') }}</span>
                                </div>
                                
                                <div class="mb-4">
                                    <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Category') }}</span>
                                    <span class="inline-block mt-1 px-2 py-1 rounded text-xs font-medium" style="background-color: {{ $income->category->color }}; color: {{ $income->category->text_color }};">
                                        {{ $income->category->name }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Additional Details Card -->
                            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg">
                                <h3 class="text-lg font-medium mb-4 text-gray-900 dark:text-gray-100">{{ __('Additional Information') }}</h3>
                                
                                @if($income->notes)
                                <div class="mb-4">
                                    <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Notes') }}</span>
                                    <div class="block mt-1 text-gray-900 dark:text-gray-100 whitespace-pre-line">{{ $income->notes }}</div>
                                </div>
                                @endif
                                
                                <div class="mb-4">
                                    <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Recurring Income') }}</span>
                                    <span class="block mt-1 text-gray-900 dark:text-gray-100">
                                        @if($income->is_recurring)
                                            <span class="text-green-600 dark:text-green-400">{{ __('Yes') }}</span> - {{ ucfirst($income->recurring_frequency) }}
                                        @else
                                            <span class="text-red-600 dark:text-red-400">{{ __('No') }}</span>
                                        @endif
                                    </span>
                                </div>
                                
                                <div class="mb-4">
                                    <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Created On') }}</span>
                                    <span class="block mt-1 text-gray-900 dark:text-gray-100">{{ $income->created_at->format('F d, Y h:i A') }}</span>
                                </div>
                                
                                <div class="mb-4">
                                    <span class="block text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Last Updated') }}</span>
                                    <span class="block mt-1 text-gray-900 dark:text-gray-100">{{ $income->updated_at->format('F d, Y h:i A') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 text-right">
                            <a href="{{ route('income.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 focus:bg-gray-400 dark:focus:bg-gray-600 active:bg-gray-500 dark:active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Back to Income List') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 