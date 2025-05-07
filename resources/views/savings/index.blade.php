<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Savings Goals') }}
            </h2>
            <a href="{{ route('savings.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-plus mr-2"></i>{{ __('Add Goal') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($savingsGoals->count())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($savingsGoals as $goal)
                                <div class="bg-white dark:bg-gray-700 rounded-lg shadow p-6">
                                    <div class="flex justify-between items-start mb-4">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $goal->name }}</h3>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('savings.edit', $goal) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('savings.destroy', $goal) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <div class="flex justify-between text-sm mb-1">
                                            <span class="text-gray-600 dark:text-gray-300">Progress</span>
                                            <span class="text-gray-900 dark:text-gray-100">{{ number_format($goal->getProgressPercentage(), 1) }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-600">
                                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $goal->getProgressPercentage() }}%"></div>
                                        </div>
                                    </div>

                                    <div class="space-y-2 text-sm">
                                        <p class="text-gray-600 dark:text-gray-300">
                                            Current: <span class="text-gray-900 dark:text-gray-100">₹{{ number_format($goal->current_amount, 2) }}</span>
                                        </p>
                                        <p class="text-gray-600 dark:text-gray-300">
                                            Target: <span class="text-gray-900 dark:text-gray-100">₹{{ number_format($goal->target_amount, 2) }}</span>
                                        </p>
                                        @if($goal->target_date)
                                            <p class="text-gray-600 dark:text-gray-300">
                                                Target Date: <span class="text-gray-900 dark:text-gray-100">{{ $goal->target_date->format('M d, Y') }}</span>
                                            </p>
                                        @endif
                                        @if($prediction = $goal->predictCompletionDate())
                                            <p class="text-gray-600 dark:text-gray-300">
                                                Estimated Completion: <span class="text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($prediction)->format('M d, Y') }}</span>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            {{ $savingsGoals->links() }}
                        </div>
                    @else
                        <div class="text-center p-6">
                            <div class="text-lg font-medium text-gray-600 dark:text-gray-400 mb-4">{{ __('No savings goals found') }}</div>
                            <p class="mb-4">{{ __('Start by adding your first savings goal to track your progress.') }}</p>
                            <a href="{{ route('savings.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Add Goal') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>