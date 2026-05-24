<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notificacion;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // pasar datos de notificaciones a todas las vistas
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $notificaciones_no_leidas = Notificacion::where('id_usuario', Auth::id())
                    ->where('leida', false)
                    ->count();
                $notificaciones_recientes = Notificacion::where('id_usuario', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();
            } else {
                $notificaciones_no_leidas = 0;
                $notificaciones_recientes = collect();
            }
            $view->with(compact('notificaciones_no_leidas', 'notificaciones_recientes'));
        });
    }
}
