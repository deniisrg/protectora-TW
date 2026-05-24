@extends('layouts.main')

@section('titulo', 'Adoptar — Pawtect')

@section('contenido')
<h1>Animales en adopción</h1>

@php
$nombres_visibles = ['Perro' => 'Perros', 'Gato' => 'Gatos', 'Otro' => 'Otros'];
@endphp

<div class="filtros">
    <span>Filtrar:</span>
    <a href="{{ route('adoptar') }}"
       class="btn btn-sm {{ !$filtro ? 'btn-primary' : 'btn-gris' }}">Todos</a>
    @foreach($especies as $esp)
        <a href="{{ route('adoptar', ['especie' => $esp]) }}"
           class="btn btn-sm {{ $filtro === $esp ? 'btn-primary' : 'btn-gris' }}">
            {{ $nombres_visibles[$esp] ?? $esp }}
        </a>
    @endforeach
</div>

@if($animales->isEmpty())
    <div class="sin-resultados">
        <p>No hay animales disponibles con este filtro en este momento.</p>
        <a href="{{ route('adoptar') }}" class="btn btn-primary" style="margin-top:1rem">Ver todos</a>
    </div>
@else
    <div class="fotos-grid">
        @foreach($animales as $a)
        <a href="{{ route('animales.show', $a) }}" class="foto-tile">
            @if($a->primeraFoto)
                <img src="{{ asset('storage/animales/' . $a->primeraFoto->nombre_archivo) }}"
                     alt="Foto de {{ $a->nombre }}">
            @else
                <div class="foto-tile-placeholder">
                    <span>Sin foto</span>
                </div>
            @endif
            <div class="foto-tile-overlay">
                <span class="foto-tile-nombre">{{ $a->nombre }}</span>
                <span class="foto-tile-meta">{{ $a->raza ?? 'Desconocida' }} &middot; {{ $a->sexo === 'macho' ? 'Macho' : 'Hembra' }}</span>
            </div>
        </a>
        @endforeach
    </div>
@endif
@endsection
