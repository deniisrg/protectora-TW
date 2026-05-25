@extends('layouts.main')

@section('titulo', 'Adoptar — Pawtect')

@section('contenido')
<h1>Animales en adopción</h1>

@php
$nombres_visibles = ['Perro' => 'Perros', 'Gato' => 'Gatos', 'Otro' => 'Otros'];
@endphp

<input type="checkbox" id="toggle-filtros" class="filtros-toggle-check">
<div class="filtros">
    <label for="toggle-filtros" class="filtros-toggle-btn" title="Mostrar/ocultar filtros">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="6" x2="20" y2="6"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="18" x2="20" y2="18"/></svg>
    </label>
    <span>Filtrar:</span>
    <a href="{{ route('adoptar') }}"
       class="btn btn-sm {{ !$filtro ? 'btn-primary' : 'btn-gris' }}">Todos</a>
    @foreach($especies as $esp)
        <a href="{{ route('adoptar', ['especie' => $esp]) }}"
           class="btn btn-sm {{ $filtro === $esp ? 'btn-primary' : 'btn-gris' }}">
            {{ $nombres_visibles[$esp] ?? $esp }}
        </a>
    @endforeach

    <form method="GET" action="{{ route('adoptar') }}" class="buscador-form">
        @if($filtro)
            <input type="hidden" name="especie" value="{{ $filtro }}">
        @endif
        <div class="buscador-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" name="q" placeholder="Buscar por nombre o raza..." value="{{ $busqueda ?? '' }}" class="buscador-input">
        </div>
    </form>
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
