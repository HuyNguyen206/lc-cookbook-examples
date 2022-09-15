<x-app-layout>
    <div class="bg-white rounded-md border my-8 px-6 py-6 mx-40">
        <div>
            <h2 class="text-2xl font-semibold">Charts</h2>
            <div class="mt-5">
                <p>Total order value this year ({{$groupByYearMonthResult->get('This year')->get('year')}}):
                   <span class="text-blue-700">{{number_format($groupByYearMonthResult->get('This year')->get('totalValuePerMonthWholeYear'))}}</p></span>
                <p>Total order value last year ({{$groupByYearMonthResult->get('Last year')->get('year')}}):
                    <span class="text-blue-700">{{number_format($groupByYearMonthResult->get('Last year')->get('totalValuePerMonthWholeYear'))}}</p></span>
            </div>
            <div class="mt-4">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"
                integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA=="
                crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
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
                    label: 'Last year orders',
                    backgroundColor: 'lightgray',
                    data: [{{$groupByYearMonthResult->get('Last year')->get('totalOrderPerMonth')->implode(',')}}],
                }, {
                    label: 'This year orders',
                    backgroundColor: 'lightgreen',
                    data: [{{$groupByYearMonthResult->get('This year')->get('totalOrderPerMonth')->implode(',')}}],
                }]
            };

            const config = {
                type: 'bar',
                data: data,
                options: {}
            };

            const myChart = new Chart(
                document.getElementById('myChart'),
                config
            );
        </script>
    @endpush
</x-app-layout>
