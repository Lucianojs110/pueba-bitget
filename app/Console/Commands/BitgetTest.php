<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use WebSocket\Client;

class BitgetTest extends Command
{
    protected $signature = 'bitget:test';
    protected $description = 'Prueba la conexión WebSocket de Bitget y detecta si envía frames comprimidos';

    public function handle()
    {
        $this->info('Conectando al WebSocket público de Bitget...');

        $ws = new Client("wss://ws.bitget.com/v2/ws/public", [
            'timeout' => 20,
        ]);

        $subscribe = [
            "op" => "subscribe",
            "args" => [[
                "instType" => "SPOT",
                "channel"  => "ticker",
                "instId"   => "BTCUSDT",
            ]]
        ];

        $ws->send(json_encode($subscribe));
        $this->info("Suscripto, esperando mensajes...\n");

        while (true) {
            $raw = $ws->receive();
            $len = strlen($raw);
            $hex = bin2hex(substr($raw, 0, 4));

            $this->line("📦 Longitud: {$len} bytes");
            $this->line("🔢 Primeros bytes: {$hex}");

            if (in_array(substr($hex, 0, 4), ['789c', '78da'])) {
                $this->warn("🧩 Parece zlib comprimido");
                $decoded = @zlib_decode($raw);
                if ($decoded) {
                    $this->info("✅ Decodificado:");
                    $this->line($decoded . "\n");
                } else {
                    $this->error("⚠️ Falló zlib_decode()");
                }
            } else {
                $this->info("Texto plano:");
                $this->line($raw . "\n");
            }

            sleep(1);
        }
    }
}
