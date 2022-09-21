<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\RateResource;
use App\Services\CryptoTickerService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RateController extends Controller
{

    /**
     * Get list of rates
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $cryptoTicker = app(CryptoTickerService::class);
        return RateResource::collection($cryptoTicker->getRates());
    }
}
