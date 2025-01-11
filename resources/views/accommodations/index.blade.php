<x-app-layout>
    <div class="flex">
        <x-side-nav activeLink="sites" />

        <div class="flex-grow flex-1 overflow-y-auto" style="height: calc(100vh - 4rem - 1px);">
            <x-header name="header">
                <div>
                    <nav class="breadcrumbs">
                        <ul class="flex font-medium text-sm">
                            <li class="mr-1"><a href="/dashboard">Dashboard</a></li>
                            <li class="mr-1"> ></li>
                            <li class="mr-1">Accommodation</li>
                        </ul>
                    </nav>
                    <h1 class="font-bold text-lg">Accommodations</h1>
                </div>
            </x-header>
            <div class="px-3">

                <!-- Display success or error messages -->
                @if(session('success'))
                <div class="bg-green-500 text-white p-2 rounded mb-4">
                    {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="bg-red-500 text-white p-2 rounded mb-4">
                    {{ session('error') }}
                </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach ($sites as $site)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold mb-2">{{ ucfirst($site->name) }}</h2>
                        <p class="text-gray-600 mb-4">
                            {{ $site->description }}
                        </p>
                        <p class="text-gray-500 mb-2">{{ $site->address_line1 }}</p>
                        @if($site->address_line2)
                        <p class="text-gray-500 mb-2">{{ $site->address_line2 }}</p>
                        @endif
                        <p class="text-gray-500 mb-4">{{ $site->city }}{{ $site->postal_code ? ', ' . $site->postal_code : '' }}</p>

                        <!-- Check if the tenant has already applied -->
                        @php
                        $tenantId = auth()->user()->id;
                        $application = \App\Models\AccommodationApplication::where('tenant_id', $tenantId)
                        ->where('site_id', $site->id)
                        ->first();
                        @endphp

                        @if ($application)
                        <p class="text-gray-700 mb-2">
                            Application Status: <strong>{{ ucfirst($application->status) }}</strong>
                        </p>

                        @if (in_array($application->status, ['terminated', 'rejected']))
                        <form action="{{ route('applications.apply', $site->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="site_id" value="{{ $site->id }}">
                            <button type="submit" class="bg-primary-600 text-black font-semibold shadow-md px-4 py-2 rounded-md hover:bg-primary-800">
                                Reapply
                            </button>
                        </form>
                        @endif
                        @else
                        <!-- Application Form -->
                        <form action="{{ route('applications.apply', $site->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="site_id" value="{{ $site->id }}">
                            <button type="submit" class="bg-primary-600 text-black font-semibold shadow-md px-4 py-2 rounded-md hover:bg-primary-800">
                                Apply Now
                            </button>
                        </form>
                        @endif

                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>