<x-app-layout>
    <div class="flex">
        <x-side-nav activeLink="sites"/>

        <div class="flex-grow flex-1 overflow-y-auto" style="height: calc(100vh - 4rem - 1px);">
            <x-header name="header">
                <div>
                    <nav class="breadcrumbs">
                        <ul class="flex font-medium text-sm">
                            <li class="mr-1"><a href="/dashboard">Dashboard</a></li>
                            <li class="mr-1"> ></li>
                            <li class="mr-1"><a href="/sites">Sites</a></li>
                            <li class="mr-1"> ></li>
                            <li class="mr-1">{{$site->name}}</li>
                        </ul>
                    </nav>
                    <h1 class="font-bold text-lg">{{$site->name}}</h1>
                </div>

                <div>
                    <button @click="open = true"
                            class="bg-primary-600 text-black shadow-md px-4 py-2 rounded-md hover:bg-primary-800">+
                        Add
                        room
                    </button>

                    <div x-data="{ open: false }">
                        <!-- Button to trigger modal -->
                        <button @click="open = true"
                                class="bg-primary-600 text-black shadow-md px-4 py-2 rounded-md hover:bg-primary-800">+
                            Add
                            room
                        </button>

                        <!-- Modal -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform scale-90"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-300"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-90"
                             class="fixed inset-0 flex items-center justify-center z-50">
                            <!-- Modal content -->
                            <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative z-50">
                                <h2 class="text-xl font-bold mb-4">Add a new room</h2>
                                <form action="{{ route('rooms.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="name" class="block text-sm font-medium text-gray-700">Room
                                            name</label>
                                        <input type="text" name="name" id="name"
                                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                                               required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="description" class="block text-sm font-medium text-gray-700">Room
                                            description</label>
                                        <input type="text" name="description" id="description"
                                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                                               required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="description" class="block text-sm font-medium text-gray-700">Room
                                            cost</label>
                                        <input type="number" name="cost" id="cost"
                                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                                               required>
                                    </div>
                                    <input type="hidden" name="site_id" value="{{ $site->id }}">
                                    <div class="flex justify-end">
                                        <button @click="open = false" type="button"
                                                class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-700 mr-2">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                                class="bg-primary-700 text-black px-4 py-2 rounded-md hover:bg-primary-800">
                                            Create
                                            room
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!-- Overlay -->
                            <div @click="open = false" class="fixed inset-0 bg-black opacity-50 z-40"></div>
                        </div>
                    </div>
                </div>
            </x-header>

            <div x-data="{
    ...searchUsers(), // Ensure searchUsers() returns an object
    isOpenEdit: false,
    roomId: null,
    roomName: '',
    roomCost: '',
    openEditModal(id, name, cost) {
        this.isOpenEdit = true;
        this.roomId = id;
        this.roomName = name;
        this.roomCost = cost;
    },
    closeEditModal() {
        this.isOpenEdit = false;
        this.roomId = null;
        this.roomName = '';
        this.roomCost = '';
    },
    async saveRoom() {
        try {
            const response = await fetch(`/rooms/${this.roomId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    name: this.roomName,
                    cost: this.roomCost,
                }),
            });
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const data = await response.json();
            if (data.success) {
                // Update the UI or show a success message
                this.closeEditModal();
                location.reload(); // Reload to see the updated data
            } else {
                console.error('Failed to update the room:', data.message);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
}" class=" flex flex-wrap gap-y-4 px-3">
                <table class="table-auto w-full mt-1 rounded-lg shadow-md overflow-hidden">
                    <thead class="bg-gray-400">
                    <tr class="text-left">
                        <th class="px-4 py-2">Room#</th>
                        <th class="px-4 py-2">Tenant</th>
                        <th class="px-4 py-2">Cost</th>
                        <th class="px-4 py-2 w-fit">Action</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white">
                    @foreach ($site->rooms as $room)
                        <tr class="border-t border-gray-300 hover:bg-gray-100">
                            <td class="px-4 py-2">{{ $room->name }} ( {{ $room->description }})</td>
                            <td class="px-4 py-2">
                                @if ($room->tenant)
                                    {{ $room->tenant->name }} {{ $room->tenant->last_name }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="px-4 py-2">R{{ $room->cost }}</td>
                            <td class="px-4 py-2">
                                <div class="flex">
                                    @if ($room->tenant)
                                        <button @click="openConfirmationModal({{ $room->id }})"
                                                class="bg-danger flex items-center text-black px-2 py-1 rounded-md text-sm mr-1">
                                            <ion-icon name="remove" class="text-black text-sm"></ion-icon>
                                            Remove tenant
                                        </button>
                                    @else
                                        <button @click="openModal({{ $room->id }})"
                                                class="bg-primary-600 flex items-center text-black px-2 py-1 rounded-md text-sm mr-1">
                                            <ion-icon name="add" class="text-black text-sm"></ion-icon>
                                            Assign tenant
                                        </button>
                                    @endif

                                    <button
                                        @click="openEditModal({{ $room->id }}, '{{ $room->name }}', '{{ $room->cost }}')"
                                        class="bg-primary-600 flex items-center text-black px-2 py-1 rounded-md text-sm mr-1">
                                        <ion-icon name="pencil" class="text-black text-sm"></ion-icon>
                                        Edit
                                    </button>
                                    <button @click="openDeleteModal({{ $room->id }})"
                                            class="bg-danger flex items-center text-black px-2 py-1 rounded-md text-sm">
                                        <ion-icon name="trash" class="text-black text-sm"></ion-icon>
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <!-- Edit Modal -->
                <div x-show="isOpenEdit" x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-90"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-90" class="fixed z-50 inset-0 overflow-y-auto">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                             aria-hidden="true"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                              aria-hidden="true">&#8203;</span>
                        <div
                            class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                            <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
                                <button @click="closeEditModal"
                                        class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <span class="sr-only">Close</span>
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Edit
                                        Room</h3>
                                    <div class="mt-2">
                                        <input type="text" x-model="roomName"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                               placeholder="Room Name">
                                        <input type="text" x-model="roomCost"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                               placeholder="Room Cost">
                                    </div>
                                    <div class="mt-4">
                                        <button @click="saveRoom"
                                                class="bg-primary-600 text-white px-4 py-2 rounded-md text-sm">Save
                                        </button>
                                        <button @click="closeEditModal"
                                                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm ml-2">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div x-show="isOpen" x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-90"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-90" class="fixed z-50 inset-0 overflow-y-auto">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div x-show="isOpen" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                             aria-hidden="true"></div>

                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                              aria-hidden="true">&#8203;</span>

                        <div x-show="isOpen"
                             class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                            <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
                                <button @click="isOpen = false"
                                        class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <span class="sr-only">Close</span>
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Assign
                                        Tenant</h3>
                                    <div class="mt-2">
                                        <input type="text" x-model="searchQuery" @input="searchUsers"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                               placeholder="Search users...">
                                        <ul class="mt-4">
                                            <template x-for="user in users" :key="user . id">
                                                <li
                                                    class="py-2 px-4 border-b border-gray-200 flex justify-between items-center">
                                                    <span x-text="user.name"></span>
                                                    <button @click="assignUserToRoom(user.id)"
                                                            class="bg-primary-600 text-white px-2 py-1 rounded-md text-sm">
                                                        Assign
                                                    </button>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Confirmation Modal -->
                <div x-show="isConfirmationOpen" class="fixed flex z-50 inset-0 justify-center items-center"
                     aria-labelledby="confirmation-modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <!-- Background overlay -->
                        <div x-show="isConfirmationOpen"
                             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                             aria-hidden="true"></div>

                        <!-- Modal panel -->
                        <div x-show="isConfirmationOpen"
                             class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                            <!-- Close button -->
                            <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
                                <button @click="closeConfirmationModal"
                                        class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <span class="sr-only">Close</span>
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>

                            <!-- Modal content -->
                            <div>
                                <div class="sm:flex sm:items-start">
                                    <div class="text-center sm:mt-0 sm:text-left">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900"
                                            id="confirmation-modal-title">
                                            Remove Tenant Confirmation
                                        </h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">
                                                Are you sure you want to remove the tenant from this room?
                                            </p>
                                            <div class="mt-4">
                                                <button @click="confirmRemoveTenant"
                                                        class="bg-red-600 text-white px-4 py-2 rounded-md text-sm">
                                                    Confirm
                                                    Removal
                                                </button>
                                                <button @click="closeConfirmationModal"
                                                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm ml-2">
                                                    Cancel
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Modal -->
                <div x-show="isDeleteModalOpen" class="fixed z-10 inset-0 overflow-y-auto"
                     aria-labelledby="delete-modal-title"
                     role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <!-- Background overlay -->
                        <div x-show="isDeleteModalOpen"
                             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                             aria-hidden="true"></div>

                        <!-- Modal panel -->
                        <div x-show="isDeleteModalOpen"
                             class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                            <!-- Close button -->
                            <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
                                <button @click="closeDeleteModal"
                                        class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <span class="sr-only">Close</span>
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>

                            <!-- Modal content -->
                            <div>
                                <div class="sm:flex sm:items-start">
                                    <div class="text-center sm:mt-0 sm:text-left">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="delete-modal-title">
                                            Delete Room Confirmation
                                        </h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">
                                                Are you sure you want to delete this room?
                                            </p>
                                            <div class="mt-4">
                                                <button @click="confirmDeleteRoom"
                                                        class="bg-red-600 text-white px-4 py-2 rounded-md text-sm">
                                                    Confirm
                                                    Deletion
                                                </button>
                                                <button @click="closeDeleteModal"
                                                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm ml-2">
                                                    Cancel
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('alpine:init', () => {
                    Alpine.data('searchUsers', () => ({
                        isOpen: false,
                        searchQuery: '',
                        users: [],
                        selectedRoomId: null,
                        isConfirmationOpen: false,
                        isDeleteModalOpen: false,

                        openModal(roomId) {
                            this.selectedRoomId = roomId;
                            this.isOpen = true;
                        },

                        openConfirmationModal(roomId) {
                            this.selectedRoomId = roomId;
                            this.isConfirmationOpen = true;
                        },

                        closeConfirmationModal() {
                            this.isConfirmationOpen = false;
                        },

                        openDeleteModal(roomId) {
                            this.selectedRoomId = roomId;
                            this.isDeleteModalOpen = true;
                        },

                        closeDeleteModal() {
                            this.isDeleteModalOpen = false;
                        },

                        async confirmDeleteRoom() {
                            try {
                                const response = await axios.delete(`/rooms/${this.selectedRoomId}`);
                                if (response.status === 200) {
                                    console.log('Room deleted successfully.');
                                    this.closeDeleteModal();
                                    window.location.reload();
                                }
                            } catch (error) {
                                console.error('Error deleting room:', error);
                            }
                        },

                        async confirmRemoveTenant() {
                            try {
                                const response = await axios.put(`/rooms/${this.selectedRoomId}/remove-tenant`);
                                if (response.status === 200) {
                                    console.log('Tenant removed successfully.');
                                    // Optionally: Update UI or reload data after successful removal
                                    // Example: window.location.reload();
                                    this.closeConfirmationModal();
                                    window.location.reload();
                                }
                            } catch (error) {
                                console.error('Error removing tenant:', error);
                            }
                        },
                        async searchUsers() {
                            if (this.searchQuery.length < 3) {
                                this.users = [];
                                return;
                            }

                            try {
                                const response = await axios.get(`/users`, {params: {search: this.searchQuery}});
                                this.users = response.data;
                            } catch (error) {
                                console.error('Error fetching users:', error);
                            }
                        },
                        async assignUserToRoom(userId) {
                            try {
                                const response = await axios.post(`/rooms/${this.selectedRoomId}/assign`, {user_id: userId});
                                if (response.status === 200) {
                                    this.isOpen = false;
                                    window.location.reload();
                                }
                            } catch (error) {
                                console.error('Error assigning user to room:', error);
                            }
                        }
                    }));
                });
            </script>
        </div>
    </div>
</x-app-layout>
