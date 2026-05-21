@extends('layouts.main')

@section('titulo', 'Mis solicitudes — NombrePaginaWeb')

@section('contenido')
<h1>Mis solicitudes de adopción</h1>

@if($solicitudes->isEmpty())
    <div class="sin-resultados">
        <p>Todavía no has enviado ninguna solicitud de adopción.</p>
        <a href="{{ route('home') }}" class="btn btn-naranja">Ver animales disponibles</a>
    </div>
@else
    <table class="tabla-admin">
        <thead>
            <tr>
                <th>Animal</th>
                <th>Fecha</th>
                <th>Estado</th>
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
                <td>{{ $s->fecha_solicitud }}</td>
                <td><span class="{{ $badges[$s->estado] ?? '' }}">{{ $textos[$s->estado] ?? $s->estado }}</span></td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
@endsection
