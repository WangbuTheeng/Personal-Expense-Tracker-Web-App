<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Expense') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('expenses.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Amount -->
                            <div>
                                <x-input-label for="amount" :value="__('Amount')" />
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400 sm:text-sm">NRs</span>
                                    </div>
                                    <x-text-input id="amount" class="block mt-1 w-full pl-7" type="number" step="0.01" name="amount" :value="old('amount')" required autofocus />
                                </div>
                                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                            </div>

                            <!-- Date -->
                            <div>
                                <x-input-label for="date" :value="__('Date')" />
                                <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date', date('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('date')" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <x-input-label for="description" :value="__('Description')" />
                                <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description')" required />
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <!-- Category -->
                            <div>
                                <x-input-label for="category_id" :value="__('Category')" />
                                <select id="category_id" name="category_id" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                    <option value="">{{ __('-- Select Category --') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>

                            <!-- Is Recurring -->
                            <div>
                                <div class="flex items-start mt-1">
                                    <div class="flex items-center h-5">
                                        <input id="is_recurring" name="is_recurring" type="checkbox" value="1" {{ old('is_recurring') ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="is_recurring" class="font-medium text-gray-700 dark:text-gray-300">{{ __('This is a recurring expense') }}</label>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('is_recurring')" class="mt-2" />
                            </div>

                            <!-- Recurring Frequency -->
                            <div class="md:col-span-2 hidden" id="recurring_frequency_container">
                                <x-input-label for="recurring_frequency" :value="__('Recurring Frequency')" />
                                <select id="recurring_frequency" name="recurring_frequency" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                    <option value="daily" {{ old('recurring_frequency') == 'daily' ? 'selected' : '' }}>{{ __('Daily') }}</option>
                                    <option value="weekly" {{ old('recurring_frequency') == 'weekly' ? 'selected' : '' }}>{{ __('Weekly') }}</option>
                                    <option value="biweekly" {{ old('recurring_frequency') == 'biweekly' ? 'selected' : '' }}>{{ __('Biweekly') }}</option>
                                    <option value="monthly" {{ old('recurring_frequency') == 'monthly' ? 'selected' : '' }}>{{ __('Monthly') }}</option>
                                    <option value="quarterly" {{ old('recurring_frequency') == 'quarterly' ? 'selected' : '' }}>{{ __('Quarterly') }}</option>
                                    <option value="yearly" {{ old('recurring_frequency') == 'yearly' ? 'selected' : '' }}>{{ __('Yearly') }}</option>
                                </select>
                                <x-input-error :messages="$errors->get('recurring_frequency')" class="mt-2" />
                            </div>

                            <!-- Notes -->
                            <div class="md:col-span-2">
                                <x-input-label for="notes" :value="__('Notes (Optional)')" />
                                <textarea id="notes" name="notes" rows="3" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">{{ old('notes') }}</textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('expenses.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:bg-gray-300 dark:focus:bg-gray-600 active:bg-gray-400 dark:active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 me-2">
                                {{ __('Cancel') }}
                            </a>

                            <x-primary-button>
                                {{ __('Save Expense') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isRecurringCheckbox = document.getElementById('is_recurring');
            const recurringFrequencyContainer = document.getElementById('recurring_frequency_container');

            function toggleRecurringFrequency() {
                if (isRecurringCheckbox.checked) {
                    recurringFrequencyContainer.classList.remove('hidden');
                } else {
                    recurringFrequencyContainer.classList.add('hidden');
                }
            }

            // Initial toggle
            toggleRecurringFrequency();

            // Listen for changes
            isRecurringCheckbox.addEventListener('change', toggleRecurringFrequency);
        });
    </script>
    @endpush
</x-app-layout> 