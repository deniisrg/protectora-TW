@extends('layouts.main')

@section('titulo', 'Mi solicitud — Pawtect')

@section('contenido')
<div style="display:flex; align-items:center; gap:1rem; margin-bottom:1.5rem; flex-wrap:wrap;">
    <h1 style="margin-bottom:0">Mi solicitud para {{ $solicitud->animal->nombre }}</h1>
    @php
        $badges = ['pendiente' => 'badge-en-proceso', 'aprobada' => 'badge-disponible', 'rechazada' => 'badge-adoptado'];
        $textos = ['pendiente' => 'Pendiente', 'aprobada' => 'Aprobada', 'rechazada' => 'Rechazada'];
    @endphp
    <span class="{{ $badges[$solicitud->estado] ?? '' }}" style="font-size:1rem">
        {{ $textos[$solicitud->estado] ?? $solicitud->estado }}
    </span>
</div>

<div class="detalle-solicitud">

    {{-- ANIMAL --}}
    <div class="detalle-seccion">
        <h2 class="detalle-seccion-titulo">Animal solicitado</h2>
        <div class="detalle-fila">
            <span class="detalle-label">Nombre</span>
            <span class="detalle-valor"><a href="{{ route('animales.show', $solicitud->animal) }}">{{ $solicitud->animal->nombre }}</a></span>
        </div>
        <div class="detalle-fila">
            <span class="detalle-label">Especie / Raza</span>
            <span class="detalle-valor">{{ $solicitud->animal->especie }} — {{ $solicitud->animal->raza ?? 'Desconocida' }}</span>
        </div>
        <div class="detalle-fila">
            <span class="detalle-label">Fecha de solicitud</span>
            <span class="detalle-valor">{{ $solicitud->fecha_solicitud }}</span>
        </div>
    </div>

    {{-- DATOS PERSONALES --}}
    <div class="detalle-seccion">
        <h2 class="detalle-seccion-titulo">Datos personales enviados</h2>
        <div class="detalle-fila">
            <span class="detalle-label">Nombre completo</span>
            <span class="detalle-valor">{{ Auth::user()->name }} {{ $solicitud->apellidos }}</span>
        </div>
        <div class="detalle-fila">
            <span class="detalle-label">Fecha de nacimiento</span>
            <span class="detalle-valor">{{ $solicitud->fecha_nacimiento ? \Carbon\Carbon::parse($solicitud->fecha_nacimiento)->format('d/m/Y') : '—' }}</span>
        </div>
        <div class="detalle-fila">
            <span class="detalle-label">Teléfono</span>
            <span class="detalle-valor">{{ $solicitud->telefono }}</span>
        </div>
        <div class="detalle-fila">
            <span class="detalle-label">Dirección</span>
            <span class="detalle-valor">{{ $solicitud->direccion }}, {{ $solicitud->ciudad }}, {{ $solicitud->provincia }} {{ $solicitud->codigo_postal }}</span>
        </div>
    </div>

    {{-- CUESTIONARIO --}}
    <div class="detalle-seccion">
        <h2 class="detalle-seccion-titulo">Cuestionario enviado</h2>
        <div class="detalle-fila detalle-fila-bloque">
            <span class="detalle-label">¿Con quién convives?</span>
            <span class="detalle-valor">{{ $solicitud->familia_miembros ?? '—' }}</span>
        </div>
        <div class="detalle-fila detalle-fila-bloque">
            <span class="detalle-label">¿Dónde vivirá el animal?</span>
            <span class="detalle-valor">{{ $solicitud->donde_vivira ?? '—' }}</span>
        </div>
        <div class="detalle-fila detalle-fila-bloque">
            <span class="detalle-label">Motivo de adopción</span>
            <span class="detalle-valor">{{ $solicitud->razones_adoptar ?? '—' }}</span>
        </div>
        <div class="detalle-fila detalle-fila-bloque">
            <span class="detalle-label">Mascotas anteriores</span>
            <span class="detalle-valor">{{ $solicitud->mascotas_anteriores ?? '—' }}</span>
        </div>
        <div class="detalle-fila detalle-fila-bloque">
            <span class="detalle-label">Mascotas actuales</span>
            <span class="detalle-valor">{{ $solicitud->mascotas_actuales ?? '—' }}</span>
        </div>
        <div class="detalle-fila detalle-fila-bloque">
            <span class="detalle-label">Opinión sobre esterilización</span>
            <span class="detalle-valor">{{ $solicitud->opinion_esterilizacion ?? '—' }}</span>
        </div>
        <div class="detalle-fila detalle-fila-bloque">
            <span class="detalle-label">Gastos veterinarios</span>
            <span class="detalle-valor">{{ $solicitud->gasto_veterinario ?? '—' }}</span>
        </div>
        <div class="detalle-fila">
            <span class="detalle-label">Acepta visita de seguimiento</span>
            <span class="detalle-valor">
                @if($solicitud->acepta_visitas === null) —
                @elseif($solicitud->acepta_visitas) <span class="badge-disponible">Sí</span>
                @else <span class="badge-adoptado">No</span>
                @endif
            </span>
        </div>
        @if($solicitud->mensaje)
        <div class="detalle-fila detalle-fila-bloque">
            <span class="detalle-label">Mensaje adicional</span>
            <span class="detalle-valor">{{ $solicitud->mensaje }}</span>
        </div>
        @endif
    </div>

    <div class="detalle-acciones">
        <a href="{{ route('perfil') }}" class="btn btn-gris">← Volver a mi perfil</a>
    </div>

</div>
@endsection
