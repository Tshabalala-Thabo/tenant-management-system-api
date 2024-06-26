<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
   
    <!-- Bootstrap -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!--link href="{{ asset('node_modules/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet"-->

    <link rel="stylesheet" href="https://unpkg.com/@icon/ionicons/ionicons.css">
    <!-- Scripts -->

    <!-- modal -->
    <script src="{{ asset('js/app.js') }}"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div x-data="{ open: true }" class="h-screen flex flex-col bg-gray-100">
        @include('layouts.navigation')

        <div class="flex flex-1"> <!-- style="height: calc(100vh - 4rem - 1px);" -->
            <!-- Responsive Navigation Menu -->
            <div :class="{'block': open, 'hidden': ! open}" class="flex flex-col justify-between pt-4 bg-primary-700">
                <!-- <div :class="{'block': open, 'hidden': ! open}" class="sm:hidden"> -->
                <div>
                    <div class="mx-6 pb-2">
                        <x-responsive-nav-link class="rounded-lg font-bold py-2 pl-6 pr-6 {{ Route::current()->getName() == 'dashboard' ? 'bg-primary-100 text-black'  : 'bg-transparent text-black' }} flex align-center" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            <ion-icon name="{{ Route::current()->getName() == 'dashboard' ? 'apps'  : 'apps-outline' }}" class="size-6 mr-6"></ion-icon> {{ __('Dashboard') }}
                        </x-responsive-nav-link>
                    </div>

                    <div class="pb-2 mx-6">
                        <x-responsive-nav-link class="rounded-lg py-2 pl-6 pr-6 {{ Route::current()->getName() == 'tenants' ? 'bg-primary-100 text-black'  : 'bg-transparent text-black' }} flex align-center" :href="route('tenants')" :active="request()->routeIs('tenants')">
                            <ion-icon name="{{ Route::current()->getName() == 'tenants' ? 'people'  : 'people-outline' }}" class="size-6 mr-6"></ion-icon>{{ __('Tenants') }}
                        </x-responsive-nav-link>
                    </div>

                    <div class="pb-2 mx-6">
                        <x-responsive-nav-link class="rounded-lg py-2 {{ Route::current()->getName() == 'invoices' ? 'bg-primary-100 text-black'  : 'bg-transparent text-black' }} pl-6 pr-6 flex align-center" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            <ion-icon name="document-text-outline" class="size-6 mr-6"></ion-icon> {{ __('Invoices') }}
                        </x-responsive-nav-link>
                    </div>

                    <div class="pb-2 mx-6 rounded-md">
                        <x-responsive-nav-link class="rounded-lg py-2 pl-6 pr-6 {{ Route::current()->getName() == 'sites.index' ? 'bg-primary-100 text-black font-bold'  : 'bg-transparent text-black' }} flex align-center" :href="route('sites.index')" :active="request()->routeIs('dashboard')">
                            <ion-icon name="{{ Route::current()->getName() == 'sites' ? 'business'  : 'business-outline' }}" class="size-6 mr-6"></ion-icon> {{ __('Sites') }}
                        </x-responsive-nav-link>
                    </div>

                    <div class="pb-2 mx-6 rounded-md">
                        <x-responsive-nav-link class="rounded-lg py-2 pl-6 pr-6 {{ Route::current()->getName() == 'rooms' ? 'bg-primary-100 text-black'  : 'bg-transparent text-black' }} flex align-center" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
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
                        @elseif(Request::is('sites'))
                        <nav class="breadcrumbs">
                            <ul class="flex font-medium text-sm">
                                <li class="mr-1"><a href="/dashboard">Dashboard</a></li>
                                <li class="mr-1"> > </li>
                                <li class="mr-1"><a href="/sites">Sites</a></li>

                            </ul>
                        </nav>
                        <h1>Sites</h1>
                        <!-- Add more conditions as needed for other routes -->
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
                            <button @click="isOpen = true" class="bg-primary-700 text-black shadow-md px-4 py-2 rounded-md hover:bg-primary-800">+ Add tenant</button>
                            
                        </div>
                        @elseif(Request::is('sites'))
                        <!--button type="button" class="btn bg-primary-700 text-black border-0 hover:bg-primary-800 shadow-md btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        + Add tenant
                        </button-->
                        <div x-data="{ isOpen: false }">
                            <button @click="isOpen = true" class="bg-primary-700 text-black shadow-md px-4 py-2 rounded-md hover:bg-primary-800">+ Add site</button>
                            
                        </div>

                        @endif
                    </div>

                </header>
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Add Tenant Modal -->
   <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('tenants') }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addTenantModalLabel">Add Tenant</h5>
                            <!--button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button-->
                        </div>
                        <div class="modal-body">
                            <!-- Your form fields go here -->
                            <div class="grid grid-rows-2">
                                <div class="">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <!-- Add more fields as needed -->
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>    
            </div>
        </div>
    </div>

    <!-- Add Tenant Modal -->
    <!-- resources/views/components/add-user-modal.blade.php -->
    



     <!-- Bootstrap JavaScript ->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.min.js"></script-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>