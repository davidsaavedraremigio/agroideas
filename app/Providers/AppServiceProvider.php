<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Menu;
use Auth;

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
        view()->composer('layouts.template', function($view) {
            $area    =   Auth::user()->codArea;
            $view->with('menus', Menu::menus());
        });
    }
}
