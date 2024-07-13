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
</x-app-layout>