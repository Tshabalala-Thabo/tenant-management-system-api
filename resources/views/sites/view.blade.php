<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex flex-wrap gap-y-4 px-3">
        <table class="table w-full mt-1 rounded-lg shadow-md overflow-hidden">
            <thead class="table-active bg-gray-400">
                <tr class="text-left">
                    <th class="px-2">Room#</th>
                    <th class="px-2">Tenant</th>
                    <th class="px-2">Cost</th>
                    <th class="px-2">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach ($site->rooms as $room)
                    <tr class="border-t border-gray-300">
                        <td class="px-2 py-2">{{ $room->name }} ( {{ $room->description }})</td>
                        <td class="px-2">N/A</td>
                        <td class="px-2">R2 500</td>
                        <td class="px-2 flex h-full items-center"> <button
                                class="bg-primary-600 flex items-centre text-black mr-1 px-2 py-1 rounded-md text-sm">
                                <ion-icon name="add" class="size-4 text-black"></ion-icon>

                                Assign tenant</button>
                            <button class="bg-primary-600 text-black px-2 mr-1 py-1 flex items-center rounded-md text-sm">
                                <ion-icon name="pencil" class="size-4 text-black"></ion-icon>

                                Edit</button>
                            <button class="bg-danger text-black px-2 py-1 mr-1 rounded-md text-sm flex items-center">
                                <ion-icon name="trash" class="size-4 text-black"></ion-icon>

                                Delete</button>


                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>