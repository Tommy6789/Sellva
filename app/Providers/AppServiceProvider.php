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
                // Count distinct products in the user's cart
                $cartCount = keranjang::where('id_user', Auth::id())->distinct('id_produk')->count('id_produk');
            }
        
            $view->with('cartCount', $cartCount);
        });
    }
}
