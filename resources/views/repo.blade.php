<x-app-layout>

    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="py-3 px-6">
                    Id
                </th>
                <th scope="col" class="py-3 px-6">
                    Name
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($repos as $repo)
                <tr class="bg-white border-b">
                    <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{$repo['id']}}
                    </th>
                    <td class="py-4 px-6">
                        {{$repo['name']}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


</x-app-layout>
