<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MensajeContacto;

class MensajeController extends Controller
{
    public function index()
    {
        $filtro = request('filtro');
        $query = MensajeContacto::orderBy('created_at', 'desc');
        if ($filtro === 'leidos')    $query->where('leido', true);
        if ($filtro === 'no_leidos') $query->where('leido', false);
        $mensajes = $query->get();
        return view('admin.mensajes', compact('mensajes', 'filtro'));
    }

    public function marcarLeido(MensajeContacto $mensaje)
    {
        $mensaje->update(['leido' => true]);
        return redirect()->route('admin.mensajes.index', ['filtro' => request('filtro')])->with('exito', 'Mensaje marcado como leído.');
    }

    public function destroy(MensajeContacto $mensaje)
    {
        $mensaje->delete();
        return redirect()->route('admin.mensajes.index', ['filtro' => request('filtro')])->with('exito', 'Mensaje eliminado.');
    }
}
