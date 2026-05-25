<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Notificacion;
use App\Models\SolicitudAdopcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SolicitudController extends Controller
{
    public function index(Request $request)
    {
        $query = SolicitudAdopcion::with(['animal', 'usuario']);

        if ($request->filled('usuario')) {
            $query->whereHas('usuario', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->usuario . '%');
            });
        }

        if ($request->filled('animal')) {
            $query->whereHas('animal', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->animal . '%');
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $orden = $request->get('orden', 'reciente');
        match ($orden) {
            'antigua'    => $query->orderBy('fecha_solicitud', 'asc'),
            'nombre'     => $query->orderBy(
                                \App\Models\User::select('name')
                                    ->whereColumn('id', 'solicitudes_adopcion.id_usuario')
                                    ->limit(1)
                            ),
            default      => $query->orderByRaw('(estado = "pendiente") DESC')
                                  ->orderBy('fecha_solicitud', 'desc'),
        };

        $solicitudes = $query->get();

        return view('admin.solicitudes', compact('solicitudes'));
    }

    public function destroy(SolicitudAdopcion $solicitud)
    {
        $solicitud->delete();

        return redirect()->route('admin.solicitudes.index')->with('exito', 'Solicitud eliminada.');
    }

    public function show(SolicitudAdopcion $solicitud)
    {
        $solicitud->load(['animal', 'usuario']);
        return view('admin.solicitud_detalle', compact('solicitud'));
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

        Notificacion::create([
            'id_usuario' => $solicitud->id_usuario,
            'tipo'       => 'solicitud_aprobada',
            'mensaje'    => '¡Enhorabuena! Tu solicitud para adoptar a ' . $solicitud->animal->nombre . ' ha sido aprobada.',
            'enlace'     => route('mis_solicitudes.show', $solicitud),
        ]);

        return redirect()->route('admin.solicitudes.index')->with('exito', 'Solicitud aprobada.');
    }

    public function rechazar(SolicitudAdopcion $solicitud)
    {
        if ($solicitud->estado !== 'pendiente') {
            return redirect()->route('admin.solicitudes.index');
        }

        $solicitud->update(['estado' => 'rechazada']);

        Notificacion::create([
            'id_usuario' => $solicitud->id_usuario,
            'tipo'       => 'solicitud_rechazada',
            'mensaje'    => 'Tu solicitud para adoptar a ' . $solicitud->animal->nombre . ' no ha podido ser aprobada.',
            'enlace'     => route('mis_solicitudes'),
        ]);

        return redirect()->route('admin.solicitudes.index')->with('exito', 'Solicitud rechazada.');
    }
}
