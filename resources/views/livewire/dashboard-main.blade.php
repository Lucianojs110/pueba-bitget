<div class="p-6 bg-white text-gray-900 rounded-xl shadow-md">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-800">
            Mercado en Tiempo Real (Bitget)
        </h2>
        <span
            class="flex items-center text-sm font-medium 
            {{ $connected ? 'text-green-600' : 'text-red-600' }}">
            <span class="text-sm {{ $connected ? 'text-green-400' : 'text-red-400' }}">
                {{ $connected ? '🟢 Conectado' : '🔴 Desconectado' }}
            </span>

        </span>
    </div>

    <table class="w-full text-sm text-gray-800">
        <thead>
            <tr class="border-b border-gray-300 text-gray-600">
                <th class="py-2 text-left">Par</th>
                <th class="py-2 text-right">Precio</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($symbols as $symbol)
                <tr class="border-b border-gray-200">
                    <td class="py-2">{{ $symbol }}</td>
                    <td class="py-2 text-right">
                        {{ $prices[$symbol] ?? '—' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4 text-xs text-gray-500">
        Última actualización: {{ $lastUpdate ?? '—' }}
    </div>

    <script>
        setInterval(() => Livewire.emit('bitget:update'), 5000);
    </script>
</div>
