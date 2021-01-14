<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Faker\Factory as Factory;
use Faker\Generator as Generator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Generator::class, function () {
            return Factory::create('pt_BR');
        });
    }
}
