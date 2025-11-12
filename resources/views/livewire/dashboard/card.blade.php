<?php

use Livewire\Volt\Component;

new class extends Component {
    public string $title;
    public int|string $value;

    public function mount(string $title, int|string $value = 0): void
    {
        $this->title = $title;
        $this->value = $value;
    }
};
?>

<div class="bg-white border rounded-lg shadow-sm p-4 text-center">
    <h2 class="text-sm font-semibold text-gray-700">{{ $title }}</h2>
    <p class="text-3xl font-bold text-[#0a2d6b] mt-2">{{ $value }}</p>
</div>
