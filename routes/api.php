<?php



use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

// ----------------------------------------
// 📊 Histórico simulado (para test)
// ----------------------------------------
Route::get('/bitget/history/{symbol}', function ($symbol) {
    $symbol = strtoupper($symbol);
    $price = Cache::get("bitget_ticker_{$symbol}", 100000);

    $data = [];
    $timestamp = time() - 60 * 20; // últimos 20 minutos aprox

    for ($i = 0; $i < 20; $i++) {
        $data[] = [
            'time' => $timestamp + $i * 60,
            'open' => $price - rand(50, 100),
            'high' => $price + rand(50, 100),
            'low'  => $price - rand(150, 200),
            'close' => $price,
        ];
    }

    return response()->json($data);
});

// ----------------------------------------
// ⚡ Precio en tiempo real
// ----------------------------------------
Route::get('/bitget/ticker/{symbol}', function (Request $request, $symbol) {
    $symbol = strtoupper($symbol);
    $price = Cache::get("bitget_ticker_{$symbol}");

    if (!$price) {
        return response()->json(['error' => 'No data'], 404);
    }

    return response()->json([
        'symbol' => $symbol,
        'close'  => (float) $price,
        'time'   => now()->timestamp,
    ]);
});

// ----------------------------------------
// 🕐 Última vela / histórico reciente
// ----------------------------------------
Route::get('/bitget/candle/{symbol}', function ($symbol) {
    $symbol = strtoupper($symbol);
    $candles = Cache::get("bitget_candles_{$symbol}");

    if (!$candles) {
        return response()->json(['error' => 'No data'], 404);
    }

    return response()->json($candles);
});
