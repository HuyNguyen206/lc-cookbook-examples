<?php

namespace App\Http\Livewire\Stats;

use Livewire\Component;

class OrderCount extends Component
{
    public $currentSelectedDayAmount = 30;
    public $orderCount;

    public function render()
    {
        $orderCount = \App\Models\Order::query()->where('created_at', '>=', now()->subDays($this->currentSelectedDayAmount))->count();
        $this->orderCount = $orderCount;

        return view('livewire.stats.order-count');
    }
}
