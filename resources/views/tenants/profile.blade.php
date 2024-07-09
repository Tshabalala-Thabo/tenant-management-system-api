<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex flex-wrap gap-y-4 px-3">
        <div class="w-3/12 flex flex-col items-center justify-center">
            <div class="w-full aspect-w-1 aspect-h-1 rounded-full overflow-hidden mt-4">
                <img src="{{ asset('images/profile/mary.jpg') }}" alt="Tenant Image" class="w-full h-full object-cover">
            </div>
            <h1 class="mt-2 text-xl font-bold">{{ ucfirst($tenant->name) }} {{ ucfirst($tenant->last_name) }}</h1>
            <table class="w-full mt-4 border-collapse border-0">
                <tbody>
                    <tr>
                        <td class="py-1 px-4 text-gray-700">Email</td>
                        <td class="py-1 px-4 text-gray-900">:{{ $tenant->email }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 px-4 text-gray-700">Phone</td>
                        <td class="py-1 px-4 text-gray-900">:{{ $tenant->phone }}</td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $tenant->name }}</h5>
                <p class="card-text">Email: {{ $tenant->email }}</p>
                <p class="card-text">Phone: {{ $tenant->phone }}</p>
                <!-- Add more tenant details as needed -->
            </div>
        </div>
    </div>
</x-app-layout>