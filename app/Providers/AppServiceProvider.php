<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Schema;
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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        Schema::defaultStringLength(191);

        if (App::environment('production')) {
            $url->forceScheme('https');
        }

        Carbon::setLocale(config('app.locale'));

        date_default_timezone_set(config('app.timezone'));

        DB::listen(function($sql) {
            if ($sql->time > 1000) {
                Log::info('SLOW QUERY DETECTED:');
                Log::info($sql->sql);
                Log::info($sql->bindings);
                Log::info($sql->time);
            }
        });

        Queue::looping(function () {
            while (DB::transactionLevel() > 0) {
                DB::rollBack();
            }
        });
    }
}
