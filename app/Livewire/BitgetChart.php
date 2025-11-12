<?php

namespace App\Livewire;

use Livewire\Component;

class BitgetChart extends Component
{
    public $symbol = 'BTCUSDT';

    public function render()
    {
        return view('livewire.bitget-chart')->layout('layouts.app');;
    }
}
