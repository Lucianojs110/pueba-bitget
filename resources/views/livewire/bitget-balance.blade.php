<div class="bg-gradient-to-br from-white to-blue-50 shadow-md rounded-2xl p-6 max-w-3xl mx-auto border border-blue-100">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
            <span class="text-yellow-500">💰</span> Balance de Bitget
        </h2>

        <button wire:click="loadBalance"
            class="flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-500 text-white font-medium shadow hover:bg-blue-600 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 4v5h.582m15.334 0H20V4m0 0a9 9 0 1 0-7.5 8.937M12 7v5l3 3" />
            </svg>
            Actualizar
        </button>
    </div>

    @if ($error)
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
            {{ $error }}
        </div>
    @endif

    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4">
        @forelse ($balances as $balance)
            <div
                class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:shadow-md transition flex flex-col">
                <div class="text-sm text-gray-500">Moneda</div>
                <div class="text-lg font-semibold text-gray-800 mb-2">{{ $balance['coin'] }}</div>

                <div class="text-sm text-gray-500">Disponible</div>
                <div class="text-2xl font-bold text-green-600 mb-2">
                    {{ number_format($balance['available'], 2) }}
                </div>

                <div class="text-sm text-gray-500">Congelado</div>
                <div class="text-lg font-semibold text-gray-600">
                    {{ number_format($balance['frozen'], 2) }}
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center text-gray-500">
                No hay balances disponibles 💤
            </div>
        @endforelse
    </div>
</div>
