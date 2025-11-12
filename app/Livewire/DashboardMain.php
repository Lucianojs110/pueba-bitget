<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class DashboardMain extends Component
{
    public $symbols = ['BTCUSDT', 'ETHUSDT', 'SOLUSDT'];
    public $prices = [];
    public $lastUpdate;
    public $connected = false;

    protected $listeners = ['bitget:update' => 'refreshPrices'];

    public function mount()
    {
        $this->refreshPrices();
    }

    public function refreshPrices()
    {
        $this->prices = [];

        foreach ($this->symbols as $symbol) {
            $price = Cache::get("bitget_ticker_{$symbol}");
            if ($price) {
                $this->prices[$symbol] = $price;
            }
        }

        $this->lastUpdate = now()->format('H:i:s');
        $this->connected = !empty($this->prices);
    }
    public function render()
    {
        return view('livewire.dashboard-main')->layout('layouts.app');
    }
}
