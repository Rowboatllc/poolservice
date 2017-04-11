<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(
                'App\Repositories\PageRepositoryInterface', 
                'App\Repositories\PageRepository'
        );
        $this->app->bind(
                'App\Repositories\OptionRepositoryInterface', 
                'App\Repositories\OptionRepository'
        );
        $this->app->bind(
                'App\Repositories\CompanyRepositoryInterface', 
                'App\Repositories\CompanyRepository'
        );
    }
}
