<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BitgetService
{
    protected $apiKey;

    protected $apiSecret;

    protected $passphrase;

    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('BITGET_API_KEY');
        $this->apiSecret = env('BITGET_API_SECRET');
        $this->passphrase = env('BITGET_API_PASSPHRASE');
        $this->baseUrl = env('BITGET_BASE_URL', 'https://api.bitget.com');
    }

    private function sign($timestamp, $method, $requestPath, $body = '')
    {
        $message = $timestamp.strtoupper($method).$requestPath.$body;

        return base64_encode(hash_hmac('sha256', $message, $this->apiSecret, true));
    }

    public function getBalance()
    {
        $timestamp = (string) round(microtime(true) * 1000);

        $method = 'GET';
        $endpoint = '/api/v2/spot/account/assets';
        $body = '';

        $signature = $this->sign($timestamp, $method, $endpoint, $body);

        $response = Http::withHeaders([
            'ACCESS-KEY' => $this->apiKey,
            'ACCESS-SIGN' => $signature,
            'ACCESS-TIMESTAMP' => $timestamp,
            'ACCESS-PASSPHRASE' => $this->passphrase,
            'Content-Type' => 'application/json',
        ])->get($this->baseUrl.$endpoint);

        return $response->json();
    }
}
