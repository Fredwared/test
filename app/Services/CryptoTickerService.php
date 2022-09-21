<?php

namespace App\Services;

use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Class WeatherService
 * @package App\Services
 */
class CryptoTickerService
{
    protected string $baseUrl = 'https://api.coingecko.com/api/v3/';

    /**
     * @return PendingRequest
     */
    private function connection(): PendingRequest
    {
        return Http::baseUrl($this->baseUrl);
    }


    /**
     * Exchange rates
     *
     * @return array
     */
    public function getRates(): array
    {
        try {
            $ratesRequest = $this->connection()->get('exchange_rates');;
            return $ratesRequest->json()['rates'];
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return [];
        }
    }
}
