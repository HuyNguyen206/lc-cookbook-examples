<?php

namespace App\Http\Livewire\Stats;

use Livewire\Component;

class UserCount extends Component
{
    public $currentSelectedDayAmount = 30;
    public $userCount;

    public function render()
    {
        $userCount = \App\Models\User::query()->where('created_at', '>=', now()->subDays($this->currentSelectedDayAmount))->count();
        $this->userCount = $userCount;

        return view('livewire.stats.user-count');
    }
}
