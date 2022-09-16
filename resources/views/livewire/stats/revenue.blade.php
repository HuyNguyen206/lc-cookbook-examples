<div class="bg-white shadow-md rounded-lg px-4 py-6">
    <div class="flex justify-between items-center">
        <h4 class="text-gray-500 font-medium">Revenue</h4>
        <select id="order" wire:model="currentSelectedDayAmount"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-48 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option selected="">Choose a day amount</option>
            <option value="30">30</option>
            <option value="60">60</option>
            <option value="90">90</option>
        </select>
    </div>
    <div class="text-3xl font-bold mt-4">{{$totalRevenue}}</div>
</div>
