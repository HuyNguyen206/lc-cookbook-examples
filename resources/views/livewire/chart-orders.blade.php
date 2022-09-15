@php
    $previousYear = $groupByYearMonthResult->get('Previous year');
    $year = $groupByYearMonthResult->get('Year');
@endphp
<div x-data="{
    init(){
        const labels = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ];

        const data = {
            labels: labels,
            datasets: [{
                label: 'Previous year orders ({{$previousYear->get('year')}})',
                backgroundColor: 'lightgray',
                data: [{{$previousYear->get('totalOrderPerMonth')->implode(',')}}],
            }, {
                label: 'Year orders ({{$year->get('year')}})',
                backgroundColor: 'lightgreen',
                data: [{{$year->get('totalOrderPerMonth')->implode(',')}}],
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {}
        };

        const myChart = new Chart(
{{--            this.$refs.canvas_{{$year->get('year')}},--}}
            document.getElementById('myChart_{{$year->get('year')}}'),
            config
        );
    }
}">
    <div class="mt-5">
        <p>Total order value previous year ({{$previousYear->get('year')}}):
            <span
                class="text-blue-700">{{number_format($previousYear->get('totalValuePerMonthWholeYear'))}}</span>
        </p>
        <p>Total order value for year ({{$year->get('year')}}):
            <span
                class="text-blue-700">{{number_format($year->get('totalValuePerMonthWholeYear'))}}</span>
        </p>
    </div>
    <div class="mt-4">
        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Select an
            option</label>
        <select id="order" wire:model="currentSelectedYear"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-48 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option selected="">Choose a year</option>
            @foreach($inityYears as $initYear)
                <option value="{{$initYear}}"> {{$initYear}}</option>
            @endforeach
        </select>

        <canvas id="myChart_{{$year->get('year')}}" x-ref="canvas_{{$year->get('year')}}"></canvas>
    </div>
</div>
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"
            integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>

    </script>
@endpush
