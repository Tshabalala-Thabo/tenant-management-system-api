<x-app-layout>
    <div class="flex">
        <x-side-nav activeLink="sites"/>

        <div class="flex-grow flex-1 overflow-y-auto" style="height: calc(100vh - 4rem - 1px);">
            <x-header>
                <div>
                    <nav class="breadcrumbs">
                        <ul class="flex font-medium text-sm">
                            <li class="mr-1"><a href="/dashboard">Dashboard</a></li>
                            <li class="mr-1"> ></li>
                            <li class="mr-1"><a href="/sites">Sites</a></li>

                        </ul>
                    </nav>
                    <h1 class="font-bold text-lg">Sites</h1>
                </div>

                @role('landlord')
                <div x-data="{ open: false }">
                    <!-- Button to trigger modal -->
                    <button @click="open = true"
                            class="bg-primary-600 text-black shadow-md px-4 py-2 rounded-md hover:bg-primary-800">+ Add
                        site
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
                            <h2 class="text-xl font-bold mb-4">Add Site</h2>
                            <form action="{{ route('sites.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Site Name</label>
                                    <input type="text" name="name" id="name"
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                                           required>
                                </div>
                                <div class="mb-4">
                                    <label for="description" class="block text-sm font-medium text-gray-700">Site
                                        Description</label>
                                    <input type="text" name="description" id="description"
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                                           required>
                                </div>
                                <div class="flex justify-end">
                                    <button @click="open = false" type="button"
                                            class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-700 mr-2">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                            class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-800">
                                        Create
                                        Site
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- Overlay -->
                        <div @click="open = false" class="fixed inset-0 bg-black opacity-50 z-40"></div>
                    </div>
                </div>
                @endrole
            </x-header>

            @role('landlord')
            <div class="flex flex-wrap px-1">
                @foreach ($sites as $site)
                    <div class="w-3/12 px-2 mb-3">
                        <a href="{{ route('sites.view', ['id' => $site->id]) }}">
                            <div class=" flex justify-between items-center bg-white px-10 py-6 shadow-md rounded-lg">
                                <ion-icon name="business" class="size-16 text-primary-600"></ion-icon>
                                {{ ucfirst($site->name) }}
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            @endrole
        </div>
    </div>
</x-app-layout>
