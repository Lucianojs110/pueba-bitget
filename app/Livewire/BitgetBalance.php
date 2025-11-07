<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\BitgetService;

class BitgetBalance extends Component
{
    public $balances = [];
    public $error = null;

    public function mount()
    {
        $this->loadBalance();
    }

    public function loadBalance()
    {
        try {
            $bitget = new BitgetService();
            $response = $bitget->getBalance();

            if (isset($response['data'])) {
                $this->balances = $response['data'];
            } else {
                $this->error = $response['msg'] ?? 'Error al obtener el balance';
            }
        } catch (\Throwable $e) {
            $this->error = $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.bitget-balance')->layout('layouts.app');
    }
}
