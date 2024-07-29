<x-app-layout>
    <x-header name="header">
        <div>
            <nav class="breadcrumbs">
                <ul class="flex font-medium text-sm">
                    <li class="mr-1"><a href="/dashboard">Dashboard</a></li>
                    <li class="mr-1"> > </li>
                    <li class="mr-1">Lease Agreements</li>
                </ul>
            </nav>
            <h1 class="font-bold text-lg">Lease Agreements</h1>
        </div>
    </x-header>

    <div class="flex flex-wrap gap-y-4 px-3">
        @if($leaseAgreements->isEmpty())
            <p>No lease agreements found.</p>
        @else
            <table class="table-auto w-full mt-1 rounded-lg shadow-md overflow-hidden">
                <thead class="bg-gray-300">
                <tr class="text-left">
                    <th class="px-4 py-2">Tenant</th>
                    <th class="px-4 py-2">Room</th>
                    <th class="px-4 py-2">Site</th>
                    <th class="px-4 py-2">Start Date</th>
                    <th class="px-4 py-2">End Date</th>
                    <th class="px-4 py-2">Terminated</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white">
                @foreach($leaseAgreements as $lease)
                    <tr class="border-t border-gray-300 cursor-pointer">
                        <td class="px-4 py-2">{{ ucfirst($lease->tenant->name) }}
                            {{ ucfirst($lease->tenant->last_name) }}</td>
                        <td class="px-4 py-2">{{ $lease->room->name }}</td>
                        <td class="px-4 py-2">{{ $lease->room->site->name }}</td>
                        <td class="px-4 py-2">{{ $lease->start_date }}</td>
                        <td class="px-4 py-2">{{ $lease->end_date}}</td>
                        <td class="px-4 py-2">
                            @if($lease->is_terminated)
                                Yes
                            @else
                                No
                            @endif
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
