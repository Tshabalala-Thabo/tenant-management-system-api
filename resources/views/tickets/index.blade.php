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

    <div class="px-3 grid gap-2 grid-cols-3" x-data="{
    isOpenEdit: false,
    ticketId: null,
    ticketDetails: '',
    ticketSiteId: '',
    ticketRoomId: '',
    openEditModal(ticket) {
        this.isOpenEdit = true;
        this.ticketId = ticket.id;
        this.ticketDetails = ticket.details;
        this.ticketSiteId = ticket.site_id;
        this.ticketRoomId = ticket.room_id;
    },
    closeEditModal() {
        this.isOpenEdit = false;
        this.ticketId = null;
        this.ticketDetails = '';
        this.ticketSiteId = '';
        this.ticketRoomId = '';
    },
    async saveTicket() {
        try {
            const response = await fetch(`/tickets/${this.ticketId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    id: this.ticketId,
                    details: this.ticketDetails,
                    site_id: this.ticketSiteId,
                    room_id: this.ticketRoomId,
                }),
            });
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const data = await response.json();
            if (data.success) {
                this.closeEditModal();
                location.reload(); // Reload to see the updated data
            } else {
                console.error('Failed to update the ticket:', data.message);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
}">
        @foreach($tickets as $ticket)
            <div class="bg-gray-300 rounded-lg px-5 py-3">
                <div class="w-full flex justify-between">
                    <h1 class="font-bold text-lg">{{ ucfirst($ticket->details) }}</h1>
                    <div x-data="{ open: false }" class="relative">
                        <div @click="open = !open"
                            class="hover:bg-gray-400 flex items-center justify-center h-min py-1 px-1 rounded-full cursor-pointer">
                            <ion-icon class="size-5" name="ellipsis-horizontal"></ion-icon>
                        </div>
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg py-1 z-20">
                            <a href="javascript:void(0);" @click="openEditModal({{ $ticket }}); open = false"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Edit</a>
                            <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" class="block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div>
                    <p>
                        @if ($ticket->room)
                            Room {{ $ticket->room->name }}:
                        @endif {{$ticket->site->name}}
                    </p>
                </div>
                <div class="mt-3 flex justify-between w-full">
                    <p class="text-sm ">{{ $ticket->created_at->format('d M Y') }}</p>
                    <div class="bg-danger w-min text-xs rounded-md px-2 py-1">{{ $ticket->status }}</div>
                </div>
            </div>
        @endforeach

        <!-- Edit Modal -->
        <div x-show="isOpenEdit" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90" class="fixed z-50 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
                        <button @click="closeEditModal"
                            class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Edit Ticket</h3>
                            <div class="mt-2">
                                <input type="text" x-model="ticketDetails"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                    placeholder="Ticket Details">
                                <select x-model="ticketSiteId"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                                    <option value="" disabled>Select a site</option>
                                    @foreach($sites as $site)
                                        <option value="{{ $site->id }}">{{ $site->name }}</option>
                                    @endforeach
                                </select>
                                <select x-model="ticketRoomId"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                                    <option value="" disabled>Select a room</option>
                                    <!-- Options should be dynamically filled based on the selected site -->
                                </select>
                            </div>
                            <div class="mt-4">
                                <button @click="saveTicket"
                                    class="bg-primary-600 text-white px-4 py-2 rounded-md text-sm">Save</button>
                                <button @click="closeEditModal"
                                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm ml-2">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
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
                        value="{{ old('details') }}" required>
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