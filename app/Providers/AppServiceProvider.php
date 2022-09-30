<?php

namespace App\Providers;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
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
        Model::unguard();
        View::composer('layouts/app-layout', function ($view) {
            $announcement = Announcement::first();
            $view->with('announcement', $announcement);
        });

        Http::macro('weatherApi', function () {
            return Http::baseUrl('https://api.openweathermap.org');
        });
    }
}
