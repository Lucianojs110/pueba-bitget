<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use WebSocket\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class BitgetTickerListener extends Command
{
    protected $signature = 'bitget:listen {symbols=BTCUSDT,ETHUSDT,SOLUSDT}';

    protected $description = 'Escucha el WebSocket de Bitget y guarda las cotizaciones en cache';

    public function handle()
    {
        $symbols = explode(',', strtoupper($this->argument('symbols')));

        $this->info('Obteniendo precios iniciales (snapshot)...');

        foreach ($symbols as $symbol) {
            try {
                $resp = Http::get("https://api.bitget.com/api/v2/spot/market/tickers", [
                    'symbol' => $symbol
                ]);

                if ($resp->ok() && isset($resp['data'][0])) {
                    $ticker = $resp['data'][0];
                    $price = $ticker['lastPr'] ?? null;

                    if ($price) {
                        Cache::forever("bitget_ticker_{$symbol}", $price);

                        $this->info("{$symbol} (inicial): {$price}");
                    } else {
                        $this->warn("{$symbol}: no se encontró campo 'lastPr' en respuesta: " . json_encode($ticker));
                    }
                } else {
                    $this->warn("Respuesta inválida para {$symbol}: " . json_encode($resp->json()));
                }
            } catch (\Throwable $e) {
                $this->warn("Error al obtener snapshot de {$symbol}: " . $e->getMessage());
            }
        }


        $this->info('Conectando al WebSocket público de Bitget...');
        $this->listenLoop($symbols);
    }


    private function listenLoop(array $symbols)
    {
        $subscribe = [
            'op' => 'subscribe',
            'args' => collect($symbols)->map(fn($s) => [
                'instType' => 'SPOT',
                'channel'  => 'ticker',
                'instId'   => $s,
            ])->toArray()
        ];

        $lastPrices = [];

        while (true) {
            try {
                $client = new \WebSocket\Client("wss://ws.bitget.com/v2/ws/public", [
                    'timeout' => 60,
                ]);

                $client->send(json_encode($subscribe));
                $this->info('Suscripto al canal TICKER de: ' . implode(', ', $symbols));

                $lastPing = time();

                while (true) {
                    $message = $client->receive();

                    if ($message === '' || $message === null) {
                        throw new \Exception("Empty read; connection dead?");
                    }

                    // Intentar descomprimir si viene comprimido (zlib/gzip)
                    if (!is_string($message)) {
                        $message = @gzdecode($message) ?: $message;
                    } elseif (substr($message, 0, 2) === "\x78\x9c") {
                        $message = @gzdecode($message) ?: $message;
                    }

                    $data = json_decode($message, true);

                    // Ignorar mensajes sin datos de ticker
                    if (empty($data['data'][0])) {
                        continue;
                    }

                    $ticker = $data['data'][0];
                    $symbol = $ticker['instId'] ?? null;
                    $price  = isset($ticker['last']) ? (float)$ticker['last'] : null;

                    if ($symbol && $price) {
                        $prev = $lastPrices[$symbol] ?? null;
                        $lastPrices[$symbol] = $price;

                        Cache::forever("bitget_ticker_{$symbol}", $price);


                        $time = now()->format('H:i:s');
                        $diff = $prev ? $price - $prev : 0;

                        if ($prev === null) {
                            $this->info("[{$time}] {$symbol}: {$price}");
                        } elseif ($diff > 0) {
                            $this->info("[{$time}] {$symbol}: {$price} ▲ +{$diff}");
                        } elseif ($diff < 0) {
                            $this->warn("[{$time}] {$symbol}: {$price} ▼ {$diff}");
                        } else {
                            $this->line("[{$time}] {$symbol}: {$price}");
                        }
                    }

                    // ping cada 20 segundos
                    if (time() - $lastPing >= 20) {
                        $client->send("ping");
                        $this->line("[PING] enviado para mantener la conexión");
                        $lastPing = time();
                    }
                }
            } catch (\Throwable $e) {
                $this->error("Error: " . $e->getMessage());
                $this->warn('Reintentando conexión en 3 segundos...');
                sleep(3);
            }
        }
    }
}
