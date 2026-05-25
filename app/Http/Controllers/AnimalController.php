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

        // Contadores
        $total_disponibles = Animal::where('estado', 'disponible')->count();
        $total_adoptados   = Animal::where('estado', 'adoptado')->count();
        $total_en_proceso  = Animal::where('estado', 'en_proceso')->count();

        return view('index', compact('animales', 'especies', 'filtro', 'carrusel', 'total_disponibles', 'total_adoptados', 'total_en_proceso'));
    }

    // Página de adopción con grid y filtros
    public function adoptar(Request $request)
    {
        $especies = ['Perro', 'Gato', 'Otro'];
        $filtro   = $request->query('especie');
        $busqueda = $request->query('q');

        $query = Animal::with('primeraFoto')->where('estado', '!=', 'adoptado');

        if ($filtro && in_array($filtro, $especies)) {
            $query->where('especie', $filtro);
        }

        if ($busqueda) {
            $query->where(function($q) use ($busqueda) {
                $q->where('nombre', 'like', '%' . $busqueda . '%')
                  ->orWhere('raza', 'like', '%' . $busqueda . '%');
            });
        }

        $animales = $query->orderBy('fecha_ingreso', 'desc')->get();

        return view('adoptar', compact('animales', 'especies', 'filtro', 'busqueda'));
    }

    // Ficha detalle de un animal
    public function show(Animal $animal)
    {
        $animal->load('fotos');
        return view('animal', compact('animal'));
    }
}
