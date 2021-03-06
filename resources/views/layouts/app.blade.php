<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data" x-cloak lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('crm-panel/css/app.css') }}">

        <!-- Scripts -->
    <script src="{{ asset('crm-panel/js/app.js') }}" defer></script>
    <script src="{{ asset('crm-panel/js/init-alpine.js') }}"></script>
</head>
<body>
    
<div
    class="flex h-screen bg-gray-50 dark:bg-gray-900"
    :class="{ 'overflow-hidden': isSideMenuOpen }"
>
    <!-- Desktop sidebar -->
    @include('layouts.navigation')
    <!-- Mobile sidebar -->
    <!-- Backdrop -->
    @include('layouts.navigation-mobile')
    <div class="flex flex-col flex-1 w-full">
        @include('layouts.top-menu')
        <main class="h-full overflow-y-auto pb-16">
            <div class="container px-6 mx-auto grid">
                <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                    {{ $header }}
                </h2>
                {{ $slot }}
            </div>
        </main>
    </div>

    <x-custom.alert></x-custom.alert>
</div>
@yield('body_scripts')
</body>
</html>
