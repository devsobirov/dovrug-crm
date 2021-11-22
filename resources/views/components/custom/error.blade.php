
<div
    x-data="{ show: errorMessages.length > 0, messages: errorMessages }"
    class="fixed inset-x-0 bottom bottom-0 flex items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-end z-50">
    <div
        x-show="show"
        x-description="Notification panel, show/hide based on alert state."
        @click.away="show = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-90"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-90"
        class="max-w-sm w-full bg-red-600 shadow-lg rounded-lg pointer-events-auto">
        <div class="rounded-lg shadow-xs overflow-hidden">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="ml-3 w-0 flex-1 pt-0.5">
                        <template x-for="error in messages">
                            <p class="text-sm leading-5 font-medium text-gray-200" x-text="error"></p>
                        </template>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button @click="show = false" class="inline-flex text-gray-200 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <button x-data="{click: errorMessages, showError: errorMessages.length > 0, changeE() {this.showError = !this.showError}}" @click="changeE" >
    Show it
    <span x-show="showError" >
        <template x-for="e in errorMessages">
            <p x-text="e"></p>
        </template>
    </span>
</button> --}}