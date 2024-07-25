@php
    use Carbon\Carbon;
@endphp

<x-app-layout>
    <x-header name="header">
        <div>
            <nav class="breadcrumbs">
                <ul class="flex font-medium text-sm">
                    <li class="mr-1"><a href="/dashboard">Dashboard</a></li>
                    <li class="mr-1"> > </li>
                    <li class="mr-1"><a href="/tenants">Tenants</a></li>
                    <li class="mr-1"> > </li>
                    <li class="mr-1">{{$tenant->name}}</li>
                </ul>
            </nav>
            <h1 class="font-bold text-lg">{{$tenant->name}}</h1>
        </div>
    </x-header>

    <div x-data="{
    openLeaseModal: false}" class="flex flex-wrap gap-y-4 px-3 pb-5">
        <div class="w-3/12 flex flex-col items-center">
            <div class="w-full aspect-w-1 aspect-h-1 rounded-full overflow-hidden mt-4">
                <img src="{{ asset('images/profile/' . $tenant->id . '.jpg') }}" alt="Tenant Image"
                    class="w-full h-full object-cover">
            </div>
            <h1 class="mt-2 text-xl font-bold">{{ ucfirst($tenant->name) }} {{ ucfirst($tenant->last_name) }}</h1>
            <table class="w-full mt-1 border-collapse border-0">
                <tbody>
                    <tr>
                        <td class="py-1 text-gray-700">ID no</td>
                        <td class="py-1 text-gray-900">:{{ $tenant->idno }}</td>
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
            <div class="w-full mt-7 flex justify-between items-end p-1">
                <h1 class="font-bold">Invoices</h1>
                <!-- Trigger Button for Modal -->
                <button @click="openLeaseModal = true"
                    class="bg-primary-600 text-black px-4 py-2 rounded-md hover:bg-primary-700">
                    Create invoice
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
                </tbody>
            </table>
            <div class="w-full flex mt-7 justify-between items-end p-1">
                <h1 class="font-bold">Lease agreements</h1>
                <button @click="openLeaseModal = true"
                    class="bg-primary-600 text-black px-4 py-2 rounded-md hover:bg-primary-700">
                    Create agreement
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
                            <th class="px-4 py-2">Term</th>
                            <th class="px-4 py-2">Is terminated</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach($tenant->leaseAgreements as $leaseAgreement)
                            <tr class="border-t border-gray-300 cursor-pointer">
                                <td class="px-4 py-2">{{ $leaseAgreement->id }}</td>
                                <td class="px-4 py-2">Room:
                                    {{ $leaseAgreement->room->name }}({{ $leaseAgreement->room->site->name }})
                                </td>
                                <td class="px-4 py-2">{{ $leaseAgreement->start_date }} - {{ $leaseAgreement->end_date }}</td>
                                <td class="px-4 py-2">{{ $leaseAgreement->is_terminated ? 'Yes' : 'No' }}</td>
                                <td class="px-4 py-2"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <!-- Modal -->
        <div x-show="openLeaseModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            class="fixed inset-0 flex items-center justify-center z-50">
            <!-- Modal content -->
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative z-50">
                <h2 class="text-xl font-bold mb-4">Create Lease Agreement</h2>
                <form action="{{ route('lease-agreements.store') }}" method="POST">
                    @csrf

                    <!-- Hidden input to pass the tenant ID -->
                    <input type="hidden" name="tenant_id" value="{{ $tenant->id }}">

                    <div class="mb-4">
                        <label for="room_id" class="block text-gray-700 text-sm font-bold mb-2">Room:</label>
                        <select name="room_id" id="room_id"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                            <option value="" disabled selected>Select a room</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                    {{ $room->name }} ({{ $room->site->name }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">Start Date:</label>
                        <input type="date" name="start_date" id="start_date"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value="{{ old('start_date') }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">End Date:</label>
                        <input type="date" name="end_date" id="end_date"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value="{{ old('end_date') }}" required>
                    </div>

                    <div class="flex justify-end">
                        <button @click="openLeaseModal = false" type="button"
                            class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-700 mr-2">Cancel
                        </button>
                        <button type="submit"
                            class="bg-primary-700 text-black px-4 py-2 rounded-md hover:bg-primary-800">Create
                            Lease Agreement
                        </button>
                    </div>
                </form>
            </div>
            <!-- Overlay -->
            <div @click="openLeaseModal = false" class="fixed inset-0 bg-black opacity-50 z-40"></div>
        </div>


    </div>

    </div>
</x-app-layout>