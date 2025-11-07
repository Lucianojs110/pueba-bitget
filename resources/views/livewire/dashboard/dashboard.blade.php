<?php

use Livewire\Volt\Component;
use App\Models\Customer;

new class extends Component {
    public int $clientes = 0;
    public int $vehiculos = 0;
    public int $ordenes = 0;

    public function mount()
    {
        $this->clientes = Customer::count();
    }
};
?>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
    <livewire:dashboard.card title="Clientes activos" :value="$clientes" />
    <livewire:dashboard.card title="Órdenes pendientes" :value="$ordenes" />
    <livewire:dashboard.card title="Vehículos registrados" :value="$vehiculos" />

</div>
