<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex flex-wrap gap-y-4 px-1 py-3">
        <div class="w-4/12 px-2">
            <div class="overflow-hidden  bg-gray-700 shadow-sm sm:rounded-lg">
                <div class="flex py-6 justify-between items-center px-6 text-white">

                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon size-14" viewBox="0 0 512 512">
                        <rect x="32" y="80" width="448" height="256" rx="16" ry="16" transform="rotate(180 256 208)"
                            fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="32" d="M64 384h384M96 432h320" />
                        <circle cx="256" cy="208" r="80" fill="none" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="32" />
                        <path
                            d="M480 160a80 80 0 01-80-80M32 160a80 80 0 0080-80M480 256a80 80 0 00-80 80M32 256a80 80 0 0180 80"
                            fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="32" />
                    </svg>
                    <div class="flex flex-col items-end">
                        <p class="text-3xl">R13 000</p>
                        <p>Rent collected</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-4/12 px-2">
            <div class="overflow-hidden  bg-gray-700 shadow-sm sm:rounded-lg">
                <div class="flex py-6 justify-between items-center px-6 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon size-14" viewBox="0 0 512 512">
                        <path
                            d="M85.57 446.25h340.86a32 32 0 0028.17-47.17L284.18 82.58c-12.09-22.44-44.27-22.44-56.36 0L57.4 399.08a32 32 0 0028.17 47.17z"
                            fill="none" stroke="#FFEECF" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="32" />
                        <path d="M250.26 195.39l5.74 122 5.73-121.95a5.74 5.74 0 00-5.79-6h0a5.74 5.74 0 00-5.68 5.95z"
                            fill="none" stroke="#FFEECF" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="32" />
                        <path d="M256 397.25a20 20 0 1120-20 20 20 0 01-20 20z" />
                    </svg>
                    <div class="flex flex-col items-end">
                        <p class="text-3xl">3</p>
                        <p>Outstanding</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-4/12 px-2">
            <div class="overflow-hidden  bg-gray-700 shadow-sm sm:rounded-lg">
                <div class="flex py-6 justify-between items-center px-6 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="ionicon size-14" viewBox="0 0 512 512">
                        <path
                            d="M403.29 32H280.36a14.46 14.46 0 00-10.2 4.2L24.4 281.9a28.85 28.85 0 000 40.7l117 117a28.86 28.86 0 0040.71 0L427.8 194a14.46 14.46 0 004.2-10.2v-123A28.66 28.66 0 00403.29 32z"
                            fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="32" />
                        <path d="M352 144a32 32 0 1132-32 32 32 0 01-32 32z" />
                        <path d="M230 480l262-262a13.81 13.81 0 004-10V80" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="32" />
                    </svg>
                    <div class="flex flex-col items-end">
                        <p class="text-3xl">0</p>
                        <p>Vacant rooms</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-3/12 px-2">
            <div class="overflow-hidden  bg-primary-700 shadow-sm sm:rounded-lg">
                <div class="flex py-4 justify-between items-center px-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-16 ionicon" fill="#FFEECF"
                        viewBox="0 0 512 512">
                        <path
                            d="M428 224H288a48 48 0 01-48-48V36a4 4 0 00-4-4h-92a64 64 0 00-64 64v320a64 64 0 0064 64h224a64 64 0 0064-64V228a4 4 0 00-4-4zm-92 160H176a16 16 0 010-32h160a16 16 0 010 32zm0-80H176a16 16 0 010-32h160a16 16 0 010 32z" />
                        <path
                            d="M419.22 188.59L275.41 44.78a2 2 0 00-3.41 1.41V176a16 16 0 0016 16h129.81a2 2 0 001.41-3.41z" />
                    </svg>
                    <div class="flex flex-col items-end">
                        <p class="text-4xl font-semibold">9</p>
                        <p class="text-lg">Invoices</p>
                    </div>
                </div>
                <div class="w-1/1 px-10 py-4 flex justify-end text-white bg-black">
                    See more>>
                </div>
            </div>
        </div>
        <div class="w-3/12 px-2">
            <div class="overflow-hidden  bg-primary-700 shadow-sm sm:rounded-lg">
                <div class="flex py-4 justify-between items-center px-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-16 ionicon" fill="#FFEECF"
                        viewBox="0 0 512 512">
                        <path
                            d="M428 224H288a48 48 0 01-48-48V36a4 4 0 00-4-4h-92a64 64 0 00-64 64v320a64 64 0 0064 64h224a64 64 0 0064-64V228a4 4 0 00-4-4zm-92 160H176a16 16 0 010-32h160a16 16 0 010 32zm0-80H176a16 16 0 010-32h160a16 16 0 010 32z" />
                        <path
                            d="M419.22 188.59L275.41 44.78a2 2 0 00-3.41 1.41V176a16 16 0 0016 16h129.81a2 2 0 001.41-3.41z" />
                    </svg>
                    <div class="flex flex-col items-end">
                        <p class="text-4xl font-semibold">9</p>
                        <p class="text-lg">Invoices</p>
                    </div>
                </div>
                <div class="w-1/1 px-10 py-4 flex justify-end text-white bg-black">
                    See more>>
                </div>
            </div>
        </div>
        <div class="w-3/12 px-2">
            <div class="overflow-hidden  bg-primary-700 shadow-sm sm:rounded-lg">
                <div class="flex py-4 justify-between items-center px-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-16 ionicon" fill="#FFEECF"
                        viewBox="0 0 512 512">
                        <path
                            d="M428 224H288a48 48 0 01-48-48V36a4 4 0 00-4-4h-92a64 64 0 00-64 64v320a64 64 0 0064 64h224a64 64 0 0064-64V228a4 4 0 00-4-4zm-92 160H176a16 16 0 010-32h160a16 16 0 010 32zm0-80H176a16 16 0 010-32h160a16 16 0 010 32z" />
                        <path
                            d="M419.22 188.59L275.41 44.78a2 2 0 00-3.41 1.41V176a16 16 0 0016 16h129.81a2 2 0 001.41-3.41z" />
                    </svg>
                    <div class="flex flex-col items-end">
                        <p class="text-4xl font-semibold">9</p>
                        <p class="text-lg">Invoices</p>
                    </div>
                </div>
                <div class="w-1/1 px-10 py-4 flex justify-end text-white bg-black">
                    See more>>
                </div>
            </div>
        </div>
        <div class="w-3/12 px-2">
            <div class="overflow-hidden  bg-primary-700 shadow-sm sm:rounded-lg">
                <div class="flex py-4 justify-between items-center px-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-16 ionicon" fill="#FFEECF"
                        viewBox="0 0 512 512">
                        <path
                            d="M428 224H288a48 48 0 01-48-48V36a4 4 0 00-4-4h-92a64 64 0 00-64 64v320a64 64 0 0064 64h224a64 64 0 0064-64V228a4 4 0 00-4-4zm-92 160H176a16 16 0 010-32h160a16 16 0 010 32zm0-80H176a16 16 0 010-32h160a16 16 0 010 32z" />
                        <path
                            d="M419.22 188.59L275.41 44.78a2 2 0 00-3.41 1.41V176a16 16 0 0016 16h129.81a2 2 0 001.41-3.41z" />
                    </svg>
                    <div class="flex flex-col items-end">
                        <p class="text-4xl font-semibold">9</p>
                        <p class="text-lg">Invoices</p>
                    </div>
                </div>
                <div class="w-1/1 px-10 py-4 flex justify-end text-white bg-black">
                    See more>>
                </div>
            </div>
        </div>

        <div class="px-2">
            <h1>Recent payments</h1>
            <div class="relative rounded-lg">
                <div class="shadow-md border-solid border-black border-2 rounded-lg">
                    <table class="table-fixed border-spacing-y-2 text-sm">
                        <thead class="bg-gray-700 text-white text-left">
                            <tr>
                                <th>Song</th>
                                <th>Artist</th>
                                <th>Year</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-solid border-black border-t">
                                <td>The Sliding Mr. Bones (Next Stop, Pottersville)</td>
                                <td>Malcolm Lockyer</td>
                                <td>1961</td>
                            </tr>

                            <tr class="border-solid border-black border-t">
                                <td>Witchy Woman</td>
                                <td>The Eagles</td>
                                <td>1972</td>
                            </tr>
                            <tr class="border-solid border-black border-t">
                                <td>Shining Star</td>
                                <td>Earth, Wind, and Fire</td>
                                <td>1975</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>