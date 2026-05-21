<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\FotoAnimal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnimalController extends Controller
{
    public function index()
    {
        $animales = Animal::with('primeraFoto')->orderBy('fecha_ingreso', 'desc')->get();
        return view('admin.animales', compact('animales'));
    }

    public function create()
    {
        $especies = ['Gato', 'Otro', 'Perro'];
        return view('admin.nuevo_animal', compact('especies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:100',
            'especie'      => 'required|string',
            'sexo'         => 'required|in:macho,hembra',
            'fecha_ingreso'=> 'required|date',
        ]);

        $animal = Animal::create($request->only([
            'nombre', 'especie', 'raza', 'edad_meses', 'sexo',
            'descripcion', 'estado_salud', 'estado', 'fecha_ingreso',
        ]));

        $this->guardarFotos($request, $animal->id);

        return redirect()->route('admin.animales.index');
    }

    public function edit(Animal $animal)
    {
        $especies = ['Gato', 'Otro', 'Perro'];
        $animal->load('fotos');
        return view('admin.nuevo_animal', compact('animal', 'especies'));
    }

    public function update(Request $request, Animal $animal)
    {
        $request->validate([
            'nombre'       => 'required|string|max:100',
            'especie'      => 'required|string',
            'sexo'         => 'required|in:macho,hembra',
            'fecha_ingreso'=> 'required|date',
        ]);

        $animal->update($request->only([
            'nombre', 'especie', 'raza', 'edad_meses', 'sexo',
            'descripcion', 'estado_salud', 'estado', 'fecha_ingreso',
        ]));

        $this->guardarFotos($request, $animal->id);

        return redirect()->route('admin.animales.index');
    }

    public function destroy(Animal $animal)
    {
        foreach ($animal->fotos as $foto) {
            Storage::disk('public')->delete('animales/' . $foto->nombre_archivo);
        }
        $animal->delete();
        return redirect()->route('admin.animales.index')->with('exito', 'Animal eliminado correctamente.');
    }

    public function destroyFoto(FotoAnimal $foto)
    {
        Storage::disk('public')->delete('animales/' . $foto->nombre_archivo);
        $animalId = $foto->id_animal;
        $foto->delete();
        return redirect()->route('admin.animales.edit', $animalId);
    }

    private function guardarFotos(Request $request, int $animalId): void
    {
        $tipos = ['image/jpeg', 'image/png', 'image/webp'];
        $max   = 2 * 1024 * 1024;

        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $file) {
                if (!$file->isValid()) continue;
                if (!in_array($file->getMimeType(), $tipos)) continue;
                if ($file->getSize() > $max) continue;

                $nombre = $file->store('animales', 'public');
                FotoAnimal::create([
                    'id_animal'      => $animalId,
                    'nombre_archivo' => basename($nombre),
                ]);
            }
        }
    }
}
