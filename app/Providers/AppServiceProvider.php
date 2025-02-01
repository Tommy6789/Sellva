<?php

namespace App\Providers;

use App\Models\keranjang;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
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
        view()->composer('*', function ($view) {
                $cartCount = 0;
                
                if (Auth::check()) {
                    $cartCount = keranjang::where('id_user', Auth::id())->sum('quantity');
                }
        
                $view->with('cartCount', $cartCount);
        });
    }
}
