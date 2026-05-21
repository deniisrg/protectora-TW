<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\SolicitudAdopcion;
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
            'telefono' => 'required|string|max:20',
            'mensaje'  => 'nullable|string|max:1000',
        ]);

        SolicitudAdopcion::create([
            'id_animal'  => $animal->id,
            'id_usuario' => Auth::id(),
            'telefono'   => $request->telefono,
            'mensaje'    => $request->mensaje,
            'estado'     => 'pendiente',
        ]);

        $animal->update(['estado' => 'en_proceso']);

        return redirect()->route('animales.show', $animal)->with('exito', '¡Solicitud enviada correctamente!');
    }
}
