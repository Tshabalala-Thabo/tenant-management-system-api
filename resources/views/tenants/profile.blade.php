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
            <table class="w-full mt-1 border-collapse border-0">
                <tbody>
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

            <div class="mt-3 w-full">
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
            </div>
        </div>
        <div class="w-9/12 pl-3">
            <div class="w-full flex justify-between items-end p-1">
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
            <h1 class="mt-5 font-bold">Maintenance tickets</h1>
            <div class="grid grid-cols-2 gap-2">
                <div class="bg-gray-300 px-4 py-2 rounded-lg">
                    <h1 class="font-bold">Mary: I lost my keys</h1>
                    <h1>Re: New set of keys are on the way</h1>
                    <div class="flex w-full items-center justify-between mt-5">
                        <div class="bg-green-500 w-min text-sm rounded-md px-2 py-1">Solved</div>
                        <p>22 April 2024</p>
                    </div>
                </div>

                <div class="bg-gray-300 px-4 py-2 rounded-lg">
                    <h1 class="font-bold">Mary: I lost my keys</h1>
                    <h1>Re: New set of keys are on the way</h1>
                    <div class="flex w-full items-center justify-between mt-5">
                        <div class="bg-green-500 w-min text-sm rounded-md px-2 py-1">Solved</div>
                        <p>22 April 2024</p>
                    </div>
                </div>

                <div class="bg-gray-300 px-4 py-2 rounded-lg">
                    <h1 class="font-bold">Mary: I lost my keys</h1>
                    <h1>Re: New set of keys are on the way</h1>
                    <div class="flex w-full items-center justify-between mt-5">
                        <div class="bg-green-500 w-min text-sm rounded-md px-2 py-1">Solved</div>
                        <p>22 April 2024</p>
                    </div>
                </div>

                <div class="bg-gray-300 px-4 py-2 rounded-lg">
                    <h1 class="font-bold">Mary: I lost my keys</h1>
                    <h1>Re: New set of keys are on the way</h1>
                    <div class="flex w-full items-center justify-between mt-5">
                        <div class="bg-green-500 w-min text-sm rounded-md px-2 py-1">Solved</div>
                        <p>22 April 2024</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
</x-app-layout>