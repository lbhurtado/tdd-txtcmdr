<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Classes\Mobile;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
        }

        $this->app->bind('Mobile', function ($number)
        {
            return new Mobile($number);
        });
    }
}
