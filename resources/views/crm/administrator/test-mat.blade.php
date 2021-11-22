<x-app-layout>
    <x-slot name="header">
        Ҳомашё турларини бошқариш
    </x-slot>

    <div x-data="materialsData()" class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">

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
        <div class="flex flex-wrap justify-evenly items-center w-full mb-4 px-0">
            {{-- <button class="mt-4 px-4 py-1 text-sm font-medium leading-5 text-purple-400 border-purple-400 duration-150 bg-white border border-transparent rounded-lg">
                
            </button> --}}
            <label class="block w-1/5  text-sm px-1">
                <span class="text-gray-700 dark:text-gray-400 pl-2">Шрих код буйича</span>
                <input class="block border border-gray-300 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray px-3 py-1 rounded"
                       x-model="filters.code" name="code" placeholder="Xomashyo kodi" required>
            </label>
            <label class="block w-1/6  text-sm px-1">
                <span class="text-gray-700 dark:text-gray-400">Номи буйича</span>
                <input class="block border border-gray-300 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray px-3 py-1 rounded"
                       x-model="filters.search" name="search" placeholder="Xomashyo nomi" required>
            </label>
            <label class="block w-1/6 text-sm px-1">
                <span class="text-gray-700 dark:text-gray-400 pl-2">Ўл./б бўйича</span>
                <select x-model="filters.unit_id" name="unit_id" class="block border border-gray-300 px-3 py-1 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray">
                    <option value="" selected>Барчаси:</option>
                    <template x-show="units" x-for="unit in units">
                        <option :value="unit.id" x-text="unit.symbol + ' ('+ unit.name +')'" :key="unit.id"></option>
                    </template>
                </select>
            </label>
            <label class="block w-1/6 text-sm px-1">
                <span class="text-gray-700 dark:text-gray-400">Ҳолати бўйича</span>
                <select x-model="filters.trashed" name="trashed" class="block border border-gray-300 px-3 py-1 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray">
                    <option value="true" selected>Актив</option>
                    <option value="trashed">Ўчирилган</option>
                </select>
            </label>
            <button @click="fetchFiltered" class="flex items-center justify-between mt-4 px-2 py-1.5 text-sm font-medium leading-4 text-white transition-colors duration-150 bg-green-400 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9 9a2 2 0 114 0 2 2 0 01-4 0z" />
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a4 4 0 00-3.446 6.032l-2.261 2.26a1 1 0 101.414 1.415l2.261-2.261A4 4 0 1011 5z" clip-rule="evenodd" />
                </svg>
                <span class="block pl-2">Излаш</span>
            </button>
            <button class="flex items-center justify-between mt-4 px-2 py-1.5 text-sm font-medium leading-4 text-white transition-colors duration-150 bg-green-400 border border-transparent rounded-lg active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-green">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span class="block pl-2">Тозалаш</span>
            </button>
        </div>

        <!-- Data Table -->
        <div class="w-full overflow-x-auto rounded-t-lg border border-gray-200 shadow shadow-xs">
            <table class="w-full whitespace-no-wrap">
                <thead>
                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">#ID</th>
                    <th class="px-4 py-3">Номи</th>
                    <th class="px-4 py-3">Нархи</th>
                    <th class="px-4 py-3">Ўлчов/б.</th>
                    <th class="px-4 py-3">Огоҳ. қиймати</th>
                    <th class="px-4 py-3">Тартиб коди</th>
                    <th class="px-4 py-3">Амалиётлар</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                <template x-show="materials && materials.data.length > 0" x-for="m in materials.data">
                    <tr class="text-gray-700 dark:text-gray-400" >

                        <td class="px-4 py-3 text-sm" :key="m.id" x-text="m.id"></td>
                        <td class="px-4 py-3 text-sm" x-text="m.name"></td>
                        <td class="px-4 py-3 text-sm" x-text="m.price"></td>
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

        <!-- Pagination -->
        <div class="rounded-b-lg overflow-hidden border border-t-0">
            <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 dark:border-gray-700 bg-gray-100 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                <span class="flex items-center col-span-3">
                Natija: <span x-text="materials.from"></span> - <span x-text="materials.to"></span> gacha, Jami: <span x-text="materials.total"></span>
                </span>
                <span class="col-span-2"></span>
                <!-- Pagination -->
                <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                    <nav aria-label="Table navigation">
                    <ul class="inline-flex items-center">
                        <template x-show="materials && materials.links.length > 3" x-for="link in materials.links">
                            <li :key="link.label" >
                                <button @click="fetchFilteredByPg(link.url)" class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple" :class="link.active ? 'text-white bg-purple-600 border border-r-0 border-purple-600 ' : ''" x-html="link.label"></button>
                            </li>
                        </template>
                    </ul>
                    </nav>
                </span>
            </div>
        </div>

        <!-- Create Modal -->
        <x-custom.modal x-cloak trigger="createModalTrigger" header="Янги Ҳомашё киритиш">
            <x-slot name="body">
                <div x-show="formErrors.length > 0">
                    <template x-if="formErrors.length > 0" x-for="message in formErrors">
                        <p x-text="message" class="text-xs text-red-600 dark:text-red-400 text-center"></p>
                    </template>
                </div>
                <form action="{{ route('materials.store') }}" method="POST" class="flex flex-wrap justify-between items-center">
                    @csrf
                    <label class="block w-2/5 text-sm mb-3 pr-3">
                        <span class="text-gray-700 dark:text-gray-400">Ҳомашё номи*</span>
                        <input class="block border border-gray-300 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                               x-model="material.name" name="name" placeholder="Мисол: mix 1.5 lik,Qizil Emal bo'yoq ..." required>
                    </label>
                    <label class="block w-3/5 text-sm mb-3 pl-3">
                        <span class="text-gray-700 dark:text-gray-400">Ҳомашё нархи*</span>
                        <input class="block border border-gray-300 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                               x-model="material.price" name="price" placeholder="Мисол: 15000" required type="number">
                    </label>
                    <label class="block w-2/5 text-sm mb-3 pr-3">
                        <span class="text-gray-700 dark:text-gray-400">Ҳомашё ўлчов бирлиги</span>
                        <select x-model="material.unit_id" name="unit_id" class="block border border-gray-300 px-3 py-2 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray">
                            <option :value="null" selected>Танланг:</option>
                            <template x-show="units && units.length > 0" x-for="unit in units">
                                <option :value="unit.id" x-text="unit.symbol + ' ('+ unit.name +')'" :key="unit.id"></option>
                            </template>
                        </select>
                    </label>
                    <label class="block w-3/5  text-sm mb-3 pl-3">
                        <span class="text-gray-700 dark:text-gray-400">Ҳомашё учун огоҳлатириш қолдиқ қиймати</span>
                        <input class="block border border-gray-300 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                               x-model="material.trigger_limit" name="trigger_limit" placeholder="Xomashyo miqdori qanchadan kamaysa ogohlantirish kerak?" required>
                    </label>
                    <label class="flex flex-wrap w-full text-sm">
                        <span class="text-gray-700 dark:text-gray-400 w-full">Ҳомашё учун уникал код</span>
                        <label class="flex items-center dark:text-gray-400 w-2/5 pr-3">
                            <input type="checkbox" :checked="autoselectCode" @click="autoselectCode = !autoselectCode" class="border border-gray-300 text-purple-600 form-checkbox focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                            <span class="pl-2">
                              Автоматик танлаш
                            </span>
                        </label>
                        <label class="block w-3/5 pr-3">
                            <input class="block border border-gray-300 w-full ml-3 mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray disabled:cursor-not-allowed disabled:bg-gray-200 py-2 px-3"
                               :disabled="autoselectCode" x-model="material.code" name="code" placeholder="Мавжуд штрих кодни киритиш" required>
                        </label>
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
                    <label class="block w-2/5 text-sm mb-3 pr-3">
                        <span class="text-gray-700 dark:text-gray-400">Ҳомашё номи*</span>
                        <input class="block border border-gray-300 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                               x-model="material.name" name="name" placeholder="Мисол: mix 1.5 lik,Qizil Emal bo'yoq ..." required>
                    </label>
                    <label class="block w-3/5 text-sm mb-3 pl-3">
                        <span class="text-gray-700 dark:text-gray-400">Ҳомашё нархи*</span>
                        <input class="block border border-gray-300 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                               x-model="material.price" name="price" placeholder="Мисол: 15000" required type="number">
                    </label>
                    <label class="block w-2/5 text-sm pr-3">
                        <span class="text-gray-700 dark:text-gray-400">Ҳомашё ўлчов бирлиги</span>
                        <select x-model="material.unit_id" name="unit_id" class="block border border-gray-300 px-3 py-2 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray">
                            <option :value="null" selected>Танланг:</option>
                            <template x-show="units" x-for="unit in units">
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
                    Янгилаш
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
                    materials: @json($materials),
                    units: @json($units),
                    filters: {code: null, search: null, unit_id: null, trashed: null},
                    material: {id: '', name : '', price: '', unit_id: '', trigger_limit : '', code : '', description: ''},
                    updateRoute: '',
                    deleteRoute: '',
                    formErrors: [],
                    //Modals settings
                    createModalTrigger: false,
                    autoselectCode: true,
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
                    fetchFiltered() {
                        axios.get("{{ route('materials.filter') }}", {
                            params: this.filters
                        })
                        .then(response => this.materials = response.data)
                        .catch(function (error) {
                            console.log(error);
                        })
                    },
                    fetchFilteredByPg(url) {
                        axios.get(url)
                        .then(response => this.materials = response.data)
                        .catch(function (error) {
                            console.log(error);
                        })
                    }
                }
            }
        </script>
    @endsection
</x-app-layout>

