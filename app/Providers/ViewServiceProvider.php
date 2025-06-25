<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Zona;
use App\Models\KategoriParameter;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('semua_zona', Zona::select('id', 'nama')->orderBy('id', 'asc')->get());
            $view->with('semua_kategori_parameter', KategoriParameter::select('id', 'nama')->orderBy('id', 'asc')->get());
        });
    }
}
