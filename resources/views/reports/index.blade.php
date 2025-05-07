<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Export Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-8">
                        <h3 class="text-lg font-medium mb-4">{{ __('Generate Expense Reports') }}</h3>
                        <p class="mb-4">{{ __('Export your expense data to Excel or PDF format. You can filter by date range and category.') }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Excel Export Form -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h4 class="font-medium mb-4 pb-2 border-b border-gray-200 dark:border-gray-600">{{ __('Excel Export') }}</h4>
                            
                            <form action="{{ route('reports.excel') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <x-input-label for="start_date" :value="__('Start Date')" />
                                    <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" />
                                </div>
                                
                                <div class="mb-4">
                                    <x-input-label for="end_date" :value="__('End Date')" />
                                    <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full" />
                                </div>
                                
                                <div class="mb-4">
                                    <x-input-label for="category_id" :value="__('Category (Optional)')" />
                                    <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="">{{ __('All Categories') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <x-primary-button>
                                        <i class="fa fa-file-excel mr-2"></i> {{ __('Export to Excel') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>

                        <!-- PDF Export Form -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h4 class="font-medium mb-4 pb-2 border-b border-gray-200 dark:border-gray-600">{{ __('PDF Export') }}</h4>
                            
                            <form action="{{ route('reports.pdf') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <x-input-label for="pdf_start_date" :value="__('Start Date')" />
                                    <x-text-input id="pdf_start_date" name="start_date" type="date" class="mt-1 block w-full" />
                                </div>
                                
                                <div class="mb-4">
                                    <x-input-label for="pdf_end_date" :value="__('End Date')" />
                                    <x-text-input id="pdf_end_date" name="end_date" type="date" class="mt-1 block w-full" />
                                </div>
                                
                                <div class="mb-4">
                                    <x-input-label for="pdf_category_id" :value="__('Category (Optional)')" />
                                    <select id="pdf_category_id" name="category_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="">{{ __('All Categories') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <x-primary-button class="bg-red-600 hover:bg-red-700 focus:bg-red-700">
                                        <i class="fa fa-file-pdf mr-2"></i> {{ __('Export to PDF') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 