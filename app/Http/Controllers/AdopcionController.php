<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\SolicitudAdopcion;
use App\Models\Notificacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdopcionController extends Controller
{
    // Muestra el formulario de adopción
    public function create(Animal $animal)
    {
        if ($animal->estado !== 'disponible') {
            return redirect()->route('animales.show', $animal)->with('error', 'Este animal no está disponible.');
        }

        $ya_solicitado = SolicitudAdopcion::where('id_animal', $animal->id)
            ->where('id_usuario', Auth::id())
            ->where('estado', 'pendiente')
            ->exists();

        return view('adopcion', compact('animal', 'ya_solicitado'));
    }

    // Procesa el envío del formulario
    public function store(Request $request, Animal $animal)
    {
        if ($animal->estado !== 'disponible') {
            return redirect()->route('animales.show', $animal);
        }

        $ya_solicitado = SolicitudAdopcion::where('id_animal', $animal->id)
            ->where('id_usuario', Auth::id())
            ->where('estado', 'pendiente')
            ->exists();

        if ($ya_solicitado) {
            return redirect()->route('adopcion.create', $animal)->with('error', 'Ya tienes una solicitud pendiente para este animal.');
        }

        $request->validate([
            'apellidos'              => 'required|string|max:150',
            'fecha_nacimiento'       => 'required|date|before:-18 years',
            'telefono'               => 'required|string|max:20',
            'direccion'              => 'required|string|max:255',
            'ciudad'                 => 'required|string|max:100',
            'provincia'              => 'required|string|max:100',
            'codigo_postal'          => 'required|string|max:10',
            'familia_miembros'       => 'required|string|max:500',
            'donde_vivira'           => 'required|string|max:500',
            'razones_adoptar'        => 'required|string|max:1000',
            'mascotas_anteriores'    => 'nullable|string|max:500',
            'mascotas_actuales'      => 'nullable|string|max:500',
            'opinion_esterilizacion' => 'required|string|max:500',
            'gasto_veterinario'      => 'required|string|max:500',
            'acepta_visitas'         => 'required|boolean',
            'mensaje'                => 'nullable|string|max:1000',
        ]);

        SolicitudAdopcion::create([
            'id_animal'              => $animal->id,
            'id_usuario'             => Auth::id(),
            'estado'                 => 'pendiente',
            'apellidos'              => $request->apellidos,
            'fecha_nacimiento'       => $request->fecha_nacimiento,
            'telefono'               => $request->telefono,
            'direccion'              => $request->direccion,
            'ciudad'                 => $request->ciudad,
            'provincia'              => $request->provincia,
            'codigo_postal'          => $request->codigo_postal,
            'familia_miembros'       => $request->familia_miembros,
            'donde_vivira'           => $request->donde_vivira,
            'razones_adoptar'        => $request->razones_adoptar,
            'mascotas_anteriores'    => $request->mascotas_anteriores,
            'mascotas_actuales'      => $request->mascotas_actuales,
            'opinion_esterilizacion' => $request->opinion_esterilizacion,
            'gasto_veterinario'      => $request->gasto_veterinario,
            'acepta_visitas'         => $request->acepta_visitas,
            'mensaje'                => $request->mensaje,
        ]);

        $animal->update(['estado' => 'en_proceso']);

        // Notificar al admin
        $admin = User::where('es_admin', true)->first();
        if ($admin) {
            Notificacion::create([
                'id_usuario' => $admin->id,
                'tipo'       => 'solicitud_nueva',
                'mensaje'    => Auth::user()->name . ' ha solicitado adoptar a ' . $animal->nombre . '.',
                'enlace'     => route('admin.solicitudes.index'),
            ]);
        }

        return redirect()->route('animales.show', $animal)->with('exito', '¡Solicitud enviada correctamente!');
    }
}
