<x-app-layout>
    <x-slot name="header">
        {{ $depository->name }}
    </x-slot>

    
    
    <div x-cloak x-data="materialsData" class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        
        <div class="flex justify-between items-center w-full mb-4 px-6">
            <h4 class="text-lg font-semibold text-gray-600 dark:text-gray-300">
                Ҳомашё киримини бошқариш
            </h4>
        </div>
        <hr class="text-gray-600 dark:text-gray-300 w-full px-4 my-2">
        <!-- Filters -->
        <div class="flex flex-wrap justify-evenly items-center w-full mb-4 px-0">
            <label class="block w-1/5  text-sm px-1">
                <span class="text-gray-700 dark:text-gray-400 pl-2">Шрих код буйича</span>
                <input class="block border border-gray-300 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray px-3 py-1 rounded"
                       x-model="filters.code" name="code" placeholder="Xomashyo kodi" required>
            </label>
            <label class="block w-1/5  text-sm px-1">
                <span class="text-gray-700 dark:text-gray-400">Номи буйича</span>
                <input class="block border border-gray-300 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray px-3 py-1 rounded"
                       x-model="filters.search" name="search" placeholder="Xomashyo nomi" required>
            </label>
            <label class="block w-1/5 text-sm px-1">
                <span class="text-gray-700 dark:text-gray-400 pl-2">Ўл./б бўйича</span>
                <select x-model="filters.unit_id" name="unit_id" class="block border border-gray-300 px-3 py-1 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray">
                    <option value="" selected>Барчаси:</option>
                    <template x-if="units">
                        <template x-for="unit in units">
                            <option :value="unit.id" x-text="unit.symbol + ' ('+ unit.name +')'" :key="unit.id"></option>
                        </template>
                    </template>
                </select>
            </label>
            <button @click="fetchFiltered" class="flex items-center justify-between mt-4 px-2 py-1.5 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9 9a2 2 0 114 0 2 2 0 01-4 0z" />
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a4 4 0 00-3.446 6.032l-2.261 2.26a1 1 0 101.414 1.415l2.261-2.261A4 4 0 1011 5z" clip-rule="evenodd" />
                </svg>
                <span class="block pl-2">Излаш</span>
            </button>
            <button class="flex items-center justify-between mt-4 px-2 py-1.5 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span class="block pl-2">Тозалаш</span>
            </button>
        </div>

        <!-- Data Table -->
        <div  class="w-full overflow-x-auto rounded-t-lg border border-gray-200 shadow shadow-xs">
            
            <table class="w-full whitespace-no-wrap relative">
                <thead>
                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">Номи</th>
                    <th class="px-4 py-3">Ўлчов/б.</th>
                    <th class="px-4 py-3">Тартиб коди</th>
                    <th class="px-4 py-3">Миқдори</th>
                    <th class="px-4 py-3">Амалиётлар</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                <template x-if="materials && materials.data.length > 0">
                    <template x-for="m in materials.data">
                        <tr class="text-gray-700 dark:text-gray-400" >

                            <td class="px-4 py-3 text-sm" x-text="m.name"></td>
                            <td class="px-4 py-3 text-sm" x-text="m.unit.symbol"></td>
                            <td class="px-4 py-3 text-sm" x-text="m.code"></td>
                            <td class="px-4 py-3 text-sm" x-text="m.amount"></td>
    
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-4 text-sm">
                                    <button @click="openAddModal(m)" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 bg-green-400 text-white rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="block pl-3">Кирим қилиш</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
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
                <span class="flex items-center col-span-3" x-show="materials.total">
                Natija: <span x-text="materials.from"></span> - <span x-text="materials.to"></span> gacha, Jami: <span x-text="materials.total"></span>
                </span>
                <span class="col-span-2"></span>
                <!-- Pagination -->
                <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                    <nav aria-label="Table navigation"  x-show="materials && materials.links.length > 3">
                    <ul class="inline-flex items-center">
                        <template x-for="link in materials.links">
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
        <x-custom.modal x-cloak trigger="addModalTrigger">
            <x-slot name="header">
                <span x-text="headerText"></span>
            </x-slot>
            <x-slot name="body">
                <div x-show="formErrors.length > 0">
                    <template x-if="formErrors.length > 0" x-for="message in formErrors">
                        <p x-text="message" class="text-xs text-red-600 dark:text-red-400 text-center"></p>
                    </template>
                </div>
                <form class="flex flex-wrap items-center" action="{{  route('depositor.income') }}" method="POST">
                    @csrf
                    <input type="hidden" name="material_id" x-model="material.id">
                    <label class="block w-1/5 text-sm mb-3 pr-3">
                        <span class="text-gray-700 dark:text-gray-400">Миқдор:</span>
                        <input class="block py-4 text-md text-center border border-gray-300 w-full mt-1 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                               x-model="addedAmount" name="addedAmount" placeholder="50..." type="number">
                    </label>
                    <label class="block w-2/6 text-sm mb-3 pr-3">
                        <span class="text-gray-700 dark:text-gray-400">Ў/б</span>
                        <input 
                            :value="material.unit.symbol + ' (' + material.unit.name +')'" 
                            class="block py-4 text-md bg-purple-200 border border-gray-300 w-full mt-1 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" readonly>
                    </label>
                    <label class="block w-2/6 text-sm mb-3 pr-3">
                        <span class="text-gray-700 dark:text-gray-400">Ҳомашё номи</span>
                        <input class="block py-4 text-md bg-purple-200 border border-gray-300 w-full mt-1 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                               x-model="material.name" readonly>
                    </label>
                    <label class="block w-full mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Изоҳ (иҳтиёрий) - ҳомашё кирими ҳақида қўшимча маълумот киритиш учун</span>
                        <textarea x-model="material.description" name="description" class="border border-gray-300 block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" rows="3" placeholder="Ҳомашё киримини яхшироқ тушунишга ёрдам берувчи маълумот"></textarea>
                    </label>
                    <button type="submit" id="incomeForm"></button>
                </form>
            </x-slot>
            <x-slot name="confirm">
                <button @click="submitIncomeForm" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Киритиш
                </button>
            </x-slot>
        </x-custom.modal>
        
    </div>

    
    <hr class="text-gray-600 dark:text-gray-300 w-full px-4 my-2">
    <div class="flex justify-between items-center w-full mb-4 px-6">
        <h4 class="text-lg font-semibold text-gray-600 dark:text-gray-300">
            Суннги амалиётлар
        </h4>
    </div>
    <!-- Data Table -->
    <div  class="w-full overflow-x-auto rounded-lg border border-gray-200 shadow shadow-xs ">
        <table class="w-full whitespace-no-wrap ">
            <thead>
            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-white dark:text-gray-400 dark:bg-gray-800">
                <th class="px-4 py-3">Хомашё</th>
                <th class="px-4 py-3">Сана</th>
                <th class="px-4 py-3">Амалиёт</th>
                <th class="px-4 py-3">Миқдори</th>
                <th class="px-4 py-3">Фойдаланувчи</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
            @isset($depositLogs) 
                @foreach($depositLogs as $log)
                    
                <tr class="text-gray-700 dark:text-gray-400 @if($log->type == 1) {{ "bg-green-100" }} @else {{ "bg-red-100" }} @endif">
                    <td class="px-4 py-3 text-sm">{{  $log->material->name }}</td>
                    <td class="px-4 py-3 text-sm">{{  $log->created_at }}</td>
                    <td class="px-4 py-3 text-sm">{{  $log->getTypeAlias() }}</td>
                    <td class="px-4 py-3 text-sm">{{  $log->amount . " ". $log->material->unit->symbol }}</td>
                    <td class="px-4 py-3 text-sm">{{  $log->user->name }}</td>
                </tr>
                @endforeach
            @endisset
            </tbody>
        </table>
    </div>

    @section('body_scripts')
        <script>
            function materialsData () {
                return {
                    materials: @json($materials),
                    units: @json($units),
                    filters: {code: null, search: null, unit_id: null},
                    material: {id: '', name : '',  added: '', unit: {}},
                    addedAmount: 0,
                    updateRoute: '',
                    deleteRoute: '',
                    formErrors: [],
                    //Modals settings
                    addModalTrigger: false,
                    headerText: '',
                    openAddModal(material) {
                        this.resetFormData()
                        this.material = material
                        this.headerText = this.material.name + " - кирим қилиш"
                        return this.addModalTrigger = true;
                    },
                    resetFormData() {
                        this.material = {id: '', name : '',  amount: '', unit: {}},
                        this.headerText = ''
                    },
                    submitIncomeForm() {
                        document.getElementById('incomeForm').click();
                    },
                    fetchFiltered() {
                        axios.get("{{ route('depositor.filter') }}", {
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

