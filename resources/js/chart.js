const { createChart } = require('lightweight-charts');

window.initChart = async function (symbol) {
    const container = document.getElementById(`chart_${symbol}`);
    if (!container) return;

    const chart = createChart(container, {
        width: container.clientWidth,
        height: 350,
        layout: { background: { color: '#fff' }, textColor: '#222' },
        grid: {
            vertLines: { color: '#eee' },
            horzLines: { color: '#eee' },
        },
        timeScale: { borderColor: '#D1D4DC', rightOffset: 6, barSpacing: 8 },
        rightPriceScale: {
            borderColor: '#D1D4DC',
            scaleMargins: { top: 0.1, bottom: 0.1 },
        },
    });

    chart.applyOptions({
        timeScale: { timeVisible: true, secondsVisible: false },
    });

    const candleSeries = chart.addCandlestickSeries({
        upColor: '#26a69a',
        downColor: '#ef5350',
        borderDownColor: '#ef5350',
        borderUpColor: '#26a69a',
        wickDownColor: '#ef5350',
        wickUpColor: '#26a69a',
    });

    async function loadData() {
        const res = await fetch(`/api/bitget/candle/${symbol}`);
        if (!res.ok) {
            console.warn(`⚠️ No se pudo obtener snapshot (${res.status})`);
            return [];
        }

        const data = await res.json();
        if (!Array.isArray(data)) return [];

        const safeData = data
            .filter(c => c && c.time && c.open != null && c.close != null)
            .map((c, i) => ({
                time: Math.floor(Number(c.time)),
                open: Number(c.open),
                high: Number(c.high),
                low: Number(c.low),
                close: Number(c.close),
            }));

        return safeData;
    }

    const snapshot = await loadData();
    if (snapshot.length === 0) {
        console.warn('⚠️ No hay datos válidos para graficar');
        return;
    }

    // 🧹 NORMALIZAR VELAS DUPLICADAS / TIEMPOS REPETIDOS
    const uniqueMap = {};
    snapshot.forEach(c => {
        if (c && c.time) uniqueMap[c.time] = c; // se queda con la última por timestamp
    });
    const uniqueCandles = Object.values(uniqueMap)
        .sort((a, b) => a.time - b.time)
        .map((c, i) => ({
            ...c,
            time: c.time + i, // agrega 1 segundo por cada vela para asegurar unicidad
        }));

    console.table(uniqueCandles);

    candleSeries.setData(uniqueCandles);
    chart.timeScale().fitContent();

    // 🔁 Actualizar cada 5 segundos
    setInterval(async () => {
        try {
            const candles = await loadData();
            if (candles.length === 0) return;

            const last = candles[candles.length - 1];
            if (!last || Object.values(last).some(v => v == null)) {
                console.error('🚫 Última vela inválida:', last);
                return;
            }

            candleSeries.update(last);

            document.getElementById(`price_${symbol}`).textContent = last.close.toFixed(2);
            document.getElementById(`updated_${symbol}`).textContent = new Date().toLocaleTimeString();
        } catch (e) {
            console.error('Error actualizando gráfico:', e);
        }
    }, 5000);

    window.addEventListener('resize', () => {
        chart.applyOptions({ width: container.clientWidth });
    });
};

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[id^="chart_"]').forEach(c => {
        const symbol = c.id.replace('chart_', '');
        window.initChart(symbol);
    });
});
