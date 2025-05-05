<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Budget') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('budgets.update', $budget) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div class="md:col-span-2">
                                <x-input-label for="name" :value="__('Budget Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $budget->name)" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Amount -->
                            <div>
                                <x-input-label for="amount" :value="__('Amount')" />
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400 sm:text-sm">NRs</span>
                                    </div>
                                    <x-text-input id="amount" class="block mt-1 w-full pl-7" type="number" step="0.01" name="amount" :value="old('amount', $budget->amount)" required />
                                </div>
                                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                            </div>

                            <!-- Period -->
                            <div>
                                <x-input-label for="period" :value="__('Budget Period')" />
                                <select id="period" name="period" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                    <option value="weekly" {{ old('period', $budget->period) == 'weekly' ? 'selected' : '' }}>{{ __('Weekly') }}</option>
                                    <option value="monthly" {{ old('period', $budget->period) == 'monthly' ? 'selected' : '' }}>{{ __('Monthly') }}</option>
                                    <option value="yearly" {{ old('period', $budget->period) == 'yearly' ? 'selected' : '' }}>{{ __('Yearly') }}</option>
                                </select>
                                <x-input-error :messages="$errors->get('period')" class="mt-2" />
                            </div>

                            <!-- Start Date -->
                            <div>
                                <x-input-label for="start_date" :value="__('Start Date')" />
                                <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" :value="old('start_date', $budget->start_date->format('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                            </div>

                            <!-- End Date (Optional) -->
                            <div>
                                <x-input-label for="end_date" :value="__('End Date (Optional)')" />
                                <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" :value="old('end_date', $budget->end_date ? $budget->end_date->format('Y-m-d') : null)" />
                                <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Leave blank for ongoing budgets') }}</div>
                                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                            </div>

                            <!-- Category -->
                            <div class="md:col-span-2">
                                <x-input-label for="category_id" :value="__('Category (Optional)')" />
                                <select id="category_id" name="category_id" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">
                                    <option value="">{{ __('All Categories (Overall Budget)') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $budget->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Select a category or leave blank for an overall budget') }}</div>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <x-input-label for="description" :value="__('Description (Optional)')" />
                                <textarea id="description" name="description" rows="3" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">{{ old('description', $budget->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('budgets.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:bg-gray-300 dark:focus:bg-gray-600 active:bg-gray-400 dark:active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 me-2">
                                {{ __('Cancel') }}
                            </a>

                            <x-primary-button>
                                {{ __('Update Budget') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 