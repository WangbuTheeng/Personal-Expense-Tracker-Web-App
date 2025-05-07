<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Top Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('This Month') }}</h3>
                        <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                            NRs {{ number_format($monthlyTotal ?? 0, 2) }}
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Daily Average') }}</h3>
                        <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                            NRs {{ number_format($dailyAverage ?? 0, 2) }}
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total Categories') }}</h3>
                        <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $totalCategories ?? 0 }}
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Active Goals') }}</h3>
                        <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $activeGoals ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Monthly Overview Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Monthly Overview</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="p-4 bg-green-100 dark:bg-green-900 rounded-lg">
                            <p class="text-sm text-green-600 dark:text-green-400">Total Income</p>
                            <p class="text-2xl font-bold text-green-700 dark:text-green-300">NRs {{ number_format($monthlyIncome, 2) }}</p>
                        </div>
                        <div class="p-4 bg-red-100 dark:bg-red-900 rounded-lg">
                            <p class="text-sm text-red-600 dark:text-red-400">Total Expenses</p>
                            <p class="text-2xl font-bold text-red-700 dark:text-red-300">NRs {{ number_format($monthlyExpenses, 2) }}</p>
                        </div>
                        <div class="p-4 bg-blue-100 dark:bg-blue-900 rounded-lg">
                            <p class="text-sm text-blue-600 dark:text-blue-400">Net Savings</p>
                            <p class="text-2xl font-bold text-blue-700 dark:text-blue-300">NRs {{ number_format($monthlyNetSavings, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Weekly Overview Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Weekly Overview (This Week)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="p-4 bg-green-100 dark:bg-green-900 rounded-lg">
                            <p class="text-sm text-green-600 dark:text-green-400">Total Income</p>
                            <p class="text-2xl font-bold text-green-700 dark:text-green-300">NRs {{ number_format($weeklyIncome, 2) }}</p>
                        </div>
                        <div class="p-4 bg-red-100 dark:bg-red-900 rounded-lg">
                            <p class="text-sm text-red-600 dark:text-red-400">Total Expenses</p>
                            <p class="text-2xl font-bold text-red-700 dark:text-red-300">NRs {{ number_format($weeklyExpenses, 2) }}</p>
                        </div>
                        <div class="p-4 bg-blue-100 dark:bg-blue-900 rounded-lg">
                            <p class="text-sm text-blue-600 dark:text-blue-400">Net Savings</p>
                            <p class="text-2xl font-bold text-blue-700 dark:text-blue-300">NRs {{ number_format($weeklyNetSavings, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daily Overview Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Daily Overview (Today)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="p-4 bg-green-100 dark:bg-green-900 rounded-lg">
                            <p class="text-sm text-green-600 dark:text-green-400">Total Income</p>
                            <p class="text-2xl font-bold text-green-700 dark:text-green-300">NRs {{ number_format($dailyIncome, 2) }}</p>
                        </div>
                        <div class="p-4 bg-red-100 dark:bg-red-900 rounded-lg">
                            <p class="text-sm text-red-600 dark:text-red-400">Total Expenses</p>
                            <p class="text-2xl font-bold text-red-700 dark:text-red-300">NRs {{ number_format($dailyExpenses, 2) }}</p>
                        </div>
                        <div class="p-4 bg-blue-100 dark:bg-blue-900 rounded-lg">
                            <p class="text-sm text-blue-600 dark:text-blue-400">Net Savings</p>
                            <p class="text-2xl font-bold text-blue-700 dark:text-blue-300">NRs {{ number_format($dailyNetSavings, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            {{ __('Recent Transactions') }}
                        </h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('reports.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                {{ __('Export') }}
                            </a>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($recentTransactions as $transaction)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                            {{ $transaction->date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                            {{ $transaction->category->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                            {{ $transaction->description }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm {{ $transaction->amount < 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                            ₹{{ number_format(abs($transaction->amount), 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Expense Breakdown -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Expense Breakdown</h3>
                    <div class="h-64" id="expense-chart"></div>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Category Distribution -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            {{ __('Expense Distribution') }}
                        </h3>
                        <div class="relative" style="height: 300px;">
                            <canvas id="category-chart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Month Comparison -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            {{ __('Month Comparison') }}
                        </h3>
                        <div class="relative" style="height: 300px;">
                            <canvas id="comparison-chart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Expense Trends -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg col-span-1 lg:col-span-2">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                <span id="trend-title">{{ __('Monthly Expense Trends') }}</span>
                            </h3>
                            <div class="flex items-center space-x-2">
                                <label for="trend-period" class="text-sm text-gray-600 dark:text-gray-400">View by:</label>
                                <select id="trend-period" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                    <option value="daily">Daily</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly" selected>Monthly</option>
                                </select>
                            </div>
                        </div>
                        <div class="relative" style="height: 300px;">
                            <canvas id="trend-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Savings Goals -->
            @if(isset($savingsData) && count($savingsData) > 0)
            <div class="mt-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            {{ __('Savings Goals Progress') }}
                        </h3>
                        <div class="space-y-4" id="savings-progress">
                            @foreach($savingsData as $index => $goal)
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $goal->name }}</span>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        NRs {{ number_format($goal->current, 2) }} / NRs {{ number_format($goal->target, 2) }}
                                    </span>
                                </div>
                                <div class="relative" style="height: 30px;">
                                    <canvas id="savings-progress-{{ $index }}"></canvas>
                                </div>
                                @if($goal->projected_completion)
                                <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('Projected completion') }}: {{ $goal->projected_completion }}
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        // Initialize the expense breakdown chart
        document.addEventListener('DOMContentLoaded', function() {
            const chartOptions = {
                chart: {
                    type: 'pie',
                    height: 250,
                    background: 'transparent',
                    theme: {
                        mode: localStorage.getItem('darkMode') === 'true' ? 'dark' : 'light'
                    }
                },
                series: @json($expenseData->pluck('total')->toArray()),
                labels: @json($expenseData->pluck('category')->toArray()),
                colors: ['#4F46E5', '#7C3AED', '#EC4899', '#F59E0B', '#10B981', '#3B82F6'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            if (typeof ApexCharts !== 'undefined') {
                const chart = new ApexCharts(document.querySelector("#expense-chart"), chartOptions);
                chart.render();
                
                // Update chart theme when dark mode changes
                document.addEventListener('alpine:init', () => {
                    Alpine.effect(() => {
                        const isDark = localStorage.getItem('darkMode') === 'true';
                        chart.updateOptions({
                            theme: {
                                mode: isDark ? 'dark' : 'light'
                            }
                        });
                    });
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
