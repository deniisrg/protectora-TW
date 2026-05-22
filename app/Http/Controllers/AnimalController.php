<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    // Listado principal con filtro por especie
    public function index(Request $request)
    {
        $especies = ['Perro', 'Gato', 'Otro'];
        $filtro   = $request->query('especie');

        $query = Animal::with('primeraFoto')->where('estado', '!=', 'adoptado');

        if ($filtro && in_array($filtro, $especies)) {
            $query->where('especie', $filtro);
        }

        $animales = $query->orderBy('fecha_ingreso', 'desc')->get();

        // Animales para el carrusel: los que tienen foto, máximo 6
        $carrusel = Animal::with('primeraFoto')
            ->where('estado', 'disponible')
            ->whereHas('primeraFoto')
            ->inRandomOrder()
            ->limit(6)
            ->get();

        return view('index', compact('animales', 'especies', 'filtro', 'carrusel'));
    }

    // Página de adopción con grid y filtros
    public function adoptar(Request $request)
    {
        $especies = ['Perro', 'Gato', 'Otro'];
        $filtro   = $request->query('especie');

        $query = Animal::with('primeraFoto')->where('estado', '!=', 'adoptado');

        if ($filtro && in_array($filtro, $especies)) {
            $query->where('especie', $filtro);
        }

        $animales = $query->orderBy('fecha_ingreso', 'desc')->get();

        return view('adoptar', compact('animales', 'especies', 'filtro'));
    }

    // Ficha detalle de un animal
    public function show(Animal $animal)
    {
        $animal->load('fotos');
        return view('animal', compact('animal'));
    }
}
