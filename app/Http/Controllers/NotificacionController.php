<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    public function index()
    {
        $notificaciones = Notificacion::where('id_usuario', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // marcar todas como leídas al abrir el portal
        Notificacion::where('id_usuario', Auth::id())
            ->where('leida', false)
            ->update(['leida' => true]);

        return view('notificaciones', compact('notificaciones'));
    }

    public function marcarLeida(Notificacion $notificacion)
    {
        abort_if($notificacion->id_usuario !== Auth::id(), 403);
        $notificacion->update(['leida' => true]);
        return redirect($notificacion->enlace ?? route('notificaciones.index'));
    }

    public function marcarTodas()
    {
        Notificacion::where('id_usuario', Auth::id())
            ->where('leida', false)
            ->update(['leida' => true]);

        return back();
    }

    public function destroy(Notificacion $notificacion)
    {
        abort_if($notificacion->id_usuario !== Auth::id(), 403);
        $notificacion->delete();
        return back();
    }

    public function destroyTodas()
    {
        Notificacion::where('id_usuario', Auth::id())->delete();
        return back();
    }
}
