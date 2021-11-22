<x-app-layout>
    <x-slot name="header">
        Ҳомайё турларини бошқариш
    </x-slot>

    <div x-data="materialsData" class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">

        <div class="flex justify-between items-center w-full mb-4 px-6">
            <h4 class="text-lg font-semibold text-gray-600 dark:text-gray-300">
                Барча ҳомашёлар
            </h4>
            <button @click="openCreateModal" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                Янги киритиш
            </button>
        </div>
        <hr class="text-gray-600 dark:text-gray-300 w-full px-4 my-2">
        <!-- Filters -->
        <div class="flex flex-wrap justify-evenly items-center w-full mb-4 px-6">
            <h4 class="text-lg font-semibold text-gray-600 dark:text-gray-300">
                Saralash
            </h4>

            <label class="block w-1/5  text-sm px-1">
                <span class="text-gray-700 dark:text-gray-400">Номи буйича</span>
                <input class="block border border-gray-300 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray px-3 py-1 rounded-full"
                       x-model="filter.name" name="name" placeholder="Xomashyo nomi" required>
            </label>
            <label class="block w-1/5 text-sm px-1">
                <span class="text-gray-700 dark:text-gray-400">Ўл./б бўйича</span>
                <select x-model="filter.unit_id" name="unit_id" class="block border border-gray-300 px-3 py-1 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray">
                    <option :value="null" selected>Танланг:</option>
                    <template x-show="units" >
                        <template x-for="unit in units">
                            <option :value="unit.id" x-text="unit.symbol + ' ('+ unit.name +')'" :key="unit.id"></option>
                        </template>
                    </template>
                </select>
            </label>
            <label class="block w-1/5 text-sm px-1">
                <span class="text-gray-700 dark:text-gray-400">Ҳолати бўйича</span>
                <select x-model="filter.trashed" name="unit_id" class="block border border-gray-300 px-3 py-1 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray">
                    <option :value="true" selected>Актив</option>
                    <option :value="false">Ўчирилган</option>
                </select>
            </label>
            <button @click="fetchFiltered" class="px-5 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-400 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">
                Излаш
            </button>
        </div>
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap border border-gray-200 rounded-xl shadow shadow-xs">
                <thead>
                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">#ID</th>
                    <th class="px-4 py-3">Номи</th>
                    <th class="px-4 py-3">Ўлчов/б.</th>
                    <th class="px-4 py-3">Огоҳлантириш қиймати</th>
                    <th class="px-4 py-3">Тартиб коди</th>
                    <th class="px-4 py-3">Амалиётлар</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    <template x-if="materials" x-for="m in materials.data">
                        <tr class="text-gray-700 dark:text-gray-400" >

                            <td class="px-4 py-3 text-sm" :key="m.id" x-text="m.id"></td>
                            <td class="px-4 py-3 text-sm" x-text="m.name"></td>
                            <td class="px-4 py-3 text-sm" x-text="m.unit.symbol"></td>
                            <td class="px-4 py-3 text-sm" x-text="m.trigger_limit"></td>
                            <td class="px-4 py-3 text-sm" x-text="m.code"></td>

                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-4 text-sm">
                                    <button @click="setUpdateModal(m)" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Edit">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                    </button>
                                    <button @click="setDeleteModal(m)" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-400 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                               </div>
                            </td>
                        </tr>
                    </template>
                    <template x-if="materials == false || materials.data.length < 1">
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-center" colspan="6">
                                Ҳомашё турлари топилмади
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        <div class="mt-8">
            {{ $materials->links() }}
        </div>

        <!-- Create Modal -->
        <x-custom.modal trigger="createModalTrigger" header="Янги Ҳомашё киритиш">
            <x-slot name="body">
                <div x-show="formErrors.length > 0">
                    <template x-if="formErrors.length > 0" x-for="message in formErrors">
                        <p x-text="message" class="text-xs text-red-600 dark:text-red-400 text-center"></p>
                    </template>
                </div>
                <form action="{{ route('materials.store') }}" method="POST" class="flex flex-wrap justify-between items-center">
                    @csrf
                    <label class="block w-full text-sm mb-3">
                        <span class="text-gray-700 dark:text-gray-400">Ҳомашё номи*</span>
                        <input class="block border border-gray-300 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                               x-model="material.name" name="name" placeholder="Мисол: mix 1.5 lik,Qizil Emal bo'yoq ..." required>
                    </label>
                    <label class="block w-2/5 text-sm pr-3">
                        <span class="text-gray-700 dark:text-gray-400">Ҳомашё ўлчов бирлиги</span>
                        <select x-model="material.unit_id" name="unit_id" class="block border border-gray-300 px-3 py-2 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray">
                            <option :value="null" selected>Танланг:</option>
                            <template x-if="units" x-for="unit in units">
                                <option :value="unit.id" x-text="unit.symbol + ' ('+ unit.name +')'" :key="unit.id"></option>
                            </template>
                        </select>
                    </label>
                    <label class="block w-3/5  text-sm pl-3">
                        <span class="text-gray-700 dark:text-gray-400">Ҳомашё учун огоҳлатириш қолдиқ қиймати</span>
                        <input class="block border border-gray-300 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                               x-model="material.trigger_limit" name="trigger_limit" placeholder="Xomashyo miqdori qanchadan kamaysa ogohlantirish kerak?" required>
                    </label>
                    <label class="block w-full mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Изоҳ (иҳтиёрий) - ҳомашё ҳақида қўшимча маълумот киритиш учун</span>
                        <textarea x-model="material.description" name="description" class="border border-gray-300 block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" rows="3" placeholder="Ҳомашё турини яхшироқ тушунишга ёрдам берувчи маълумот"></textarea>
                    </label>
                    <button type="submit" id="createForm"></button>
                </form>
            </x-slot>
            <x-slot name="confirm">
                <button @click="submitForm" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Яратиш
                </button>
            </x-slot>
        </x-custom.modal>

        <!-- Update Modal -->
        <x-custom.modal trigger="updateModalTrigger" header="Ҳомашё маълумотларини янгилаш">
            <x-slot name="body">
                <div x-show="formErrors.length > 0">
                    <template x-if="formErrors.length > 0" x-for="message in formErrors">
                        <p x-text="message" class="text-xs text-red-600 dark:text-red-400 text-center"></p>
                    </template>
                </div>
                <form :action="updateRoute" method="POST" class="flex flex-wrap justify-between items-center">
                    @csrf @method('PATCH')
                    <label class="block w-full text-sm mb-3">
                        <span class="text-gray-700 dark:text-gray-400">Ҳомашё номи*</span>
                        <input class="block border border-gray-300 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                               x-model="material.name" name="name" placeholder="Мисол: mix 1.5 lik,Qizil Emal bo'yoq ..." required>
                    </label>
                    <label class="block w-2/5 text-sm pr-3">
                        <span class="text-gray-700 dark:text-gray-400">Ҳомашё ўлчов бирлиги</span>
                        <select x-model="material.unit_id" name="unit_id" class="block border border-gray-300 px-3 py-2 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray">
                            <option :value="null" selected>Танланг:</option>
                            <template x-if="units" x-for="unit in units">
                                <option :value="unit.id" x-text="unit.symbol + ' ('+ unit.name +')'" :key="unit.id"></option>
                            </template>
                        </select>
                    </label>
                    <label class="block w-3/5  text-sm pl-3">
                        <span class="text-gray-700 dark:text-gray-400">Ҳомашё учун огоҳлатириш қолдиқ қиймати</span>
                        <input class="block border border-gray-300 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                               x-model="material.trigger_limit" name="trigger_limit" placeholder="Xomashyo miqdori qanchadan kamaysa ogohlantirish kerak?" required>
                    </label>
                    <label class="block w-full mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Изоҳ (иҳтиёрий) - ҳомашё ҳақида қўшимча маълумот киритиш учун</span>
                        <textarea x-model="material.description" name="description" class="border border-gray-300 block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" rows="3" placeholder="Ҳомашё турини яхшироқ тушунишга ёрдам берувчи маълумот"></textarea>
                    </label>
                    <button type="submit" id="updateForm"></button>
                </form>
            </x-slot>
            <x-slot name="confirm">
                <button @click="submitForm" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Яратиш
                </button>
            </x-slot>
        </x-custom.modal>

        <!-- Delete Modal -->
        <x-custom.modal trigger="deleteModalTrigger" header="Ҳомшёни ўчириш">
            <x-slot name="body">
                <form :action="deleteRoute" method="POST" >
                    @csrf @method('DELETE')
                    <div x-show="formErrors">
                        <p x-text="formErrors" class="text-xs text-red-600 dark:text-red-400 text-center"></p>
                    </div>
                    <template x-if="material.name">
                        <div class="text-center">
                            <span class="text-md text-center text-md" x-text="material.name"></span>
                            <span class="text-red-600 text-center"> ni - o'chirishni xoxlaysizmi?</span>
                        </div>
                    </template>
                    <button id="deleteForm" type="submit"></button>
                </form>
            </x-slot>

            <x-slot name="confirm">
                <button type="submit" @click="submitDeleteForm" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple" >
                    Xa, O'chirilsin
                </button>
            </x-slot>
        </x-custom.modal>
    </div>
    @section('body_scripts')
        <script>
            function materialsData() {
                return {
                    materials : @json($materials),
                    units : @json($units),
                    filter: {
                        name: null, unit_id: null, trashed: null
                    },
                    fetchData: new Form(this.filter),
                    material: {id: '', name : '', code : '', unit_id: '', trigger_limit : '', description: ''},
                    updateRoute: '',
                    deleteRoute: '',
                    formErrors: [],
                    //Modals settings
                    createModalTrigger: false,
                    updateModalTrigger: false,
                    deleteModalTrigger: false,
                    openCreateModal() {
                        this.resetFormData()
                        return this.createModalTrigger = true;
                    },
                    setUpdateModal(model) {
                        this.resetFormData()
                        this.updateRoute = "{{ route('materials.index') }}/" + model.id;
                        this.material = model;
                        this.updateModalTrigger = true;
                    },
                    setDeleteModal(model) {
                        this.resetFormData();
                        this.deleteModalTrigger = true;
                        this.deleteRoute = "{{ route('materials.index') }}/" + model.id;
                        this.material = model;
                    },
                    submitForm() {
                        this.formErrors = [];
                        if(this.material.name === '' || this.material.name == false ) {
                            this.formErrors.push("Ҳомашё номи бўш қолиши мумкин эмас!")
                        }
                        if(this.material.unit_id === '' || this.material.unit_id == false ) {
                            this.formErrors.push("Ҳомашё ўлчами бўш қолиши мумкин эмас!")
                        }
                        if(this.material.trigger_limit === '' || this.material.trigger_limit == false ) {
                            this.formErrors.push("Ҳомашё огоҳлантириш қолдиқ миқдори бўш қолиши мумкин эмас!")
                        }
                        if( this.formErrors.length > 0 ) {
                            return false;
                        }


                        if (this.updateModalTrigger) {
                            document.getElementById('updateForm').click();
                        } else {
                            document.getElementById('createForm').click();
                        }
                    },
                    submitDeleteForm() {
                        if (this.deleteRoute !== '') {
                            document.getElementById('deleteForm').click();
                        } else {
                            this.formErrors = "Noma'lum xatolik, qayta urininb ko'ring!"
                        }
                    },
                    resetFormData() {
                        this.material.id = ''
                        this.material.name = ''
                        this.material.unit_id = ''
                        this.material.code = ''
                        this.material.description =  ''
                        this.updateRoute = ''
                        this.deleteRoute = ''
                    },
                    fetchFiltered()
                    {
                        this.fetchData.post("{{ route('materials.filter') }}")
                            .then(data => this.materials = data)
                            .catch(e => console.log(e));
                    }
                }
            }
        </script>
    @endsection
</x-app-layout>

