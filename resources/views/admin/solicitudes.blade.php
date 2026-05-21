@extends('layouts.main')

@section('titulo', 'Solicitudes de adopcion — NombrePaginaWeb')

@section('contenido')
<h1>Solicitudes de adopcion</h1>

@if($solicitudes->isEmpty())
    <div class="sin-resultados"><p>No hay solicitudes registradas.</p></div>
@else
    <table class="tabla-admin">
        <thead>
            <tr>
                <th>Animal</th><th>Solicitante</th><th>Teléfono</th>
                <th>Mensaje</th><th>Fecha</th><th>Estado</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($solicitudes as $s)
            @php
            $badges = ['pendiente' => 'badge-en-proceso', 'aprobada' => 'badge-disponible', 'rechazada' => 'badge-adoptado'];
            $textos = ['pendiente' => 'Pendiente', 'aprobada' => 'Aprobada', 'rechazada' => 'Rechazada'];
            @endphp
            <tr>
                <td><a href="{{ route('animales.show', $s->animal) }}">{{ $s->animal->nombre }}</a></td>
                <td>{{ $s->usuario->name }}</td>
                <td>{{ $s->telefono }}</td>
                <td>{{ \Illuminate\Support\Str::limit($s->mensaje ?? '', 80) }}</td>
                <td>{{ $s->fecha_solicitud }}</td>
                <td><span class="{{ $badges[$s->estado] ?? '' }}">{{ $textos[$s->estado] ?? $s->estado }}</span></td>
                <td class="acciones">
                    @if($s->estado === 'pendiente')
                        <form method="POST" action="{{ route('admin.solicitudes.aprobar', $s) }}"
                              onsubmit="return confirm('¿Aprobar esta solicitud?')">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary">Aprobar</button>
                        </form>
                        <form method="POST" action="{{ route('admin.solicitudes.rechazar', $s) }}"
                              onsubmit="return confirm('¿Rechazar esta solicitud?')">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-peligro">Rechazar</button>
                        </form>
                    @else
                        Sin acción
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
@endsection
