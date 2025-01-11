<x-app-layout>
    <div class="flex">
        <x-side-nav activeLink="applications"/>

        <div class="flex-grow flex-1 overflow-y-auto" style="height: calc(100vh - 4rem - 1px);">
            <x-header name="header">
                <div>
                    <nav class="breadcrumbs">
                        <ul class="flex font-medium text-sm">
                            <li class="mr-1"><a href="/dashboard">Dashboard</a></li>
                            <li class="mr-1"> ></li>
                            <li class="mr-1">Applications</li>
                        </ul>
                    </nav>
                    <h1 class="font-bold text-lg">Applications</h1>
                </div>
            </x-header>

            <div class="flex flex-wrap gap-y-4 px-3">
                @if(count($applications) === 0)
                    <p>No applications found.</p>
                @else
                    <table class="table-auto w-full mt-1 rounded-lg shadow-md overflow-hidden">
                        <thead class="bg-gray-300">
                        <tr class="text-left">
                            <th class="px-4 py-2">Tenant Name</th>
                            <th class="px-4 py-2">Application Date</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Phone</th>
                            <th class="px-4 py-2">Site</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white">
                        @foreach($applications as $application)
                            <tr class="border-t border-gray-300 cursor-pointer hover:bg-gray-100">
                                <td class="px-4 py-2">{{ $application['tenant_name'] }}</td>
                                <td class="px-4 py-2">{{ $application['application_date'] }}</td>
                                <td class="px-4 py-2">{{ $application['status'] }}</td>
                                <td class="px-4 py-2">{{ $application['tenant_email'] }}</td>
                                <td class="px-4 py-2">{{ $application['tenant_phone'] }}</td>
                                <td class="px-4 py-2">{{ $application['site_name'] }}</td>
                                <td class="px-4 py-2">
                                    <a href="#" class="text-blue-500">
                                        <ion-icon name="eye" class="size-5 text-gray-500"></ion-icon>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
