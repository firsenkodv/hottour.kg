<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Password::defaults(function () {
            return Password::min(5)
          /*      ->letters()
                ->numbers()
                ->symbols()
                ->mixedCase()
                ->uncompromised()*/;
        });

        $this->registerExternalDirectives();
    }

    /**
     * @external('gtm') ... @else ... @endexternal — обёртка вокруг сторонних
     * подключений, см. config/external.php и хелпер external().
     */
    protected function registerExternalDirectives(): void
    {
        Blade::if('external', fn (string $service = null) => external($service));
    }

}
