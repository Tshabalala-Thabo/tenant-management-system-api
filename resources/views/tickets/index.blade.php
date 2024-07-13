<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div>
        <h1 class="text-2xl font-bold mb-4">Create Ticket</h1>

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

        <form action="{{ route('tickets.store') }}" method="POST"
            class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf

            <div class="mb-4">
                <label for="site_id" class="block text-gray-700 text-sm font-bold mb-2">Site:</label>
                <input type="text" name="site_id" id="site_id"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ old('site_id') }}">
            </div>

            <div class="mb-4">
                <label for="room_id" class="block text-gray-700 text-sm font-bold mb-2">Room:</label>
                <input type="text" name="site_id" id="room_id"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ old('room_id') }}">
            </div>

            <div class="mb-4">
                <label for="details" class="block text-gray-700 text-sm font-bold mb-2">Details:</label>
                <input type="text" name="details" id="details"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ old('details') }}">
            </div>


            <div class="flex items-center justify-between">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Create Ticket
                </button>
            </div>
        </form>

    </div>

    <div>
    @foreach($tickets as $ticket)
    <tr>
        <td>{{ $ticket->details }}</td>
        <td>{{ $ticket->provider ? $ticket->provider->name : 'No provider assigned' }}</td>
        <td>{{ $ticket->tenant->name }}</td>
        <td>{{ $ticket->status }}</td>
        <td>{{ $ticket->room->name }}</td>
        <td>{{ $ticket->site->name }}</td>
        <td>{{ $ticket->created_at }}</td>
    </tr>
@endforeach
    </div>
</x-app-layout>