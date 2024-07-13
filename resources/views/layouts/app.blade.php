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

        <div class="flex flex-1"> <!-- style="height: calc(100vh - 4rem - 1px);" -->
            <!-- Responsive Navigation Menu -->
            <div :class="{'block': open, 'hidden': ! open}" class="flex flex-col justify-between pt-4 bg-primary-600">
                <!-- <div :class="{'block': open, 'hidden': ! open}" class="sm:hidden"> -->
                <div>
                    <div class="mx-6 pb-2">
                        <x-responsive-nav-link class="rounded-lg font-bold py-2 pl-6 pr-6 {{ Route::current()->getName() == 'dashboard' ? 'bg-primary-100 text-black'  : 'bg-transparent text-black' }} flex align-center" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            <ion-icon name="{{ Route::current()->getName() == 'dashboard' ? 'apps'  : 'apps-outline' }}" class="size-6 mr-6"></ion-icon> {{ __('Dashboard') }}
                        </x-responsive-nav-link>
                    </div>
                    @role('landlord')
                    <div class="pb-2 mx-6">
                        <x-responsive-nav-link class="rounded-lg py-2 pl-6 pr-6 {{ Route::current()->getName() == 'tenants.index' || Route::current()->getName() == 'tenants.show' ? 'bg-primary-100 text-black'  : 'bg-transparent text-black' }} flex align-center" :href="route('tenants.index')" :active="request()->routeIs('tenants.index')">
                            <ion-icon name="{{ Route::current()->getName() == 'tenants.index' ? 'people'  : 'people-outline' }}" class="size-6 mr-6"></ion-icon>{{ __('Tenants') }}
                        </x-responsive-nav-link>
                    </div>
                    @endrole
                    <div class="pb-2 mx-6">
                        <x-responsive-nav-link class="rounded-lg py-2 {{ Route::current()->getName() == 'invoices' ? 'bg-primary-100 text-black'  : 'bg-transparent text-black' }} pl-6 pr-6 flex align-center" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            <ion-icon name="document-text-outline" class="size-6 mr-6"></ion-icon> {{ __('Invoices') }}
                        </x-responsive-nav-link>
                    </div>
                    @role('landlord')
        
                    <div class="pb-2 mx-6 rounded-md">
                        <x-responsive-nav-link class="rounded-lg py-2 pl-6 pr-6 {{ Route::current()->getName() == 'sites.index' || Route::current()->getName() == 'sites.view' ? 'bg-primary-100 text-black font-bold'  : 'bg-transparent text-black' }} flex align-center" :href="route('sites.index')" :active="request()->routeIs('dashboard')">
                            <ion-icon name="{{ in_array(Route::currentRouteName(), ['sites.index', 'sites.view']) ? 'business'  : 'business-outline' }}" class="size-6 mr-6"></ion-icon> {{ __('Sites') }}
                        </x-responsive-nav-link>
                    </div>
                    @endrole
                    <div class="pb-2 mx-6 rounded-md">
                    <x-responsive-nav-link class="rounded-lg py-2 pl-6 pr-6 {{ Request::is('tickets') ? 'bg-primary-100 text-black' : 'bg-transparent text-black' }} flex align-center" href="/tickets" :active="request()->is('tickets')">
                        <ion-icon name="hammer-outline" class="size-6 mr-6"></ion-icon> {{ __('Maintenance') }}
                    </x-responsive-nav-link>

                    </div>

                </div>
                <!-- Responsive Settings Options -->
                <div class="">
                    <!-- <div class="px-4">
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div> -->

                    <div class="mt-3 space-y-1 bg-black text-white">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                            this.closest('form').submit();" class="px-4 flex align-center">
                                <ion-icon name="log-out-outline" class="size-6 mr-5 text-primary-200"></ion-icon>

                                {{ __('Log Out') }}
                            </x-responsive-nav-link>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main class="flex-grow flex-1 overflow-y-auto" style="height: calc(100vh - 4rem - 1px);">
                <!-- Page Heading -->

                <!-- <header class="bg-white shadow">
                    <div class="mx-auto py-6 px-3 font-semibold text-md sm:px-6 lg:px-8">
                        {{ ucfirst(Route::current()->getName()) }}
                    </div>
                </header> -->
                <header class="flex-1 flex items-center justify-between px-3 pt-8 pb-2">
                    <div class=" font-semibold text-lg">
                        @if(Request::is('/') || Request::is('dashboard'))
                        <nav class="breadcrumbs">
                            <ul>
                                <li><a href="/dashboard">Dashboard</a></li>
                            </ul>
                        </nav>
                        @elseif(Request::is('tenants'))
                        <nav class="breadcrumbs">
                            <ul class="flex font-medium text-sm">
                                <li class="mr-1"><a href="/dashboard">Dashboard</a></li>
                                <li class="mr-1"> > </li>
                                <li class="mr-1"><a href="/tenants">Tenants</a></li>

                            </ul>
                        </nav>
                        <h1>Tenants</h1>
                        @elseif(Request::is('tenants/profile/*'))
                        @php
                            $segments = explode('/', request()->path());
                            $tenantId = end($segments);
                            $tenant = App\Models\User::findOrFail($tenantId); // Replace with your actual Tenant model and namespace
                        @endphp
                        <nav class="breadcrumbs">
                            <ul class="flex font-medium text-sm">
                                <li class="mr-1"><a href="/dashboard">Dashboard</a></li>
                                <li class="mr-1"> > </li>
                                <li class="mr-1"><a href="/tenants">Tenants</a></li>
                                <li class="mr-1"> > </li>
                                <li class="mr-1"><a href="/tenants/profile/{{ $tenant->id }}">{{ ucfirst($tenant->name) }}</a></li>
                            </ul>
                        </nav>
                        <h1>{{ ucfirst($tenant->name) }}</h1>
                        @elseif(Request::is('tenant.show'))
                        <nav class="breadcrumbs">
                            <ul class="flex font-medium text-sm">
                                <li class="mr-1"><a href="/dashboard">Dashboard</a></li>
                                <li class="mr-1"> > </li>
                                <li class="mr-1"><a href="/tenants">Tenants</a></li>

                            </ul>
                        </nav>
                        <h1>Tenants</h1>
                        @endif
                        @php
                        $routeName = Route::currentRouteName();
                        $tenantId = Request::route('id');
                        $tenantName = null;
                        if ($routeName === 'tenants.show' && $tenantId) {
                            $tenant = \App\Models\User::find($tenantId);
                            if ($tenant) {
                                $tenantName = $tenant->name;
                            }
                        }

                        @endphp
                        @php
                        $routeName = Route::currentRouteName();
                        $siteId = Request::route('id');
                        $siteName = null;

                        if ($routeName === 'sites.view' && $siteId) {
                            $site = \App\Models\Site::find($siteId);
                            if ($site) {
                                $siteName = $site->name;
                            }
                        }
                        @endphp

                        @if ($routeName === 'sites.view' && $siteName)
                            <nav class="breadcrumbs">
                                <ul class="flex font-medium text-sm">
                                    <li class="mr-1"><a href="/dashboard">Dashboard</a></li>
                                    <li class="mr-1"> > </li>
                                    <li class="mr-1"><a href="/sites">Sites</a></li>
                                    <li class="mr-1"> > </li>
                                    <li class="mr-1">{{ $siteName }}</li>
                                </ul>
                            </nav>
                            <h1>{{ $siteName }}</h1>
                        @elseif(Request::is('tickets'))
                            <nav class="breadcrumbs">
                                <ul class="flex font-medium text-sm">
                                    <li class="mr-1"><a href="/dashboard">Dashboard</a></li>
                                    <li class="mr-1"> > </li>
                                    <li class="mr-1">Maintenance tickets</li>
                                </ul>
                            </nav>   
                            <h1>Maintenance tickets</h1> 
                        @endif

                        <!-- Your main content -->
                        <div class="container">
                            @yield('content')
                        </div>

                        <!-- {{ ucfirst(Route::current()->getName()) }} -->

                        
                    </div>

                    <div>
                        @if(Request::is('tenants'))
                        <!--button type="button" class="btn bg-primary-700 text-black border-0 hover:bg-primary-800 shadow-md btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        + Add tenant
                        </button-->
                        <div x-data="{ isOpen: false }">
                            <button @click="isOpen = true" class="bg-primary-600 text-black shadow-md px-4 py-2 rounded-md hover:bg-primary-800">+ Add tenant</button>
                            
                        </div>
                        @elseif(Request::is('sites'))
                        <!--button type="button" class="btn bg-primary-700 text-black border-0 hover:bg-primary-800 shadow-md btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        + Add tenant
                        </button-->
                        <!-- <div >
                            <button class="bg-primary-600 text-black shadow-md px-4 py-2 rounded-md hover:bg-primary-800">+ Add site</button>
                            
                        </div> -->
                        <div x-data="{ open: false }">
                            <!-- Button to trigger modal -->
                            <button @click="open = true" class="bg-primary-600 text-black shadow-md px-4 py-2 rounded-md hover:bg-primary-800">+ Add site</button>
                            
                            <!-- Modal -->
                            <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90" class="fixed inset-0 flex items-center justify-center z-50">
                                <!-- Modal content -->
                                <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative z-50">
                                    <h2 class="text-xl font-bold mb-4">Add Site</h2>
                                    <form action="{{ route('sites.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-4">
                                            <label for="name" class="block text-sm font-medium text-gray-700">Site Name</label>
                                            <input type="text" name="name" id="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="description" class="block text-sm font-medium text-gray-700">Site Description</label>
                                            <input type="text" name="description" id="description" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm" required>
                                        </div>
                                        <div class="flex justify-end">
                                            <button @click="open = false" type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-700 mr-2">Cancel</button>
                                            <button type="submit" class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-800">Create Site</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- Overlay -->
                                <div @click="open = false" class="fixed inset-0 bg-black opacity-50 z-40"></div>
                            </div>
                        </div>
                        @elseif($routeName === 'sites.view')
                        <!--button type="button" class="btn bg-primary-700 text-black border-0 hover:bg-primary-800 shadow-md btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        + Add tenant
                        </button-->
                        <div x-data="{ open: false }">
                            <!-- Button to trigger modal -->
                            <button @click="open = true" class="bg-primary-600 text-black shadow-md px-4 py-2 rounded-md hover:bg-primary-800">+ Add room</button>
                            
                            <!-- Modal -->
                            <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90" class="fixed inset-0 flex items-center justify-center z-50">
                                <!-- Modal content -->
                                <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative z-50">
                                    <h2 class="text-xl font-bold mb-4">Add a new room</h2>
                                    <form action="{{ route('rooms.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-4">
                                            <label for="name" class="block text-sm font-medium text-gray-700">Room name</label>
                                            <input type="text" name="name" id="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="description" class="block text-sm font-medium text-gray-700">Room description</label>
                                            <input type="text" name="description" id="description" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="description" class="block text-sm font-medium text-gray-700">Room cost</label>
                                            <input type="number" name="cost" id="cost" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm" required>
                                        </div>
                                        <input type="hidden" name="site_id" value="{{ $site->id }}">
                                        <div class="flex justify-end">
                                            <button @click="open = false" type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-700 mr-2">Cancel</button>
                                            <button type="submit" class="bg-primary-700 text-black px-4 py-2 rounded-md hover:bg-primary-800">Create room</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- Overlay -->
                                <div @click="open = false" class="fixed inset-0 bg-black opacity-50 z-40"></div>
                            </div>
                        </div>
                        @endif
                    </div>

                </header>
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