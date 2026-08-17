<?php

namespace App\Providers;

use App\Tourvisor\TourvisorSettings;
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

        // Доступы и параметры Tourvisor из админки поверх config/tourvisor.php.
        // Должно выполняться до первого обращения к API — сервис читает
        // config() в конструкторе.
        TourvisorSettings::apply();
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
