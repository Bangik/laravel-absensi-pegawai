<?php

namespace App\Providers;

use App\Models\Setting;
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
        view()->composer('layouts.home', function($view){
            $view->with([
                'lat' => Setting::where('name', 'latitude')->first()->value,
                'long' => Setting::where('name', 'longitude')->first()->value,
                'radius' => Setting::where('name', 'radius')->first()->value,
            ]);
        });

        view()->composer('*', function($view){
            $view->with([
                'site_name' => Setting::where('name', 'site_name')->first()->value,
                'time_in' => Setting::where('name', 'time_in')->first()->value,
                'time_out' => Setting::where('name', 'time_out')->first()->value,
            ]);
        });

        Paginator::useBootstrap();
    }
}
