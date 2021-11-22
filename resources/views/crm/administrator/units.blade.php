<x-app-layout>
    <x-slot name="header">
        Units
    </x-slot>

    <div x-data="unitsData()" class="w-full overflow-hidden rounded-lg">

        <div class="flex justify-between items-center w-full mb-4 px-6">
            <h4 class="text-lg font-semibold text-gray-600 dark:text-gray-300">
                Barcha o'lchamlar
            </h4>
            <button @click="openModal" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                Yangi kiritish
            </button>
        </div>
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap border border-gray-200  rounded-xl shadow shadow-xs">
                <thead>
                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">#ID</th>
                    <th class="px-4 py-3">Символ</th>
                    <th class="px-4 py-3">Тўлтиқ номи</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                <template x-if="units">
                    <template  x-for="unit in units.data">
                        <tr class="text-gray-700 dark:text-gray-400" >
    
                            <td class="px-4 py-3 text-sm" :key="unit.id" x-text="unit.id"></td>
                            <td class="px-4 py-3 text-sm" x-text="unit.symbol"></td>
                            <td class="px-4 py-3 text-sm" x-text="unit.name"></td>
    
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-4 text-sm">
                                    <button @click="setEditingModel(unit)" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Edit">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                    </button>
                                    <button @click="setDeleteModal(unit.id)" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-400 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </template>
                </tbody>
            </table>
        </div>
        <div class="mt-8">
            {{ $units->links() }}
        </div>


        <!-- Create form -->
        <x-custom.modal trigger="openCreateModal" header="Yangi o'lcham yaratish">

            <x-slot name="body">
                <form action="{{ route('units.store') }}" method="POST" id="createForm" x-ref="createForm">
                    @csrf @method('POST')
                    <div x-show="formErrors">
                        <p x-text="formErrors" class="text-xs text-red-600 dark:text-red-400 text-center"></p>
                    </div>
                    <label class="block text-sm mb-3">
                        <span class="text-gray-700 dark:text-gray-400">O'lcham simvolini kiriting </span>
                        <input class="block border border-gray-300 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                               x-model="symbol" name="symbol" required placeholder="Masalan: gr,  m, m2, sht"
                        >
                    </label>
                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">O'lcham to'liq nomi (ixtiyoriy maydon)</span>
                        <input class="block border border-gray-300 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                               x-model="name" name="name" placeholder="Masalan: Gramm, Metr, Metr kvadrat, Dona"
                        >
                    </label>
                    <button id="crFormSubmit" type="submit"></button>
                </form>
            </x-slot>

            <x-slot name="confirm">
                <button type="submit" @click="submitCreateForm" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple" >
                    Yaratish
                </button>
            </x-slot>

        </x-custom.modal>

        <!-- Update form -->
        <x-custom.modal trigger="openEditModal" header="O'lchov birligini tahrirlash">
            <x-slot name="body">
                <form :action="updateRoute" method="POST" >
                    @csrf @method('PATCH')
                    <div x-show="formErrors">
                        <p x-text="formErrors" class="text-xs text-red-600 dark:text-red-400 text-center"></p>
                    </div>
                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Simvol</span>
                        <input class="block border border-gray-300 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                               x-model="symbol" name="symbol"
                        >
                    </label>
                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">To'liq nomi</span>
                        <input class="block border border-gray-300 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                               x-model="name" name="name"
                        >
                    </label>
                    <button id="upFormSubmit" type="submit"></button>
                </form>
            </x-slot>

            <x-slot name="confirm">
                <button type="submit" @click="submitCreateForm" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple" >
                    Tahrirlash
                </button>
            </x-slot>
        </x-custom.modal>

        <!-- Delete form -->
        <x-custom.modal trigger="openDeleteModal" header="O'lchov birligini o'chirish">
            <x-slot name="body">
                <form :action="deleteRoute" method="POST" >
                    @csrf @method('DELETE')
                    <div x-show="formErrors">
                        <p x-text="formErrors" class="text-xs text-red-600 dark:text-red-400 text-center"></p>
                    </div>
                    <p class="text-md text-red-600 text-center">
                        Haqiqatdan xam o'chirishni xoxlaysizmi?
                    </p>
                    <button id="delFormSubmit" type="submit"></button>
                </form>
            </x-slot>

            <x-slot name="confirm">
                <button type="submit" @click="submitDeleteForm" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple" >
                    Xa, O'chirilsin
                </button>
            </x-slot>
        </x-custom.modal>

    </div>

    <script>
        function unitsData() {
            return {
                units : @json($units),
                id: '',
                symbol: '',
                name: '',
                formErrors: false,
                updateRoute: '',
                deleteRoute: '',
                openCreateModal : false,
                openEditModal: false,
                openDeleteModal: false,
                openModal() {
                    this.resetFormData();
                    return this.openCreateModal = true;
                },
                openUpdateModal() {
                    this.resetFormData();
                    this.openEditModal = true;
                },
                submitCreateForm() {
                    if (this.symbol === '' || this.symbol == false ) {
                        this.formErrors = "Simvol maydoni bo'sh qolishi mumkin emas!";
                        return false;
                    }
                    if (this.openCreateModal) {
                        document.getElementById('crFormSubmit').click();
                    } else {
                        document.getElementById('upFormSubmit').click();
                    }
                },
                submitDeleteForm() {
                    if (this.deleteRoute !== '') {
                        document.getElementById('delFormSubmit').click();
                    } else {
                        this.formErrors = "Noma'lum xatolik, qayta urininb ko'ring!"
                    }
                },
                setEditingModel (model) {
                    this.openUpdateModal()
                    this.updateRoute = "{{ route('units.index') }}/" + model.id;
                    this.name = model.name;
                    this.symbol = model.symbol;
                },
                setDeleteModal(id) {
                    this.resetFormData();
                    this.openDeleteModal = true;
                    this.deleteRoute = "{{ route('units.index') }}/" + id;
                },
                resetFormData() {
                    this.id = ''
                    this.name = ''
                    this.symbol = ''
                    this.formErrors = ''
                    this.updateRoute = ''
                    this.deleteRoute = ''
                }
            }
        }
    </script>
</x-app-layout>

