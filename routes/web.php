<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/charts', function () {
    $monthResultByYear = [];
    $groupByYearMonth = \App\Models\Order::query()->select(
        \Illuminate\Support\Facades\DB::raw(
            'sum(total) totalValuePerMonth,
             count(*) totalOrderPerMonth,
            year(created_at) year,
            month(created_at) month'
        )
    )
        ->whereRaw('year(created_at) in (?,?)', [now()->year, now()->subYear()->year])
//        ->where(function (Illuminate\Database\Eloquent\Builder $builder){
//            $builder->whereYear('created_at', date('Y'))
//                ->orWhereYear('created_at', date('Y') - 1);
//        })
        ->groupBy('year', 'month')
        ->orderBy('month')
        ->get()
        ->groupBy('year');
    $groupByYearMonthResult = collect();
    foreach ($groupByYearMonth as $year => $months) {
        for ($i = 1; $i <= 12; $i++) {
            $hasThisMonth = $months->search(function ($order) use($i){
                return $order->month == $i;
            });

            if ($hasThisMonth === false) {
                $groupByYearMonthResult->push((new \App\Models\Order())
                    ->fill(['totalValuePerMonth' => 0,'totalOrderPerMonth' => 0, 'year' => $year, 'month' => $i])) ;
            } else {
                $groupByYearMonthResult->push($months->get($hasThisMonth));
            }
        }
    }
    $groupByYearMonthResult = $groupByYearMonthResult->groupBy('year')
        ->mapWithKeys(function ($months, $year) {
            return [$year === now()->year ? 'This year' : 'Last year' => collect([
                'totalOrderPerMonth' => $months->pluck('totalOrderPerMonth'),
                'totalValuePerMonthWholeYear' => $months->sum('totalValuePerMonth'),
                'year' => $year
            ])];
        });

    return view('charts', compact('groupByYearMonthResult'));
});
