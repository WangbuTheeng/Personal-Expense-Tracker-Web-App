<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Personal Expense Tracker') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-b from-indigo-50 to-white dark:from-gray-900 dark:to-gray-800">
            <div class="mb-4">
                <a href="/">
                    <x-application-logo class="w-24 h-24 fill-current text-indigo-600 dark:text-indigo-400" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-2 px-6 py-6 bg-white dark:bg-gray-800 shadow-lg overflow-hidden sm:rounded-xl border border-gray-200 dark:border-gray-700">
                {{ $slot }}
            </div>

            <div class="mt-8 text-center text-sm text-gray-500 dark:text-gray-400">
                &copy; {{ date('Y') }} Personal Expense Tracker. All rights reserved.
            </div>
        </div>
    </body>
</html>
