<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
    public function boot()
    {
        $APP_data = (object)[];
        $APP_data->APP__name = 'Hundee Admin';
        view()->share('APP_data', $APP_data);

        Paginator::useBootstrap();
    }
}
