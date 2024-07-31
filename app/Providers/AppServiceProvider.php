<?php

//AppServiceProvider serve a rendere la variabile $types disponibile in tutte le viste dell'applicazione. 
//Questo è utile quando hai dati che devono essere accessibili globalmente, come una lista di categorie, tipi o altre entità che devono essere visualizzate frequentemente in diverse parti della tua applicazione, come la navbar.


namespace App\Providers;

use App\Models\Type;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // Condividi $types con tutte le viste
        View::composer('*', function ($view) {
            $view->with('types', Type::all());
        });
    }
}
