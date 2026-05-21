@extends('layouts.main')

@section('titulo', 'Animales en adopcion — NombrePaginaWeb')

@section('contenido')
<h1>Animales en adopcion</h1>

@php
$nombres_visibles = ['Perro' => 'Perros', 'Gato' => 'Gatos', 'Otro' => 'Otros'];
@endphp

<div class="filtros">
    <span>Filtrar:</span>
    <a href="{{ route('home') }}"
       class="btn btn-sm {{ !$filtro ? 'btn-primary' : 'btn-gris' }}">Todos</a>
    @foreach($especies as $esp)
        <a href="{{ route('home', ['especie' => $esp]) }}"
           class="btn btn-sm {{ $filtro === $esp ? 'btn-primary' : 'btn-gris' }}">
            {{ $nombres_visibles[$esp] ?? $esp }}
        </a>
    @endforeach
</div>

@if($animales->isEmpty())
    <div class="sin-resultados">
        <p>No hay animales disponibles con este filtro en este momento.</p>
        <a href="{{ route('home') }}" class="btn btn-primary" style="margin-top:1rem">Ver todos</a>
    </div>
@else
    <div class="animales-grid">
        @foreach($animales as $a)
        <div class="animal-card">
            <a href="{{ route('animales.show', $a) }}">
                @if($a->primeraFoto)
                    <img src="{{ asset('storage/animales/' . $a->primeraFoto->nombre_archivo) }}"
                         alt="Foto de {{ $a->nombre }}">
                @else
                    <div class="sin-foto">Sin foto</div>
                @endif
                <div class="card-body">
                    <h3>{{ $a->nombre }}</h3>
                    <p class="meta">
                        {{ $a->raza ?? 'Desconocida' }}
                        &middot;
                        {{ $a->sexo === 'macho' ? 'Macho' : 'Hembra' }}
                    </p>
                </div>
            </a>
        </div>
        @endforeach
    </div>
@endif
@endsection
