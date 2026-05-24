<?php

namespace App\Http\Controllers;

use App\Models\SolicitudAdopcion;
use Illuminate\Support\Facades\Auth;

class MisSolicitudesController extends Controller
{
    public function show(SolicitudAdopcion $solicitud)
    {
        // Asegurarse de que la solicitud pertenece al usuario logueado
        abort_if($solicitud->id_usuario !== Auth::id(), 403);

        $solicitud->load('animal');

        return view('mi_solicitud_detalle', compact('solicitud'));
    }
}
