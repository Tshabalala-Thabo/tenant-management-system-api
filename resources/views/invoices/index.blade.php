<x-app-layout>
    <x-header name="header">
        <div>
            <nav class="breadcrumbs">
                <ul class="flex font-medium text-sm">
                    <li class="mr-1"><a href="/dashboard">Dashboard</a></li>
                    <li class="mr-1"> ></li>
                    <li class="mr-1">Invoices</li>
                </ul>
            </nav>
            <h1 class="font-bold text-lg">Invoices</h1>
        </div>
    </x-header>
    <div class="mx-3">
        @if($invoices->isEmpty())
            <p>No invoices found.</p>
        @else
            <table class="table-auto w-full mt-1 rounded-lg shadow-md overflow-hidden">
                <thead class="bg-gray-300">
                <tr class="text-left">
                    <th class="px-4 py-2">Invoice#</th>
                    <th class="px-4 py-2">Tenant</th>
                    <th class="px-4 py-2">Room</th>
                    <th class="px-4 py-2">Site</th>
                    <th class="px-4 py-2">Amount</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
                </thead>
                <tbody class="bg-white">
                @foreach($invoices as $invoice)
                    <tr class="border-t border-gray-300 cursor-pointer hover:bg-gray-100">
                        <td class="px-4 py-2">{{ $invoice->id }}</td>
                        <td class="px-4 py-2">{{ optional($invoice->tenant)->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ optional($invoice->room)->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ optional($invoice->room->site)->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">R{{ number_format($invoice->amount, 2) }}</td>
                        <td class="px-4 py-2">{{ $invoice->status }}</td>
                        <td class="px-4 py-2">
                            <div class="flex">
                                <ion-icon name="eye" class="size-5 mr-1 text-gray-500"></ion-icon>
                                <ion-icon name="pencil" class="size-5 mr-1 text-gray-500"></ion-icon>
                                <ion-icon name="trash" class="size-5 text-danger"></ion-icon>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
