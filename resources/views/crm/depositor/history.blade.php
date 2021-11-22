<x-app-layout>
    <x-slot name="header">
        {{ $depository->name }}
    </x-slot>


    <div class="flex justify-between items-center w-full mb-4 px-6">
        <h4 class="text-lg font-semibold text-gray-600 dark:text-gray-300">
            Суннги кирим-чиқим амалиётлари
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
        <div class="py-1.5 px-3">
            {{ $depositLogs->links() }}
        </div>
    </div>

    @section('body_scripts')
        <script></script>
    @endsection
</x-app-layout>

