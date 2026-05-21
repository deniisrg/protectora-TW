@extends('layouts.main')

@section('titulo', 'Gestionar animales — NombrePaginaWeb')

@section('contenido')
@php
function edad_texto_admin($meses) {
    if ($meses === null) return '—';
    $a = intdiv($meses, 12); $m = $meses % 12;
    if ($a === 0) return $m . ' ' . ($m === 1 ? 'mes' : 'meses');
    if ($m === 0) return $a . ' ' . ($a === 1 ? 'año' : 'años');
    return $a . ' ' . ($a === 1 ? 'año' : 'años') . ' y ' . $m . ' ' . ($m === 1 ? 'mes' : 'meses');
}
$badges = ['disponible' => 'badge-disponible', 'en_proceso' => 'badge-en-proceso', 'adoptado' => 'badge-adoptado'];
$textos = ['disponible' => 'Disponible', 'en_proceso' => 'En proceso', 'adoptado' => 'Adoptado'];
@endphp

<div class="section-header">
    <h1>Gestionar animales</h1>
    <a href="{{ route('admin.animales.create') }}" class="btn btn-naranja">+ Nuevo animal</a>
</div>

@if($animales->isEmpty())
    <div class="sin-resultados"><p>No hay animales registrados.</p></div>
@else
    <table class="tabla-admin">
        <thead>
            <tr>
                <th>Foto</th><th>Nombre</th><th>Especie</th>
                <th>Edad</th><th>Sexo</th><th>Estado</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($animales as $a)
            <tr>
                <td>
                    @if($a->primeraFoto)
                        <img src="{{ asset('storage/animales/' . $a->primeraFoto->nombre_archivo) }}"
                             style="width:60px;height:60px;object-fit:cover">
                    @else
                        Sin foto
                    @endif
                </td>
                <td>{{ $a->nombre }}</td>
                <td>{{ $a->especie }}{{ $a->raza ? ' / ' . $a->raza : '' }}</td>
                <td>{{ edad_texto_admin($a->edad_meses) }}</td>
                <td>{{ $a->sexo === 'macho' ? 'Macho' : 'Hembra' }}</td>
                <td><span class="{{ $badges[$a->estado] ?? '' }}">{{ $textos[$a->estado] ?? $a->estado }}</span></td>
                <td class="acciones">
                    <a href="{{ route('admin.animales.edit', $a) }}">Editar</a>
                    <form method="POST" action="{{ route('admin.animales.destroy', $a) }}"
                          onsubmit="return confirm('¿Eliminar este animal?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
@endsection
