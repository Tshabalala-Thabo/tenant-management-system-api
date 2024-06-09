<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex flex-wrap gap-y-4 px-3 py-1">
        <table class="table w-100 mt-1 rounded-lg shadow-md overflow-hidden">
            <thead class="table-active bg-gray-500">
                <tr class="bg-gray-500">
                    <th scope="col">Names</th>
                    <th scope="col">Room</th>
                    <th scope="col">Contacts</th>
                    <th scope="col">Rent</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <a href="#"><td>Mark Buthelezi</td></a>
                    <td>3</td>
                    <td>079 132 4301</td>
                    <td>Up to date</td>
                </tr>
                <tr>
                    <td>Jacob Malesa</td>
                    <td>4</td>
                    <td>079 876 1321</td>
                    <td>3 months behind</td>
                </tr>
                <tr>
                    <td>Larry Potter</td>
                    <td>5</td>
                    <td>079 132 4301</td>
                    <td>Up to date</td>
                </tr>
                <tr>
                    <a href="#"><td>Mark Buthelezi</td></a>
                    <td>3</td>
                    <td>079 132 4301</td>
                    <td>Up to date</td>
                </tr>
                <tr>
                    <td>Jacob Malesa</td>
                    <td>4</td>
                    <td>079 876 1321</td>
                    <td>3 months behind</td>
                </tr>
                <tr>
                    <td>Larry Potter</td>
                    <td>5</td>
                    <td>079 132 4301</td>
                    <td>Up to date</td>
                </tr>
                <tr>
                    <a href="#"><td>Mark Buthelezi</td></a>
                    <td>3</td>
                    <td>079 132 4301</td>
                    <td>Up to date</td>
                </tr>
                <tr>
                    <td>Jacob Malesa</td>
                    <td>4</td>
                    <td>079 876 1321</td>
                    <td>3 months behind</td>
                </tr>
                <tr>
                    <td>Larry Potter</td>
                    <td>5</td>
                    <td>079 132 4301</td>
                    <td>Up to date</td>
                </tr>
            </tbody>
        </table>
    </div>
</x-app-layout>