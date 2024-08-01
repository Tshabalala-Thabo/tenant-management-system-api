@props(['activeLink' => null])
<div :class="{'block': openSideNav, 'hidden': ! openSideNav}" class="flex flex-col justify-between pt-4 bg-primary-600">
    <!-- <div :class="{'block': open, 'hidden': ! open}" class="sm:hidden"> -->
    <div>
        <div class="mx-6 pb-2">
            <x-responsive-nav-link
                class="rounded-lg py-2 pl-6 pr-6 {{ $activeLink == 'dashboard' ? 'bg-primary-100 font-semibold text-black' : 'bg-transparent text-black' }} flex items-center"
                href="/dashboard" :active="$activeLink == 'dashboard'">
                <ion-icon name="{{ $activeLink == 'dashboard' ? 'apps' : 'apps-outline' }}"
                          class="size-6 mr-6"></ion-icon>
                <p class="{{ $activeLink == 'dashboard' ? 'font-semibold' : 'font-normal' }}">{{ __('Dashboard') }}</p>
            </x-responsive-nav-link>
        </div>
        <div class="pb-2 mx-6">
            <x-responsive-nav-link
                class="rounded-lg py-2 pl-6 pr-6 {{ $activeLink == 'tenants' ? 'bg-primary-100 font-semibold text-black' : 'bg-transparent text-black' }} flex items-center"
                href="/tenants" :active="$activeLink == 'tenants'">
                <ion-icon
                    name="{{ $activeLink == 'tenants' ? 'people' : 'people-outline' }}"
                    class="size-6 mr-6"></ion-icon>
                <p class="{{ $activeLink == 'tenants' ? 'font-semibold' : 'font-normal' }}">{{ __('Tenants') }}</p>
            </x-responsive-nav-link>
        </div>
        <div class="pb-2 mx-6">
            <x-responsive-nav-link
                class="rounded-lg py-2 pl-6 pr-6 {{ $activeLink == 'invoices' ? 'bg-primary-100 font-semibold text-black' : 'bg-transparent text-black' }} flex items-center"
                href="/invoices" :active="$activeLink == 'invoices'">
                <ion-icon name="{{ $activeLink == 'invoices' ? 'document-text' : 'document-text-outline' }}" class="size-6 mr-6"></ion-icon>
                <p class="{{ $activeLink == 'invoices' ? 'font-semibold' : 'font-normal' }}">{{ __('Invoices') }}</p>
            </x-responsive-nav-link>
        </div>
        <div class="pb-2 mx-6">
            <x-responsive-nav-link
                class="rounded-lg py-2 pl-6 pr-6 {{ $activeLink == 'sites' ? 'bg-primary-100 font-semibold text-black' : 'bg-transparent text-black' }} flex items-center"
                href="/sites" :active="$activeLink == 'sites'">
                <ion-icon
                    name="{{ $activeLink == 'sites' ? 'business' : 'business-outline' }}"
                    class="size-6 mr-6"></ion-icon>
                <p class="{{ $activeLink == 'sites' ? 'font-semibold' : 'font-normal' }}">{{ __('Sites') }}</p>
            </x-responsive-nav-link>
        </div>
        <div class="pb-2 mx-6">
            <x-responsive-nav-link
                class="rounded-lg py-2 pl-6 pr-6 {{ $activeLink == 'tickets' ? 'bg-primary-100 font-semibold text-black' : 'bg-transparent text-black' }} flex items-center"
                href="/tickets" :active="$activeLink == 'tickets'">
                <ion-icon name="{{ $activeLink == 'tickets' ? 'hammer' : 'hammer-outline' }}" class="size-6 mr-6"></ion-icon>
                <p class="{{ $activeLink == 'tickets' ? 'font-semibold' : 'font-normal' }}">{{ __('Maintenance') }}</p>
            </x-responsive-nav-link>
        </div>
    </div>

    <div class="">
        <!-- <div class="px-4">
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div> -->

        <div class="mt-3 space-y-1 text-right py-1 px-4 bg-black text-white">
            <p class="text-sm font-italic text-gray-300">Developed by</p>
            <p class="font-semibold mt-0">Thabo Tshabalala</p>
        </div>
    </div>
</div>

