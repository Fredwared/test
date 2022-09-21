<?php

namespace App\Providers;

use App\Services\CryptoFakeTickerService;
use App\Services\CryptoTickerService;
use Illuminate\Support\ServiceProvider;

class InjectorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if($this->app->environment(['local', 'testing'])){
            $this->app->instance(CryptoTickerService::class, new CryptoFakeTickerService());
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
