<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div>
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <strong class="font-bold">Whoops!</strong>
                <span class="block sm:inline">There were some problems with your input.</span>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif



    </div>

    <div class="px-3 grid gap-2 grid-cols-3">
        @foreach($tickets as $ticket)
            <div class="bg-gray-300 rounded-lg px-5 py-3">
                <div class="w-full flex justify-between">
                    <div>
                        <p>

                            @if ($ticket->room)
                                Room {{ $ticket->room->name }}:
                            @endif {{$ticket->site->name}}
                        </p>
                    </div>
                    <div class="bg-danger w-min text-xs rounded-md px-2 py-1">{{ $ticket->status }}</div>

                </div>
                <h1 class="font-bold text-lg">{{ ucfirst($ticket->details) }}</h1>
                <div class="mt-3 flex justify-end w-full">
                    <p class="text-sm ">{{ $ticket->created_at->format('d M Y') }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal -->
    <div x-show="openModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-90"
        class="fixed inset-0 flex items-center justify-center z-50">
        <!-- Modal content -->
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative z-50">
            <h2 class="text-xl font-bold mb-4">Create a ticket</h2>
            <form action="{{ route('tickets.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="site_id" class="block text-gray-700 text-sm font-bold mb-2">Site:</label>
                    <select name="site_id" id="site_id"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="" disabled selected>Select a site</option>
                        @foreach($sites as $site)
                            <option value="{{ $site->id }}" {{ old('site_id') == $site->id ? 'selected' : '' }}>
                                {{ $site->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="room_id" class="block text-gray-700 text-sm font-bold mb-2">Room:</label>
                    <select name="room_id" id="room_id"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="" disabled selected>Select a room</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="details" class="block text-gray-700 text-sm font-bold mb-2">Details:</label>
                    <input type="text" name="details" id="details"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        value="{{ old('details') }}">
                </div>

                <div class="flex justify-end">
                    <button @click="openModal = false" type="button"
                        class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-700 mr-2">Cancel
                    </button>
                    <button type="submit"
                        class="bg-primary-700 text-black px-4 py-2 rounded-md hover:bg-primary-800">Create
                        ticket
                    </button>
                </div>
            </form>

        </div>
        <!-- Overlay -->
        <div @click="openModal = false" class="fixed inset-0 bg-black opacity-50 z-40"></div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const siteSelect = document.getElementById('site_id');
            const roomSelect = document.getElementById('room_id');

            siteSelect.addEventListener('change', function () {
                const siteId = this.value;
                fetch(`/rooms/${siteId}`)
                    .then(response => response.json())
                    .then(rooms => {
                        roomSelect.innerHTML = '<option value="" disabled selected>Select a room</option>';
                        rooms.forEach(room => {
                            roomSelect.innerHTML += `<option value="${room.id}">${room.name}</option>`;
                        });
                    });
            });
        });
    </script>
</x-app-layout>