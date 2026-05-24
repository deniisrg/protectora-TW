<?php

namespace App\Http\Controllers;

use App\Models\Experiencia;
use App\Models\FotoExperiencia;
use App\Models\Notificacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExperienciaController extends Controller
{
    // Feed público
    public function index()
    {
        $experiencias = Experiencia::with(['usuario', 'fotos'])
            ->where('estado', 'aprobada')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('experiencias', compact('experiencias'));
    }

    // Formulario de creación
    public function create()
    {
        return view('experiencia_crear');
    }

    // Guardar nueva experiencia
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:150',
            'texto'  => 'required|string|max:3000',
            'fotos'  => 'required|array|min:1|max:5',
            'fotos.*' => 'image|max:4096',
        ]);

        $experiencia = Experiencia::create([
            'id_usuario' => Auth::id(),
            'titulo'     => $request->titulo,
            'texto'      => $request->texto,
            'estado'     => 'pendiente',
        ]);

        foreach ($request->file('fotos') as $foto) {
            $nombre = $foto->store('experiencias', 'public');
            FotoExperiencia::create([
                'id_experiencia' => $experiencia->id,
                'nombre_archivo' => basename($nombre),
            ]);
        }

        // Notificar al admin
        $admin = User::where('es_admin', true)->first();
        if ($admin) {
            Notificacion::create([
                'id_usuario' => $admin->id,
                'tipo'       => 'experiencia_nueva',
                'mensaje'    => Auth::user()->name . ' ha enviado una nueva experiencia pendiente de revisión.',
                'enlace'     => route('admin.experiencias.index'),
            ]);
        }

        return redirect()->route('experiencias.index')
            ->with('exito', 'Tu experiencia se ha enviado y será revisada antes de publicarse.');
    }
}
