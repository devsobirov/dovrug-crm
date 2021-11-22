<x-app-layout>
    <x-slot name="header">
        Ҳомашё кирими-чиқими тариҳи
    </x-slot>

    
    <hr class="text-gray-600 dark:text-gray-300 w-full px-4 my-2">
    <div class="flex flex-wrap justify-between items-center w-full mb-4 px-6">
        {{-- <h4 class="text-lg font-semibold text-gray-600 dark:text-gray-300">
            Суннги амалиётлар
        </h4>
        
        <hr class="text-gray-600 dark:text-gray-300 w-full px-4 my-2"> --}}
        <!-- Filters -->
        <div class="flex justify-evenly items-center w-full mb-4 px-0">
            <label class="block w-1/6  text-sm px-1">
                <span class="text-gray-700 dark:text-gray-400">Номи буйича</span>
                <input class="block border border-gray-300 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray px-3 py-1 rounded"
                       x-model="filters.search" name="search" placeholder="Xomashyo nomi" required>
            </label>
            <label class="block text-sm px-1">
                <span class="text-gray-700 dark:text-gray-400 pl-2">дан</span>
                <input class="block border border-gray-300 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray px-3 py-1 rounded"
                       type="date" name="code" placeholder="Xomashyo kodi" required>
            </label>
            <label class="block  text-sm px-1">
                <span class="text-gray-700 dark:text-gray-400 pl-2">гача</span>
                <input class="block border border-gray-300 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray px-3 py-1 rounded"
                       type="date" name="code" placeholder="Xomashyo kodi" required>
            </label>
            <label class="block w-1/6 text-sm px-1">
                <span class="text-gray-700 dark:text-gray-400 pl-2">Типи</span>
                <select x-model="filters.unit_id" name="unit_id" class="block border border-gray-300 px-3 py-1 w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray">
                    <option value="" selected>Барчаси:</option>
                    <option value="1">Кирим</option>
                    <option value="0">Чиқим</option>
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
                <th class="px-4 py-3">Сана</th>
                <th class="px-4 py-3">Хомашё</th>
                <th class="px-4 py-3">Амалиёт</th>
                <th class="px-4 py-3">Миқдори</th>
                <th class="px-4 py-3">Фойдаланувчи</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
            @isset($transfers) 
                @foreach($transfers as $log)
                    
                <tr class="text-gray-700 dark:text-gray-400 @if($log->type == 1) {{ "bg-green-100" }} @else {{ "bg-red-100" }} @endif">
                    <td class="px-4 py-3 text-sm">{{  $log->created_at }}</td>
                    <td class="px-4 py-3 text-sm">{{  $log->material->name }}</td>
                    <td class="px-4 py-3 text-sm">{{  $log->getTypeAlias() }}</td>
                    <td class="px-4 py-3 text-sm">{{  $log->amount . " ". $log->material->unit->symbol }}</td>
                    <td class="px-4 py-3 text-sm">{{  $log->user->name }}</td>
                </tr>
                @endforeach
            @endisset
            </tbody>
        </table>

        <div class="p-4">
            {{ $transfers->links() }}
        </div>
    </div>

    @section('body_scripts')
    @endsection
</x-app-layout>

