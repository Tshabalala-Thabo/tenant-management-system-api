<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- In your Blade view file, e.g., resources/views/your-view.blade.php -->

    <div x-data="searchUsers()" class="flex flex-wrap gap-y-4 px-3">
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
                                <!-- Button to open the modal -->
                                <button @click="isOpen = true"
                                    class="bg-primary-600 flex items-center text-black px-2 py-1 rounded-md text-sm mr-1">
                                    <ion-icon name="add" class="text-black text-sm"></ion-icon> Assign tenant
                                </button>

                                <!-- Modal -->
                                <div x-show="isOpen" class="fixed z-10 inset-0 overflow-y-auto"
                                    aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                    <div
                                        class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                        <div x-show="isOpen"
                                            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                                            aria-hidden="true"></div>

                                        <!-- This element is to trick the browser into centering the modal contents. -->
                                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                            aria-hidden="true">&#8203;</span>

                                        <div x-show="isOpen"
                                            class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                                            <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
                                                <button @click="isOpen = false"
                                                    class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    <span class="sr-only">Close</span>
                                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>

                                            <div class="sm:flex sm:items-start">
                                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                    <h3 class="text-lg leading-6 font-medium text-gray-900"
                                                        id="modal-title">Assign Tenant</h3>
                                                    <div class="mt-2">
                                                        <input type="text" x-model="searchQuery" @input="searchUsers"
                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                                                            placeholder="Search users...">
                                                        <ul class="mt-4">
                                                            <template x-for="user in users" :key="user . id">
                                                                <li class="py-2 px-4 border-b border-gray-200"
                                                                    x-text="user.name"></li>
                                                            </template>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('searchUsers', () => ({
                isOpen: false,
                searchQuery: '',
                users: [],
                async searchUsers() {
                    if (this.searchQuery.length < 3) {
                        this.users = [];
                        return;
                    }

                    try {
                        const response = await axios.get(`/users`, { params: { search: this.searchQuery } });
                        this.users = response.data;
                    } catch (error) {
                        console.error('Error fetching users:', error);
                    }
                }
            }));
        });
    </script>





</x-app-layout>