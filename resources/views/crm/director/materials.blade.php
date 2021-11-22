<x-app-layout>
    <x-slot name="header">
        Ҳомашё омбори 
    </x-slot>
    @php 
        $id = request('depository_id') ? request('depository_id') : 1;
        $depository = $depositories->where('id', $id)->first();
    @endphp
    <div x-data="materialsData" class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">

        <div class="flex justify-between items-center w-full mb-4 px-6">
            <h4 class="text-lg font-semibold text-gray-600 dark:text-gray-300">
                "{{  $depository->name }}" га тегишли ҳомашёлар баланси
            </h4>
        </div>
        <hr class="text-gray-600 dark:text-gray-300 w-full px-4 my-2">
        <!-- Filters -->
        <form action="{{ route('director.materials') }}" class="flex flex-wrap justify-evenly items-center w-full mb-4 px-6">
            <label class="block w-1/5 text-sm px-1">
                <span class="text-gray-700 dark:text-gray-400">Склад</span>
                <select required name="depository_id" class="block border border-gray-300 px-3 py-1 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray">
                @foreach($depositories as $d)
                    <option value="{{ $d->id }}" @if($d->id == $id) {{ 'selected' }} @endif>{{ $d->name }}</option>
                @endforeach
                </select>
            </label>
            <label class="block w-1/5  text-sm px-1">
                <span class="text-gray-700 dark:text-gray-400">Коди ёки Номи</span>
                <input name="code_name" value="{{ request('code_name') }}" placeholder="Ҳомашё коди ёки номи" class="block border border-gray-300 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray px-3 py-1">
            </label>
            <label class="block w-1/5 text-sm px-1">
                <span class="text-gray-700 dark:text-gray-400">Ҳолати</span>
                <select name="status" class="block border border-gray-300 px-3 py-1 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray">
                    <option value="">Барчаси</option>
                    <option @if( request('status') == 'triggered') {{'selected' }} @endif value="triggered">Кам қолган</option>
                    <option @if( request('status') == 'none_stock') {{'selected' }} @endif value="none_stock">Тугаган</option>
                    <option @if( request('status') == 'sufficiently') {{'selected' }} @endif value="sufficiently">Етарли</option>
                </select>
            </label>
            <button class="flex items-center justify-between mt-4 px-2 py-1.5 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9 9a2 2 0 114 0 2 2 0 01-4 0z"></path>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a4 4 0 00-3.446 6.032l-2.261 2.26a1 1 0 101.414 1.415l2.261-2.261A4 4 0 1011 5z" clip-rule="evenodd"></path>
                </svg>
                <span class="block pl-2">Саралаш</span>
            </button>
            <a href="{{ route('director.materials') }}" class="flex items-center justify-between mt-4 px-2 py-1.5 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                <span class="block pl-2">Тозалаш</span>
            </a>
        </form>
        <!-- Data Table -->
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap border border-gray-200 rounded-xl shadow shadow-xs">
                <thead>
                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">Номи</th>
                    <th class="px-4 py-3">Баланс</th>
                    <th class="px-4 py-3">Статус</th>
                    <th class="px-4 py-3">Амалиётлар</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    <template x-show="materials" x-for="m in materials.data">
                        <tr class="text-gray-700 dark:text-gray-400" :key="m.id" >

                            {{-- <td class="px-4 py-3 text-sm" x-text="m.d_name"></td> --}}
                            <td class="px-4 py-3 text-sm" x-text="m.m_name"></td>
                            <td class="px-4 py-3 text-sm" x-text="m.balance + ' ' + m.symbol"></td>
                            <td class="px-4 py-3 text-sm">
                                <span class="inline-block px-2.5 py-1.5 rounded border border-white text-white font-bold" :class="setStatusColor(m)" x-text="setStatus(m)"></span>
                            </td>
                            {{-- <td class="px-4 py-3 text-sm" x-text="m.code"></td> --}}

                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-4 text-sm">
                                    <button title="Маълумот" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                          </svg>
                                    </button>
                                    <button  title="Кирим-чиқим" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
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

    </div>
    @section('body_scripts')
        <script>
            function materialsData() {
                return {
                    materials : @json($materials),
                    depositories : @json($depositories),
                    filter: {
                        name: null, unit_id: null, trashed: null
                    },
                    fetchData: new Form(this.filter),
                    material: {id: '', name : '', code : '', depository_id: '', trigger_limit : '', description: ''},
                    updateRoute: '',
                    deleteRoute: '',
                    formErrors: [],
                    //Modals settings
                    createModalTrigger: false,
                    setStatus(m) {
                        let percentage = ' (' + m.percente * 100 + '%)';
                        let label = 'Етарли';
                        if (m.percente === 0 ) {
                            label = 'Тугаган'  //'Кам қолган' 'Етарли'
                        } else if (m.percente > 0 && m.percente <= 1) {
                            label = 'Кам қолган'
                        }

                        return label + percentage;
                    },
                    setStatusColor (m){
                        let classList = 'bg-green-500';
                        
                        if (m.percente === 0 ) {
                            classList = 'bg-red-500'
                        } else if (m.percente > 0 && m.percente <= 1) {
                            classList = 'bg-yellow-400'
                        }
                        return classList;
                    },
                    openCreateModal() {
                        this.resetFormData()
                        return this.createModalTrigger = true;
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

