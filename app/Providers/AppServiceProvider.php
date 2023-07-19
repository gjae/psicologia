<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Services\ReservaService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(App\Services\ReservaService::class, function ($app) {
            return new ReservaService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //

        Carbon::setLocale('es');
        Carbon::setUTF8(true);
        Carbon::setLocale(config('app.locale'));
    setlocale(LC_ALL, 'es_ES', 'es', 'ES', 'es_ES.utf8');

    }
}
