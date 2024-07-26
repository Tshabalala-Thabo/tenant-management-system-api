{{-- resources/views/components/grid-item.blade.php --}}
@props(['icon', 'count', 'text', 'link'])


<a href="{{ $link }}" class="h-min bg-white rounded-lg transition-transform transition-colors duration-300 transform hover:scale-100 hover:bg-primary-300">
    <div class="shadow-md sm:rounded-lg">
        <div class="flex py-4 justify-between items-center px-6">
            <ion-icon name="{{ $icon }}" class="size-16 text-primary-600"></ion-icon>
            <div class="flex flex-col items-end">
                <p class="text-4xl font-semibold">{{ $count }}</p>
                <p class="text-lg text-gray-500">{{ $text }}</p>
            </div>
        </div>
    </div>
</a>

