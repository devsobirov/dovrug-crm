<x-app-layout>
    <x-slot name="header">
        Барча фойдаланувчилар
    </x-slot>

    
    <div class="flex flex-wrap justify-between items-center w-full mb-4 px-6">
        <h4 class="text-lg font-semibold text-gray-600 dark:text-gray-300">
            Барча фойдаланувчилар
        </h4>
        <a href="{{ route('director.users.create') }}" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
            Янги киритиш
        </a>
        
        <hr class="text-gray-600 dark:text-gray-300 w-full px-4 my-2">
        <!-- Filters -->
        <div class="flex justify-evenly items-center w-full mb-4 px-0">
            <label class="block w-1/5  text-sm px-1">
                <span class="text-gray-700 dark:text-gray-400">Исм</span>
                <input class="block border border-gray-300 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray px-3 py-1 rounded"
                       x-model="filters.search" name="search" placeholder="ФИО" required>
            </label>
            <label class="block w-1/5  text-sm px-1">
                <span class="text-gray-700 dark:text-gray-400">Э-почта</span>
                <input class="block border border-gray-300 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray px-3 py-1 rounded"
                       x-model="filters.search" name="search" placeholder="director@mail.com" required>
            </label>
            <label class="block w-1/5 text-sm px-1">
                <span class="text-gray-700 dark:text-gray-400 pl-2">Роль</span>
                <select x-model="filters.unit_id" name="unit_id" class="block border border-gray-300 px-3 py-1 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray">
                    <option value="" selected>Барчаси:</option>
                @foreach ($roles as $key => $role)
                <option value="{{ $key }}" selected>{{ $role }}</option>
                @endforeach
                </select>
            </label>
            <button @click="fetchFiltered" class="flex items-center justify-between mt-4 px-2 py-1.5 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9 9a2 2 0 114 0 2 2 0 01-4 0z" />
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a4 4 0 00-3.446 6.032l-2.261 2.26a1 1 0 101.414 1.415l2.261-2.261A4 4 0 1011 5z" clip-rule="evenodd" />
                </svg>
                <span class="block pl-2">Саралаш</span>
            </button>
            <button class="flex items-center justify-between mt-4 px-2 py-1.5 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span class="block pl-2">Тозалаш</span>
            </button>
        </div>
    </div>
    <!-- Data Table -->
    <div  class="w-full overflow-x-auto rounded-lg border border-gray-200 shadow shadow-xs ">
        <table class="w-full whitespace-no-wrap ">
            <thead>
            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-white dark:text-gray-400 dark:bg-gray-800">
                <th class="px-4 py-3">Исм</th>
                <th class="px-4 py-3">Email</th>
                <th class="px-4 py-3">Роллар</th>
                <th class="px-4 py-3">Яратилган</th>
                <th class="px-4 py-3">Амалиётлар</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
            @isset($users) 
                @foreach($users as $user)
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3 text-sm">{{  $user->name }}</td>
                    <td class="px-4 py-3 text-sm">{{  $user->email }}</td>
                    <td class="px-4 py-3 text-sm  w-1/5">
                        <div class="flex flex-wrap">
                        @foreach($user->roles as $role)
                            @php
                                $name = $user->getRoleAlias($role);
                                $color = $user->getRoleColor($role);
                            @endphp
                            <div class="px-3 py-2 rounded-md inline-block mx-2 my-1 bg-{{ $color }}-400 text-white"> {{ $name }} </div>
                        @endforeach
                        </div>
                    </td>
                    <td class="px-4 py-3 text-sm">{{  $user->created_at }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center space-x-4 text-sm">
                            <a href="{{ route('director.users.edit', $user->id) }}" target="_blank" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Edit">
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                </svg>
                            </a>
                            <button @click="setDeleteModal(m)" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-400 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Delete">
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            @endisset
            </tbody>
        </table>

        <div class="p-4">
            {{ $users->links() }}
        </div>
    </div>

    @section('body_scripts')
    @endsection
</x-app-layout>

