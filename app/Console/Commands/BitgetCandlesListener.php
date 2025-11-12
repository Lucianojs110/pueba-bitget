<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use WebSocket\Client;

class BitgetCandlesListener extends Command
{
    protected $signature = 'bitget:candles {symbols=BTCUSDT,ETHUSDT,SOLUSDT}';
    protected $description = 'Escucha el WebSocket de Bitget para velas de 1 minuto y las guarda en cache';

    public function handle()
    {
        $symbols = explode(',', strtoupper($this->argument('symbols')));
        $this->info('Conectando al canal candle1m para: ' . implode(', ', $symbols));
        $this->listenLoop($symbols);
    }

    private function listenLoop(array $symbols)
    {
        $subscribe = [
            'op' => 'subscribe',
            'args' => collect($symbols)->map(fn($s) => [
                'instType' => 'SPOT',
                'channel'  => 'candle1m',
                'instId'   => $s,
            ])->toArray()
        ];

        while (true) {
            try {
                $client = new Client("wss://ws.bitget.com/v2/ws/public", [
                    'timeout' => 90, // mantené esto positivo
                    'fragment_size' => 4096, // evita cortes
                ]);

                $client->send(json_encode($subscribe));
                $this->info('✅ Suscripto al canal candle1m de: ' . implode(', ', $symbols));

                $lastPing = time();

                while (true) {
                    $msg = $client->receive();

                    if ($msg === '' || $msg === null) {
                        throw new \Exception('Empty read; connection dead?');
                    }

                    // 🔹 Bitget manda mensajes comprimidos con zlib
                    if (is_string($msg) && substr($msg, 0, 2) === "\x78\x9c") {
                        $decoded = @gzdecode($msg);
                        if ($decoded === false) {
                            $decoded = @zlib_decode($msg);
                        }
                        $msg = $decoded ?: $msg;
                    }

                    $data = json_decode($msg, true);
                    if (!$data) continue;

                    // 🔹 Evento de suscripción
                    if (isset($data['event']) && $data['event'] === 'subscribe') {
                        $this->line('[EVENT] Suscripción confirmada a ' . ($data['arg']['channel'] ?? ''));
                        continue;
                    }

                    // 🔹 PONG recibido
                    if (isset($data['event']) && $data['event'] === 'pong') {
                        $this->line('[PONG] recibido');
                        continue;
                    }

                    // 🔹 Ping keepalive cada 30 s
                    if (time() - $lastPing >= 30) {
                        $client->send(json_encode(['op' => 'ping']));
                        $this->line('[PING] enviado');
                        $lastPing = time();
                    }

                    // 🔹 Ignorar mensajes sin datos
                    if (empty($data['data'][0]) || empty($data['arg']['instId'])) {
                        continue;
                    }

                    $symbol = $data['arg']['instId'];
                    $values = $data['data'][0];

                    if (count($values) < 6) continue;

                    $candleData = [
                        'time'   => (int)($values[0] / 1000),
                        'open'   => (float)$values[1],
                        'high'   => (float)$values[2],
                        'low'    => (float)$values[3],
                        'close'  => (float)$values[4],
                        'volume' => (float)$values[5],
                    ];

                    // 🔹 Cachear último candle
                    Cache::put("bitget_candle_{$symbol}", $candleData, 300);

                    // 🔹 Histórico limitado a 50 velas
                    $key = "bitget_candles_{$symbol}";
                    $history = Cache::get($key, []);
                    $history[] = $candleData;
                    if (count($history) > 50) {
                        $history = array_slice($history, -50);
                    }
                    Cache::put($key, $history, 300);

                    $this->info("[{$symbol}] Cierre: {$candleData['close']}");

                    usleep(100000); // Evita CPU al 100%
                }
            } catch (\Throwable $e) {
                $this->error('❌ Error: ' . $e->getMessage());
                $this->warn('Reintentando conexión en 3 segundos...');
                sleep(3);
            }
        }
    }
}
