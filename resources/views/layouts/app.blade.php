<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Tenant Management System') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Bootstrap -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!--link href="{{ asset('node_modules/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet"-->

    <link rel="stylesheet" href="https://unpkg.com/@icon/ionicons/ionicons.css">
    <!-- Scripts -->

    <!-- modal -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="//unpkg.com/alpinejs" defer></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
<div x-data="{ open: true }" class="h-screen flex flex-col bg-gray-100">
    @include('layouts.navigation')

    <div x-data="{ openModal: false }" class="flex flex-1"> <!-- style="height: calc(100vh - 4rem - 1px);" -->
        <!-- Responsive Navigation Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="flex flex-col justify-between pt-4 bg-primary-600">
            <!-- <div :class="{'block': open, 'hidden': ! open}" class="sm:hidden"> -->
            <div>
                <div class="mx-6 pb-2">
                    <x-responsive-nav-link
                        class="rounded-lg py-2 pl-6 pr-6 {{ Route::current()->getName() == 'dashboard' ? 'bg-primary-100 font-semibold text-black' : 'bg-transparent text-black' }} flex items-center"
                        :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <ion-icon name="{{ Route::current()->getName() == 'dashboard' ? 'apps' : 'apps-outline' }}"
                                  class="size-6 mr-6"></ion-icon>
                        <p class="{{ Route::current()->getName() == 'dashboard' ? 'font-semibold' : 'font-normal' }}">{{ __('Dashboard') }}</p>
                    </x-responsive-nav-link>
                </div>
                @role('landlord')
                <div class="pb-2 mx-6">
                    <x-responsive-nav-link
                        class="rounded-lg py-2 pl-6 pr-6 {{ Route::current()->getName() == 'tenants.index' || Route::current()->getName() == 'tenants.show' ? 'bg-primary-100 font-semibold text-black' : 'bg-transparent text-black' }} flex items-center"
                        :href="route('tenants.index')" :active="request()->routeIs('tenants.index')">
                        <ion-icon
                            name="{{ Route::current()->getName() == 'tenants.index' ? 'people' : 'people-outline' }}"
                            class="size-6 mr-6"></ion-icon>
                        <p class="{{ Route::current()->getName() == 'tenants.index' ? 'font-semibold' : 'font-normal' }}">{{ __('Tenants') }}</p>
                    </x-responsive-nav-link>
                </div>
                @endrole
                <div class="pb-2 mx-6">
                    <x-responsive-nav-link
                        class="rounded-lg py-2 pl-6 pr-6 {{ Route::current()->getName() == 'invoices' ? 'bg-primary-100 font-semibold text-black' : 'bg-transparent text-black' }} flex items-center"
                        :href="route('invoices.index')" :active="request()->routeIs('invoices.index')">
                        <ion-icon name="document-text-outline" class="size-6 mr-6"></ion-icon>
                        <p class="{{ Route::current()->getName() == 'invoices' ? 'font-semibold' : 'font-normal' }}">{{ __('Invoices') }}</p>
                    </x-responsive-nav-link>
                </div>
                @role('landlord')
                <div class="pb-2 mx-6 rounded-md">
                    <x-responsive-nav-link
                        class="rounded-lg py-2 pl-6 pr-6 {{ Route::current()->getName() == 'sites.index' || Route::current()->getName() == 'sites.view' ? 'bg-primary-100 font-semibold text-black' : 'bg-transparent text-black' }} flex items-center"
                        :href="route('sites.index')" :active="request()->routeIs('dashboard')">
                        <ion-icon
                            name="{{ in_array(Route::currentRouteName(), ['sites.index', 'sites.view']) ? 'business' : 'business-outline' }}"
                            class="size-6 mr-6"></ion-icon>
                        <p class="{{ in_array(Route::currentRouteName(), ['sites.index', 'sites.view']) ? 'font-semibold' : 'font-normal' }}">{{ __('Sites') }}</p>
                    </x-responsive-nav-link>
                </div>
                @endrole
                <div class="pb-2 mx-6 rounded-md">
                    <x-responsive-nav-link
                        class="rounded-lg py-2 pl-6 pr-6 {{ Request::is('tickets') ? 'bg-primary-100 font-semibold text-black' : 'bg-transparent text-black' }} flex items-center"
                        href="/tickets" :active="request()->is('tickets')">
                        <ion-icon name="hammer-outline" class="size-6 mr-6"></ion-icon>
                        <p class="{{ Request::is('tickets') ? 'font-semibold' : 'font-normal' }}">{{ __('Maintenance') }}</p>
                    </x-responsive-nav-link>
                </div>
            </div>
            <div class="">
                <!-- <div class="px-4">
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div> -->

                <div class="mt-3 space-y-1 text-right py-1 px-4 bg-black text-white">
                    <p class="text-sm font-italic text-gray-300">Developed by</p>
                    <p class="font-semibold mt-0">Thabo Tshabalala</p>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <main class="flex-grow flex-1 overflow-y-auto" style="height: calc(100vh - 4rem - 1px);">
            <!-- Page Heading -->



                <!-- @if (session('success'))
                    <div class="bg-green-500 text-white p-4 mb-4 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-500 text-white p-4 mb-4 rounded">
                        {{ session('error') }}
                    </div>
                @endif -->

                {{ $slot }}
            </main>
        </div>
    </div>


<!-- Add Tenant Modal -->
<!-- resources/views/components/add-user-modal.blade.php -->


<!-- Bootstrap JavaScript ->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.min.js"></script-->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->


<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>

