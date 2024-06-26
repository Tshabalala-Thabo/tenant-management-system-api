<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex flex-wrap gap-y-4 px-3">
        <!--div class="container">
            <h1>Add New Site</h1>
            <form action="{{ route('sites.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Site Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="url">Site URL</label>
                    <input type="url" class="form-control" id="url" name="url" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Add Site</button>
            </form>
        </div-->
        <ul>
            @foreach ($sites as $site)
                <li>{{ $site->name }} - {{ $site->address }}</li>
            @endforeach
        </ul>
    </div>
</x-app-layout>