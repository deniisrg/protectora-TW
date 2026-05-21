<?php

namespace App\Http\Controllers;

use App\Models\SolicitudAdopcion;
use Illuminate\Support\Facades\Auth;

class MisSolicitudesController extends Controller
{
    public function index()
    {
        $solicitudes = SolicitudAdopcion::with('animal')
            ->where('id_usuario', Auth::id())
            ->orderBy('fecha_solicitud', 'desc')
            ->get();

        return view('mis_solicitudes', compact('solicitudes'));
    }
}
