@php
    use Carbon\Carbon;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex flex-wrap gap-y-4 px-3 pb-5">
        <div class="w-3/12 flex flex-col items-center">
            <div class="w-full aspect-w-1 aspect-h-1 rounded-full overflow-hidden mt-4">
                <img src="{{ asset('images/profile/mary.jpg') }}" alt="Tenant Image" class="w-full h-full object-cover">
            </div>
            <h1 class="mt-2 text-xl font-bold">{{ ucfirst($tenant->name) }} {{ ucfirst($tenant->last_name) }}</h1>
            <table class="w-full mt-1 border-collapse border-0">
                <tbody>
                    <tr>
                        <td class="py-1 text-gray-700">ID no</td>
                        <td class="py-1 text-gray-900">:</td>
                    </tr>
                    <tr>
                        <td class="py-1 text-gray-700">Email</td>
                        <td class="py-1 text-gray-900">:{{ $tenant->email }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 text-gray-700">Phone</td>
                        <td class="py-1 text-gray-900">:{{ $tenant->phone }}</td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>

            <!-- <div class="mt-3 w-full">
                <h1 class="font-bold">Lease agreement(s)</h1>

                <div class="w-full bg-primary-600 px-4 py-4 shadow-md rounded-lg flex justify-between items-center">
                    <p>June 2024 - June 2025</p> <ion-icon name="chevron-down"></ion-icon>

                </div>
                <div
                    class="w-full bg-primary-600 px-4 py-4 mt-2 shadow-md rounded-lg flex justify-between items-center">
                    <p>June 2024 - June 2025</p> <ion-icon name="chevron-down"></ion-icon>

                </div>

                <div
                    class="w-full bg-primary-600 px-4 py-4 mt-2 shadow-md rounded-lg flex justify-between items-center">
                    <p>June 2024 - June 2025</p> <ion-icon name="chevron-down"></ion-icon>

                </div>

                <div
                    class="w-full bg-primary-600 px-4 py-4 mt-2 shadow-md rounded-lg flex justify-between items-center">
                    <p>June 2024 - June 2025</p> <ion-icon name="chevron-down"></ion-icon>

                </div>
            </div> -->
        </div>
        <div class="w-9/12 pl-3">
            <h1 class="text-left w-full font-bold">Maintenance tickets</h1>
            <div class="grid grid-cols-3 w-full gap-2">
                @if($tenant->tenantTickets && $tenant->tenantTickets->isNotEmpty())
                    @foreach($tenant->tenantTickets as $ticket)
                        <div class="bg-gray-300 px-4 h-min py-2 rounded-lg">
                            <h1 class="font-bold">{{ $ticket->details }}</h1>
                            @if(!empty($ticket->response))
                                <h1>Re: {{ $ticket->response }}</h1>
                            @endif
                            <div class="flex w-full items-center justify-between mt-5">
                                <div class="bg-danger w-min text-sm rounded-md px-2 py-1">{{ $ticket->status }}</div>
                                <p>{{ $ticket->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>No tickets available.</p>
                @endif
            </div>
            <div class="w-full mt-4 flex justify-between items-end p-1">
                <h1 class="font-bold">Invoices</h1>
                <button class="bg-primary-600 flex items-center shadow-md text-black px-2 py-1 rounded-md text-sm mr-1">
                    <ion-icon name="add" class="text-black text-sm"></ion-icon> Add an invoice
                </button>
            </div>
            <table class="table-auto w-full mt-1 rounded-lg shadow-md overflow-hidden">
                <thead class="bg-gray-300">
                    <tr class="text-left">
                        <th class="px-4 py-2">Invoice#</th>
                        <th class="px-4 py-2">Date</th>
                        <th class="px-4 py-2">Amount</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr class="border-t border-gray-300 cursor-pointer">
                        <td class="px-4 py-2">2424</td>
                        <td class="px-4 py-2">01 June 2024</td>
                        <td class="px-4 py-2">R2 000</td>
                        <td class="px-4 py-2"></td>
                    </tr>
                    <tr class="border-t border-gray-300 cursor-pointer">
                        <td class="px-4 py-2">2424</td>
                        <td class="px-4 py-2">01 June 2024</td>
                        <td class="px-4 py-2">R2 000</td>
                        <td class="px-4 py-2"></td>
                    </tr>
                    <tr class="border-t border-gray-300 cursor-pointer">
                        <td class="px-4 py-2">2424</td>
                        <td class="px-4 py-2">01 June 2024</td>
                        <td class="px-4 py-2">R2 000</td>
                        <td class="px-4 py-2"></td>
                    </tr>
                    <tr class="border-t border-gray-300 cursor-pointer">
                        <td class="px-4 py-2">2424</td>
                        <td class="px-4 py-2">01 June 2024</td>
                        <td class="px-4 py-2">R2 000</td>
                        <td class="px-4 py-2"></td>
                    </tr>
                    <tr class="border-t border-gray-300 cursor-pointer">
                        <td class="px-4 py-2">2424</td>
                        <td class="px-4 py-2">01 June 2024</td>
                        <td class="px-4 py-2">R2 000</td>
                        <td class="px-4 py-2"></td>
                    </tr>
                </tbody>
            </table>
            <div class="w-full flex mt-4 justify-between items-end p-1">
                <h1 class="font-bold">Lease agreements</h1>
                <button class="bg-primary-600 flex items-center shadow-md text-black px-2 py-1 rounded-md text-sm mr-1">
                    <ion-icon name="add" class="text-black text-sm"></ion-icon> Add an invoice
                </button>
            </div>
            @if($tenant->leaseAgreements->isEmpty())
                <p>No lease agreements found for this tenant.</p>
            @else
                <table class="table-auto w-full mt-1 rounded-lg shadow-md overflow-hidden">
                    <thead class="bg-gray-300">
                        <tr class="text-left">
                            <th class="px-4 py-2">Lease#</th>
                            <th class="px-4 py-2">Site</th>
                            <th class="px-4 py-2">Start Date</th>
                            <th class="px-4 py-2">End Date</th>
                            <th class="px-4 py-2">Is terminated</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach($tenant->leaseAgreements as $leaseAgreement)
                            <tr class="border-t border-gray-300 cursor-pointer">
                                <td class="px-4 py-2">{{ $leaseAgreement->id }}</td>
                                <td class="px-4 py-2">Room:
                                    {{ $leaseAgreement->room->name }}({{ $leaseAgreement->room->site->name }})</td>
                                <td class="px-4 py-2">{{ $leaseAgreement->start_date }}</td>
                                <td class="px-4 py-2">{{ $leaseAgreement->end_date }}</td>
                                <td class="px-4 py-2">{{ $leaseAgreement->is_terminated ? 'Yes' : 'No' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    </div>
</x-app-layout>