<div class="p-4 bg-white rounded-xl shadow-md">
    <h2 class="text-lg font-semibold text-gray-800 mb-2">
        {{ $symbol }} - Detalle en tiempo real
    </h2>

    <div id="chart_{{ $symbol }}" style="height: 350px;"></div>

    <div class="flex justify-between text-sm text-gray-700 mt-3">
        <span>Precio actual: <span id="price_{{ $symbol }}">—</span></span>
        <span>Última actualización: <span id="updated_{{ $symbol }}">—</span></span>
    </div>

    {{-- Cargar script de gráfico compilado --}}
    <script src="{{ mix('js/chart.js') }}"></script>
</div>
