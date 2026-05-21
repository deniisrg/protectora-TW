<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\SolicitudAdopcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SolicitudController extends Controller
{
    public function index()
    {
        $solicitudes = SolicitudAdopcion::with(['animal', 'usuario'])
            ->orderByRaw('(estado = "pendiente") DESC')
            ->orderBy('fecha_solicitud', 'desc')
            ->get();

        return view('admin.solicitudes', compact('solicitudes'));
    }

    public function aprobar(SolicitudAdopcion $solicitud)
    {
        if ($solicitud->estado !== 'pendiente') {
            return redirect()->route('admin.solicitudes.index');
        }

        DB::transaction(function () use ($solicitud) {
            $solicitud->update(['estado' => 'aprobada']);
            Animal::where('id', $solicitud->id_animal)->update(['estado' => 'adoptado']);
            SolicitudAdopcion::where('id_animal', $solicitud->id_animal)
                ->where('id', '!=', $solicitud->id)
                ->where('estado', 'pendiente')
                ->update(['estado' => 'rechazada']);
        });

        return redirect()->route('admin.solicitudes.index')->with('exito', 'Solicitud aprobada.');
    }

    public function rechazar(SolicitudAdopcion $solicitud)
    {
        if ($solicitud->estado !== 'pendiente') {
            return redirect()->route('admin.solicitudes.index');
        }

        $solicitud->update(['estado' => 'rechazada']);

        $pendientes = SolicitudAdopcion::where('id_animal', $solicitud->id_animal)
            ->where('estado', 'pendiente')
            ->count();

        if ($pendientes === 0) {
            Animal::where('id', $solicitud->id_animal)
                ->where('estado', 'en_proceso')
                ->update(['estado' => 'disponible']);
        }

        return redirect()->route('admin.solicitudes.index')->with('exito', 'Solicitud rechazada.');
    }
}
