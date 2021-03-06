<x-guest-layout>
    <div class="flex flex-col overflow-y-auto md:flex-row">
        <div class="h-32 md:h-auto md:w-1/2">
            <img aria-hidden="true" class="object-cover w-full h-full dark:hidden"
                 src="{{ asset('crm-panel/images/login-office.jpeg') }}"
                 alt="Office"/>
            <img aria-hidden="true" class="hidden object-cover w-full h-full dark:block"
                 src="../assets/img/login-office-dark.jpeg" alt="Office"/>
        </div>
        <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
            <div class="w-full">
                <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
                    Login
                </h1>

                <x-auth-validation-errors :errors="$errors"/>

                <form method="POST" action="{{ route('login') }}">
                @csrf

                    <!-- Input[ype="email"] -->
                    <div class="mt-4">
                        <x-label :value="__('Email')"/>
                        <input type="email"
                                 id="email"
                                 name="email"
                                 class="block w-full border border-purple-200 focus:border-purple-600 outline-none form-input"
                                 required
                                 autofocus/>
                    </div>

                    <!-- Input[ype="password"] -->
                    <div class="mt-4">
                        <x-label :value="__('Password')"/>
                        <input type="password"
                                 id="password"
                                 name="password"
                                 class="block w-full border border-purple-200 focus:border-purple-600 outline-none form-input"/>
                    </div>

                    <div class="flex mt-6 text-sm">
                        <label class="flex items-center dark:text-gray-400">
                            <input type="checkbox"
                                   name="remember"
                                   class="text-purple-600 border border-purple-200 focus:border-purple-600 form-checkbox focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                            <span class="ml-2">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="mt-4">
                        <x-button class="block w-full">
                            {{ __('Log in') }}
                        </x-button>
                    </div>
                </form>

                <hr class="my-8"/>

                @if (Route::has('password.request'))
                    <p class="mt-4">
                        <a class="text-sm font-medium text-primary-600 dark:text-primary-400 hover:underline"
                           href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    </p>
                @endif
            </div>
        </div>
    </div>
</x-guest-layout>
