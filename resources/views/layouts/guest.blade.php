<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Wealixir Client Management System</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('admin_page/css/saas.css') }}">
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <div class="min-h-screen flex flex-col items-center justify-center px-4 py-10 bg-gradient-to-br from-indigo-50 via-white to-slate-100">
            <div class="w-full sm:max-w-md">
                <div class="flex items-center justify-center">
                    <a href="/" class="inline-flex items-center gap-3">
                        <x-application-logo class="w-10 h-10 fill-current text-indigo-600" />
                        <span class="text-lg font-semibold text-slate-900">Wealixir</span>
                    </a>
                </div>

                <div class="mt-6 saas-surface px-6 py-6">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
