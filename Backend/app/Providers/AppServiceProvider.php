<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Parameters;
use Illuminate\Support\Facades\View;
use Schema;

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
        Schema::enableForeignKeyConstraints();
        if (!app()->runningInConsole()) {
            View::composer(
                ['layout.head','layout.navbar','layout.aside','pages.email.reponse'],
                function($view)
                {
                    $info=Parameters::first();
                    $view->with('infoormations', $info);
                }
            );
        }
    }
}
