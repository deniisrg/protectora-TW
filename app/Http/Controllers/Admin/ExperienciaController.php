<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experiencia;
use App\Models\Notificacion;
use Illuminate\Support\Facades\Storage;

class ExperienciaController extends Controller
{
    public function index()
    {
        $experiencias = Experiencia::with(['usuario', 'fotos'])
            ->orderByRaw('(estado = "pendiente") DESC')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.experiencias', compact('experiencias'));
    }

    public function aprobar(Experiencia $experiencia)
    {
        $experiencia->update(['estado' => 'aprobada']);

        Notificacion::create([
            'id_usuario' => $experiencia->id_usuario,
            'tipo'       => 'experiencia_aprobada',
            'mensaje'    => 'Tu experiencia "' . $experiencia->titulo . '" ha sido publicada en el feed.',
            'enlace'     => route('experiencias.index'),
        ]);

        return redirect()->route('admin.experiencias.index')->with('exito', 'Experiencia aprobada.');
    }

    public function rechazar(Experiencia $experiencia)
    {
        $id_usuario = $experiencia->id_usuario;
        $titulo     = $experiencia->titulo;

        foreach ($experiencia->fotos as $foto) {
            Storage::disk('public')->delete('experiencias/' . $foto->nombre_archivo);
        }
        $experiencia->delete();

        Notificacion::create([
            'id_usuario' => $id_usuario,
            'tipo'       => 'experiencia_rechazada',
            'mensaje'    => 'Tu experiencia "' . $titulo . '" no ha superado la revisión y no será publicada.',
            'enlace'     => route('experiencias.index'),
        ]);

        return redirect()->route('admin.experiencias.index')->with('exito', 'Experiencia rechazada y eliminada.');
    }
}
