<x-app-layout>

    <x-slot name="header">
        {{-- Янги фойдаланувчи киритиш --}}
    </x-slot>

    <div x-data="userData">
        <form :action="setFormAction"  method="POST" flex flex-wrap justify-between items-center w-full mb-4 px-4">
            @csrf
            <div x-show="updateForm">
                <input type="hidden" name="_method" value="PATCH" :disabled="!updateForm">
            </div>
            <h4 class="text-lg font-semibold text-gray-600 dark:text-gray-300 mb-6" x-html="setHeader"></h4>
        
            <input type="hidden" name="id" value="{{ $user->id }}">
            <div class="w-full flex flex-wrap justify-start px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <label class="block text-sm w-1/3 px-4 mb-3">
                  <span class="text-gray-700 dark:text-gray-400">Исм шарифи</span>
                  <input class="block w-full mt-1 text-sm  border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" 
                        x-model="formData.name" name="name" value="{{ $user->name }}" required placeholder="Jane Doe"
                        >
                  <span class="text-xs text-gray-600 dark:text-gray-400">
                    Мажбурий майдон
                  </span>
                </label>
    
                <label class="block text-sm w-1/3 px-4 mb-3">
                    <span class="text-gray-700 dark:text-gray-400">Э-почта</span>
                    <input class="block w-full mt-1 text-sm  border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" type="email" 
                        x-model="formData.email" name="email" value="{{  $user->email }}" required placeholder="otabek@dovrug.com....">
                    <span class="text-xs text-gray-600 dark:text-gray-400">
                      Мажбурий, Уникал (такрорланмас), ҳақиқий бўлиши шарт эмас*
                    </span>
                </label>
    
                <label class="block text-sm w-1/3 px-4 mb-3">
                    <span class="text-gray-700 dark:text-gray-400">Телеграм ID</span>
                    <input class="block w-full mt-1 text-sm  border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" 
                        x-model="formData.telegram_id" name="telegram_id" type="number" placeholder="Jane Doe">
                    <span class="text-xs text-gray-600 dark:text-gray-400">
                      Иҳтиёрий,телеграм ботдан ҳабар олиш учун.
                    </span>
                </label>
      
                <label class="block text-sm w-1/3 px-4 mb-3">
                    <span class="text-gray-700 dark:text-gray-400">Янги Пароль</span>
                    <input class="block w-full mt-1 text-sm  border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        x-model="formData.password" name="password" placeholder="A1234a$bs">
                    <span class="text-xs text-gray-600 dark:text-gray-400">
                    Мажбурий майдон, 8 символдан кам бўлмаган.
                    </span>
                </label>
                <label class="block text-sm w-1/3 px-4 mb-3">
                    <span class="text-gray-700 dark:text-gray-400">Парольни тасдиқлаш</span>
                    <input class="block w-full mt-1 text-sm  border border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                        x-model="formData.password_confirmation" name="password_confirmation" placeholder="A1234a$bs">
                    <span class="text-xs text-gray-600 dark:text-gray-400">
                        Мажбурий майдон, киритилган паролни такрорлаши шарт.
                    </span>
                </label>
                <div class="w-full">
                    <span class="block w-full mb-3 text-gray-700 dark:text-gray-400">Фойдаланувчи учун бир ёки бирнечта роль киритинг:</span>
                    <template x-for="(index,role) in roles">
                        <label :class="formData.roles && formData.roles.length > 0 && formData.roles.includes(role) ? 'bg-purple-200' : ''" class="inline-block mr-3 p-2 border border-gray-100 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" :key="role">
                            <span class="inline-block mr-2 text-gray-700 dark:text-gray-400" x-text="index"></span>
                            <input type="checkbox" x-model="formData.roles" name="roles[]" :value="role" class="border border-gray-200 text-purple-600 form-checkbox focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                        </label>
                    </template>
                </div>
                
                <label x-show="userHasRoleDepositor()" class="block my-3 text-sm px-4 mb-3">
                    <span class="block w-full mb-3 text-gray-700 dark:text-gray-400">
                        Фойдаланувчи (складчик) учун тегишли складни киритинг:
                    </span>
                    <select :required="userHasRoleDepositor()" name="depository_id" class="mt-1 text-sm border border-gray-200 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                        <template x-for="(depository) in depositories">
                            <option :value="depository.id" x-text="depository.name"></option>
                        </template>
                    </select>
                </label>

                <div class="w-full flex justify-end">
                    <button x-show="!updateForm" class="flex items-center justify-between mt-4 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg>
                        <span class="block pl-2">Киритиш</span>
                    </button>
                    <button x-show="updateForm" class="flex items-center justify-between mt-4 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        <span class="block pl-2">Таҳрирлаш</span>
                    </button>
                </div>
        </div>
    </form>
    
    
    

    @section('body_scripts')
    <script>
        
        function userRoles (user) {
            let hasRoles = []
            if (user && user.roles && user.roles.length > 0) {
                hasRoles = user.roles
            }
            return hasRoles
        }
        function userData() {
            return {
                headerText: "Янги фойдаланувчи киритиш",
                updateForm : @json($user->exists),
                createAction : "{{ route('director.users.store') }}",
                user : @json($user),
                roles : @json(App\Roles\UserRoles::getRolesList()),
                depositories: @json($depositories),
                formData: {
                    name: "{{ $user->name }}", email: "{{ $user->email }}", telegram_id: "{{ $user->telegram_id }}", password: '', password_confirmation: '', roles: @json($user->roles ? $user->roles : [])
                },
                setHeader() {
                    if (this.updateForm) {
                        this.headerText = "Фойдаланувчи <span class='underline'>" + this.formData.name + '</span> маълумотларини таҳрирлаш'
                    }
                    return this.headerText
                },
                userHasRoleDepositor () {
                    if (this.formData.roles && this.formData.roles.length > 0) {
                        return this.formData.roles.includes('depositor');
                    }
                },
                setFormAction() {
                    let action = this.createAction;
                    if (this.updateForm) {
                        action += '/' + this.user.id
                    }
                    return action;
                }
            }
        }
        //userData().setHeader();
    </script>
    @endsection
</x-app-layout>

