<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex flex-wrap gap-y-4 px-3">
        <table class="table-auto w-full mt-1 rounded-lg shadow-md overflow-hidden">
            <thead class="bg-gray-400">
                <tr class="text-left">
                    <th class="px-4 py-2 w-1/4">Room#</th>
                    <th class="px-4 py-2 w-1/4">Tenant</th>
                    <th class="px-4 py-2 w-1/4">Cost</th>
                    <th class="px-4 py-2 w-1/4">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach ($site->rooms as $room)
                    <tr class="border-t border-gray-300">
                        <td class="px-4 py-2">{{ $room->name }} ( {{ $room->description }})</td>
                        <td class="px-4 py-2">N/A</td>
                        <td class="px-4 py-2">R{{ $room->cost }}</td>
                        <td class="px-4 py-2">
                            <div class="flex">
                                <button
                                    class="bg-primary-600 flex items-center text-black px-2 py-1 rounded-md text-sm mr-1">
                                    <ion-icon name="add" class="text-black text-sm"></ion-icon> Assign tenant
                                </button>
                                <button
                                    class="bg-primary-600 flex items-center text-black px-2 py-1 rounded-md text-sm mr-1">
                                    <ion-icon name="pencil" class="text-black text-sm"></ion-icon> Edit
                                </button>
                                <button class="bg-danger flex items-center text-black px-2 py-1 rounded-md text-sm">
                                    <ion-icon name="trash" class="text-black text-sm"></ion-icon> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</x-app-layout>