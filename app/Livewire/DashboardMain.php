<?php

namespace App\Livewire;

use Livewire\Component;

class DashboardMain extends Component
{
    public $stats = [];

    public $userName = 'Administrador';

    public function render()
    {
        return view('livewire.dashboard-main')->layout('layouts.app');
    }
}
