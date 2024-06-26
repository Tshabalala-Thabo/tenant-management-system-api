<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @role('landlord')
    <div class="flex flex-wrap px-1">
        @foreach ($sites as $site)
            <div class="w-3/12 px-2 mb-3">
                <div class=" flex justify-between items-center bg-white px-10 py-6 shadow-md rounded-lg">
                    <ion-icon name="business" class="size-16 text-primary-600"></ion-icon>
                    {{ ucfirst($site->name) }}
                </div>
            </div>
        @endforeach
    </div>

    @endrole
</x-app-layout>