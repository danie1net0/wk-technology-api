<?php

namespace App\Providers;

use Faker\{Factory, Generator};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Generator::class, fn () => Factory::create('pt_BR'));
    }

    public function boot(): void
    {
    }
}
