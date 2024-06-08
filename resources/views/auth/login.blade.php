<x-guest-layout>
    <div class="flex">
        <div class="w-5/12 bg-gray-200"> <!-- 5 columns wide -->
            <x-auth-card>
                <x-slot name="logo">
                    <a href="/">
                        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                    </a>
                </x-slot>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-label for="email" :value="__('Email')" />

                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                            required autofocus />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-label for="password" :value="__('Password')" />

                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="current-password" />
                    </div>

                    <!-- Remember Me -->
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                name="remember">
                            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                        <x-button class="ml-3 bg-primary-700 text-black">
                            {{ __('Log in') }}
                        </x-button>
                    </div>
                </form>
            </x-auth-card>
        </div>
        <div class="w-7/12 bg-yellow-900"> <!-- 7 columns wide -->
            <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-primary-700 px-24">
                <div class="flex items-centre justify-center flex-col">
                    <img class="mx-24 mb-4" src="/images/data-ext.svg" alt="">
                    <h1 class="text-center font-extrabold text-2xl">Simplifying property management</h1>
                    <p class="text-center">Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta quibusdam amet iure magnam dignissimos, totam aliquam dicta asperiores delectus libero?</p>
                </div>
            </div>
        </div>
    </div>


</x-guest-layout>