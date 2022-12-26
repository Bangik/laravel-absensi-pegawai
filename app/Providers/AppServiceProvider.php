<?php

namespace App\Providers;

use App\Models\Setting;
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
    public function boot()
    {
        view()->composer('layouts.home', function($view){
            $view->with([
                'lat' => Setting::where('name', 'latitude')->first()->value,
                'long' => Setting::where('name', 'longitude')->first()->value,
                'radius' => Setting::where('name', 'radius')->first()->value,
            ]);
        });
    }
}
