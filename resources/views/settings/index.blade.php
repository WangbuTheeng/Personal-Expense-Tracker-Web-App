<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-6 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 mb-6 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('info') }}</span>
                        </div>
                    @endif

                    <div x-data="{ activeTab: 'general' }">
                        <!-- Tabs -->
                        <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                                <li class="mr-2">
                                    <a href="#" 
                                        @click.prevent="activeTab = 'general'"
                                        :class="activeTab === 'general' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-500' : 'border-transparent hover:border-gray-300 text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300'"
                                        class="inline-flex items-center p-4 border-b-2 rounded-t-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ __('General') }}
                                    </a>
                                </li>
                                <li class="mr-2">
                                    <a href="#" 
                                        @click.prevent="activeTab = 'notifications'"
                                        :class="activeTab === 'notifications' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-500' : 'border-transparent hover:border-gray-300 text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300'"
                                        class="inline-flex items-center p-4 border-b-2 rounded-t-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                        {{ __('Notifications') }}
                                    </a>
                                </li>
                                <li class="mr-2">
                                    <a href="#" 
                                        @click.prevent="activeTab = 'recurring'"
                                        :class="activeTab === 'recurring' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-500' : 'border-transparent hover:border-gray-300 text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300'"
                                        class="inline-flex items-center p-4 border-b-2 rounded-t-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        {{ __('Recurring Expenses') }}
                                    </a>
                                </li>
                                <li class="mr-2">
                                    <a href="#" 
                                        @click.prevent="activeTab = 'export'"
                                        :class="activeTab === 'export' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-500' : 'border-transparent hover:border-gray-300 text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300'"
                                        class="inline-flex items-center p-4 border-b-2 rounded-t-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                        </svg>
                                        {{ __('Import/Export') }}
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Tab Content -->
                        <div>
                            <!-- General Settings -->
                            <div x-show="activeTab === 'general'" x-transition>
                                <form method="POST" action="{{ route('settings.update') }}" class="max-w-2xl mx-auto">
                                    @csrf
                                    <div class="space-y-6">
                                        <div>
                                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">{{ __('Regional Settings') }}</h3>
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Customize your date format and currency preferences.') }}</p>
                                        </div>

                                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                            <!-- Currency -->
                                            <div>
                                                <x-input-label for="currency" :value="__('Currency')" />
                                                <select id="currency" name="currency" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                                    @foreach($currencies as $code => $details)
                                                        <option value="{{ $code }}" {{ $settings->currency === $code ? 'selected' : '' }}>
                                                            {{ $details['symbol'] }} - {{ $details['name'] }} ({{ $code }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <x-input-error :messages="$errors->get('currency')" class="mt-2" />
                                            </div>

                                            <!-- Date Format -->
                                            <div>
                                                <x-input-label for="date_format" :value="__('Date Format')" />
                                                <select id="date_format" name="date_format" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                                    @foreach($dateFormats as $format => $example)
                                                        <option value="{{ $format }}" {{ $settings->date_format === $format ? 'selected' : '' }}>
                                                            {{ $example }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <x-input-error :messages="$errors->get('date_format')" class="mt-2" />
                                            </div>
                                        </div>

                                        <div class="mt-6">
                                            <x-primary-button>{{ __('Save General Settings') }}</x-primary-button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Notification Settings -->
                            <div x-show="activeTab === 'notifications'" x-transition>
                                <form method="POST" action="{{ route('settings.update') }}" class="max-w-2xl mx-auto">
                                    @csrf
                                    <div class="space-y-6">
                                        <div>
                                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">{{ __('Notification Preferences') }}</h3>
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Control how and when you receive notifications about your expenses and budget.') }}</p>
                                        </div>

                                        <!-- Enable Notifications -->
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="notifications_enabled" name="notifications_enabled" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" {{ $settings->notifications_enabled ? 'checked' : '' }}>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="notifications_enabled" class="font-medium text-gray-700 dark:text-gray-200">{{ __('Enable Notifications') }}</label>
                                                <p class="text-gray-500 dark:text-gray-400">{{ __('Receive notifications about upcoming expenses, budget limits, and savings goals.') }}</p>
                                            </div>
                                        </div>

                                        <!-- Email Notifications -->
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="email_notifications" name="email_notifications" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" {{ $settings->email_notifications ? 'checked' : '' }}>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="email_notifications" class="font-medium text-gray-700 dark:text-gray-200">{{ __('Email Notifications') }}</label>
                                                <p class="text-gray-500 dark:text-gray-400">{{ __('Receive notifications via email in addition to in-app notifications.') }}</p>
                                            </div>
                                        </div>

                                        <!-- Preferred Notification Time -->
                                        <div>
                                            <x-input-label for="preferred_notification_time" :value="__('Preferred Notification Time')" />
                                            <input type="time" id="preferred_notification_time" name="preferred_notification_time" value="{{ $settings->preferred_notification_time?->format('H:i') ?? '08:00' }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('The time when you prefer to receive daily notifications.') }}</p>
                                            <x-input-error :messages="$errors->get('preferred_notification_time')" class="mt-2" />
                                        </div>

                                        <div class="mt-6">
                                            <x-primary-button>{{ __('Save Notification Settings') }}</x-primary-button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Recurring Expenses Settings -->
                            <div x-show="activeTab === 'recurring'" x-transition>
                                <div class="max-w-2xl mx-auto">
                                    <div class="space-y-6">
                                        <div>
                                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">{{ __('Recurring Expenses Management') }}</h3>
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Manage your recurring expenses and preferences.') }}</p>
                                        </div>

                                        <form method="POST" action="{{ route('settings.update') }}">
                                            @csrf
                                            <!-- Show Recurring First -->
                                            <div class="flex items-start mb-6">
                                                <div class="flex items-center h-5">
                                                    <input id="show_recurring_first" name="show_recurring_first" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" {{ $settings->show_recurring_first ? 'checked' : '' }}>
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="show_recurring_first" class="font-medium text-gray-700 dark:text-gray-200">{{ __('Show Recurring Expenses First') }}</label>
                                                    <p class="text-gray-500 dark:text-gray-400">{{ __('Display recurring expenses at the top of your expenses list.') }}</p>
                                                </div>
                                            </div>

                                            <x-primary-button>{{ __('Save Recurring Settings') }}</x-primary-button>
                                        </form>

                                        <!-- Recurring Expenses List -->
                                        <div class="mt-8">
                                            <h4 class="text-md font-medium leading-6 text-gray-900 dark:text-gray-100 mb-3">{{ __('Your Recurring Expenses') }}</h4>
                                            
                                            @if($recurringExpenses->isEmpty())
                                                <div class="text-gray-500 dark:text-gray-400 text-sm italic">
                                                    {{ __('You don\'t have any recurring expenses set up yet.') }}
                                                </div>
                                            @else
                                                <div class="overflow-x-auto relative">
                                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                                            <tr>
                                                                <th scope="col" class="py-3 px-6">{{ __('Description') }}</th>
                                                                <th scope="col" class="py-3 px-6">{{ __('Amount') }}</th>
                                                                <th scope="col" class="py-3 px-6">{{ __('Category') }}</th>
                                                                <th scope="col" class="py-3 px-6">{{ __('Next Date') }}</th>
                                                                <th scope="col" class="py-3 px-6">{{ __('Actions') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($recurringExpenses as $expense)
                                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                                    <td class="py-4 px-6">{{ $expense->description }}</td>
                                                                    <td class="py-4 px-6">{{ $settings->currency_symbol }} {{ number_format(abs($expense->amount), 2) }}</td>
                                                                    <td class="py-4 px-6">{{ $expense->category->name ?? 'Uncategorized' }}</td>
                                                                    <td class="py-4 px-6">{{ $expense->date->format($settings->date_format) }}</td>
                                                                    <td class="py-4 px-6">
                                                                        <a href="{{ route('expenses.edit', $expense) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-500 dark:hover:text-blue-400 mr-3">
                                                                            {{ __('Edit') }}
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Import/Export Settings -->
                            <div x-show="activeTab === 'export'" x-transition>
                                <div class="max-w-2xl mx-auto">
                                    <div class="space-y-6">
                                        <div>
                                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">{{ __('Import & Export Data') }}</h3>
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Import or export your expense data and settings.') }}</p>
                                        </div>

                                        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2">
                                            <!-- Export Data -->
                                            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-sm">
                                                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-3">{{ __('Export Your Data') }}</h4>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                                    {{ __('Download all your expenses, categories, budgets, and settings in a single file.') }}
                                                </p>
                                                <a href="{{ route('settings.export') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                    {{ __('Export Data') }}
                                                </a>
                                            </div>

                                            <!-- Import Data -->
                                            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-sm">
                                                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-3">{{ __('Import Data') }}</h4>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                                    {{ __('Upload a previously exported file to restore your data.') }}
                                                </p>
                                                <form method="POST" action="{{ route('settings.import') }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="flex items-center">
                                                        <input type="file" name="import_file" id="import_file" class="block w-full text-sm text-gray-500 dark:text-gray-400 
                                                        file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 
                                                        file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 
                                                        hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-300
                                                        dark:hover:file:bg-blue-800">
                                                    </div>
                                                    <x-input-error :messages="$errors->get('import_file')" class="mt-2" />
                                                    <button type="submit" class="mt-3 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                                        </svg>
                                                        {{ __('Import Data') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 