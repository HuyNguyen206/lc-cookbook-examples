<?php

namespace App\Http\Livewire;

use App\Models\Song;
use Livewire\Component;

class DragAndDropSong extends Component
{
    public $show = false;

    public function render()
    {
        $songs = \App\Models\Song::query()->orderBy('order')->get();
        return view('livewire.drag-and-drop-song', compact('songs'));
    }

    public function updateSongOrder($newOrder)
    {
        collect($newOrder)->each(function ($order) {
           Song::where('id', $order['value'])->update(['order' => $order['order']]);
        });
        $this->show = true;
    }
}
