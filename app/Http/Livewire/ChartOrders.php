<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ChartOrders extends Component
{
    public $inityYears;
    public $currentSelectedYear;

    public function mount()
    {
        $this->currentSelectedYear = date('Y');
    }

    public function render()
    {
        $this->inityYears = [date('Y') - 2, date('Y') - 1, date('Y')];

        $groupByYearMonth = \App\Models\Order::query()->select(
            \Illuminate\Support\Facades\DB::raw(
                'sum(total) totalValuePerMonth,
             count(*) totalOrderPerMonth,
            year(created_at) year,
            month(created_at) month'
            )
        )
            ->whereRaw('year(created_at) in (?,?)', [$this->currentSelectedYear, $this->currentSelectedYear - 1])
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
//        dd($groupByYearMonthResult);
        $groupByYearMonthResult = $groupByYearMonthResult->groupBy('year')
            ->mapWithKeys(function ($months, $year) {
                return [$year === (int) $this->currentSelectedYear ? 'Year' : 'Previous year' => collect([
                    'totalOrderPerMonth' => $months->pluck('totalOrderPerMonth'),
                    'totalValuePerMonthWholeYear' => $months->sum('totalValuePerMonth'),
                    'year' => $year
                ])];
            });
//        dd($groupByYearMonthResult);
        return view('livewire.chart-orders', compact('groupByYearMonthResult'));
    }
}
