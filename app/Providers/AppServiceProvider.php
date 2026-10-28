<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Hace que la paginación ({{ $items->links() }}) use el estilo de Bootstrap 5
        Paginator::useBootstrapFive();
    }
}