<?php

namespace App\Http\Livewire\Stats;

use Livewire\Component;
use NumberFormatter;

class Revenue extends Component
{
    public $currentSelectedDayAmount = 30;
    public $totalRevenue;

    public function render()
    {
        $totalRevenue = \App\Models\Order::query()->where('created_at', '>=', now()->subDays($this->currentSelectedDayAmount))->sum('total');
        $this->totalRevenue = (new NumberFormatter('vi_VN', NumberFormatter::CURRENCY))->formatCurrency($totalRevenue, 'VND');

        return view('livewire.stats.revenue');
    }
}
