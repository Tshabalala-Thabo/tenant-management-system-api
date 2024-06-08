<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div  x-data="{ open: true }" class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <div class="flex">
            <!-- Responsive Navigation Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="pt-4 w-2/12 bg-gray-500">
        <!-- <div :class="{'block': open, 'hidden': ! open}" class="sm:hidden"> -->
            <div class="mx-6 pb-2">
                <x-responsive-nav-link class="rounded-lg" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            </div>

            <div class="pb-2 mx-6">
                <x-responsive-nav-link class="rounded-lg" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Tenants') }}
                </x-responsive-nav-link>
            </div>

            <div class="pb-2 mx-6">
                <x-responsive-nav-link class="rounded-lg" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Invoices') }}
                </x-responsive-nav-link>
            </div>

            <div class="pb-2 mx-6 rounded-md">
                <x-responsive-nav-link class="rounded-lg" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Rooms') }}
                </x-responsive-nav-link>
            </div>

            <div class="pb-2 mx-6">
                <x-responsive-nav-link class="rounded-lg" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Maintenance') }}
                </x-responsive-nav-link>
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <main class="w-10/12">
            <!-- Page Heading -->

            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
            {{ $slot }}
        </main>
        </div>
    </div>
</body>

</html>