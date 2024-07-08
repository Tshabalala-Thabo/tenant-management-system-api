<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex flex-wrap gap-y-4 px-3">
        @if($groupedTenants->isEmpty())
            <p>No tenants found.</p>
        @else
            <table class="table-auto w-full mt-1 rounded-lg shadow-md overflow-hidden">
                <thead class="bg-gray-300">
                    <tr class="text-left">
                        <th class="px-4 py-2">Names</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Sites and Rooms</th>
                        <th class="px-4 py-2">Lease</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($groupedTenants as $tenantId => $tenantRooms)
                            <tr class="border-t border-gray-300 cursor-pointer"
                                onclick="window.location='{{ route('tenants.show', $tenantRooms->first()['tenant']->id) }}'">
                                <td class="px-4 py-2">{{ ucfirst($tenantRooms->first()['tenant']->name) }}
                                    {{ ucfirst($tenantRooms->first()['tenant']->last_name) }}</td>
                                <td class="px-4 py-2">{{ $tenantRooms->first()['tenant']->email }}</td>
                                <td class="px-4 py-2 flex flex-wrap">
                                    @foreach($tenantRooms->groupBy('site.id') as $siteId => $siteRooms)
                                                    <strong class="mr-1">{{ $siteRooms->first()['site']->name }}:</strong>
                                                    @php
                                                        $roomNames = $siteRooms->pluck('room.name')->implode(', ');
                                                    @endphp
                                                    {{ $roomNames }} <span class="mr-3"></span>
                                    @endforeach
                                </td>
                                <td class="px-4 py-2">N/A</td>
                            </tr>
                    @endforeach
                </tbody>
            </table>

        @endif
    </div>
</x-app-layout>