<?php

namespace App\Http\Controllers;

use App\Models\MensajeContacto;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    public function create()
    {
        return view('contacto');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:100',
            'ciudad'   => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'email'    => 'required|email|max:255',
            'mensaje'  => 'required|string|max:2000',
        ]);

        MensajeContacto::create($request->only('nombre', 'ciudad', 'telefono', 'email', 'mensaje'));

        return redirect()->route('contacto')->with('exito', '¡Mensaje enviado correctamente! Te responderemos pronto.');
    }
}
