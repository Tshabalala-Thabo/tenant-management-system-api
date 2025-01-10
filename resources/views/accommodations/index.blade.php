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
                            <li class="mr-1">Accommodation</li>
                        </ul>
                    </nav>
                    <h1 class="font-bold text-lg">Accommodations</h1>
                </div>
            </x-header>
            <div class="container mx-auto px-2">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <!-- Greenwood Apartments Card -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold mb-2">Greenwood Apartments</h2>
                        <p class="text-gray-600 mb-4">
                            A modern apartment complex with spacious rooms and great amenities.
                        </p>
                        <p class="text-gray-500 mb-2">123 Oak Street, Building A, Springfield, 12345</p>
                        <p class="text-gray-500 mb-4">Landlord: John Doe</p>
                        <button class="bg-primary-600 text-black font-semibold shadow-sm px-4 py-2 rounded-md hover:bg-primary-800">
                            Apply Now
                        </button>
                    </div>

                    <!-- Riverside Villas Card -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold mb-2">Riverside Villas</h2>
                        <p class="text-gray-600 mb-4">
                            Exclusive riverside villas with scenic views and private gardens.
                        </p>
                        <p class="text-gray-500 mb-2">456 River Road, Unit 3, Riverdale, 67890</p>
                        <p class="text-gray-500 mb-4">Landlord: Jane Smith</p>
                        <button class="bg-primary-600 text-black font-semibold shadow-sm px-4 py-2 rounded-md hover:bg-primary-800">
                            Apply Now
                        </button>
                    </div>

                    <!-- Sunny Acres Card -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold mb-2">Sunny Acres</h2>
                        <p class="text-gray-600 mb-4">
                            A peaceful community with spacious yards and family-friendly amenities.
                        </p>
                        <p class="text-gray-500 mb-2">789 Meadow Lane, Hometown, 11223</p>
                        <p class="text-gray-500 mb-4">Landlord: Michael Johnson</p>
                        <button class="bg-primary-600 text-black font-semibold shadow-sm px-4 py-2 rounded-md hover:bg-primary-800">
                            Apply Now
                        </button>
                    </div>

                    <!-- City View Towers Card -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold mb-2">City View Towers</h2>
                        <p class="text-gray-600 mb-4">
                            Luxury apartments with panoramic city views and state-of-the-art facilities.
                        </p>
                        <p class="text-gray-500 mb-2">321 High Street, Penthouse 5, Metroville, 44556</p>
                        <p class="text-gray-500 mb-4">Landlord: Emily Davis</p>
                        <button class="bg-primary-600 text-black font-semibold shadow-sm px-4 py-2 rounded-md hover:bg-primary-800">
                            Apply Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
