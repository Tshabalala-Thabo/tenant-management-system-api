<x-app-layout> 
    <x-header name="header">
        <div>
            <nav class="breadcrumbs">
                <ul class="flex font-medium text-sm">
                    <li class="mr-1"><a href="/dashboard">Dashboard</a></li>
                    <li class="mr-1"> > </li>
                    <li class="mr-1">Tenants</li>
                </ul>
            </nav>
            <h1 class="font-bold text-lg">Tenants</h1>
        </div>
    </x-header>

    <div class="flex flex-wrap gap-y-4 px-3">
        @if($groupedTenants->isEmpty())
            <p>No tenants found.</p>
        @else
            <table class="table-auto w-full mt-1 rounded-lg shadow-md overflow-hidden">
                <thead class="bg-gray-300">
                    <tr class="text-left">
                        <th class="px-4 py-2">Names</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Phone</th>
                        <th class="px-4 py-2">Sites and Rooms</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($groupedTenants as $tenantId => $tenantRooms)
                            <tr class="border-t border-gray-300 cursor-pointer"
                                onclick="window.location='{{ route('tenants.show', $tenantRooms->first()['tenant']->id) }}'">
                                <td class="px-4 py-2">{{ ucfirst($tenantRooms->first()['tenant']->name) }}
                                    {{ ucfirst($tenantRooms->first()['tenant']->last_name) }}</td>
                                <td class="px-4 py-2">{{ $tenantRooms->first()['tenant']->email }}</td>
                                <td class="px-4 py-2">{{ $tenantRooms->first()['tenant']->phone }}</td>
                                <td class="px-4 py-2">
                                    @foreach($tenantRooms->groupBy('site.id') as $siteId => $siteRooms)
                                                    <strong class="mr-1/2">{{ $siteRooms->first()['site']->name }}:</strong>
                                                    @php
                                                        $roomNames = $siteRooms->pluck('room.name')->implode(', ');
                                                    @endphp
                                                    {{ $roomNames }} <span class="mr-3"></span>
                                    @endforeach
                                </td>
                                <td class="px-4 py-2">
                                    <ion-icon name="eye" class="size-5 text-gray-500"></ion-icon>
                                </td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>