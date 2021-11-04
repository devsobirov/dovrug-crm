<x-guest-layout>
    <div class="flex overflow-y-auto flex-col md:flex-row">
        <div class="h-32 md:h-auto md:w-1/2">
            <img aria-hidden="true" class="object-cover w-full h-full dark:hidden"
                 src="{{ asset('images/forgot-password-office.jpeg') }}" alt="Office"/>
            <img aria-hidden="true" class="hidden object-cover w-full h-full dark:block"
                 src="../assets/img/forgot-password-office-dark.jpeg" alt="Office"/>
        </div>
        <div class="flex justify-center items-center p-6 sm:p-12 md:w-1/2">
            <div class="w-full">
                <h1 class="mb-4 font-semibold text-gray-700 dark:text-gray-200">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </h1>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')"/>

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors"/>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mt-4">
                        <x-label :value="__('Email')"/>
                        <x-input type="email"
                                 name="email"
                                 class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:focus:ring-gray focus-within:text-primary-600 dark:focus-within:text-primary-400"
                                 required/>
                    </div>

                    <x-button class="block mt-4 w-full">
                        {{ __('Email Password Reset Link') }}
                    </x-button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
