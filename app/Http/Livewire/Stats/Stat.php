<?php

namespace App\Http\Livewire\Stats;

use Livewire\Component;
use NumberFormatter;

class Stat extends Component
{
    public $currentSelectedDayAmount = 30;
    public $total;
    public $type;

    public function render()
    {
        switch ($this->type) {
            case 'User':
                $userCount = \App\Models\User::query()->where('created_at', '>=', now()->subDays($this->currentSelectedDayAmount))->count();
                $this->total = $userCount;
                break;
            case 'Order':
                $orderCount = \App\Models\Order::query()->where('created_at', '>=', now()->subDays($this->currentSelectedDayAmount))->count();
                $this->total = $orderCount;
                break;
            case 'Revenue':
                $totalRevenue = \App\Models\Order::query()->where('created_at', '>=', now()->subDays($this->currentSelectedDayAmount))->sum('total');
                $this->total = (new NumberFormatter('vi_VN', NumberFormatter::CURRENCY))->formatCurrency($totalRevenue, 'VND');
                break;
        }

        return view('livewire.stats.stat');
    }
}
