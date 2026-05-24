@extends('layouts.main')

@section('titulo', 'Experiencias — Pawtect')

@section('contenido')
<h1>Experiencias de usuarios</h1>

@if($experiencias->isEmpty())
    <div class="sin-resultados"><p>No hay experiencias pendientes.</p></div>
@else
    <div class="experiencias-feed">
        @foreach($experiencias as $exp)
        @php
            $badges = ['pendiente' => 'badge-en-proceso', 'aprobada' => 'badge-disponible', 'rechazada' => 'badge-adoptado'];
            $textos = ['pendiente' => 'Pendiente', 'aprobada' => 'Aprobada', 'rechazada' => 'Rechazada'];
        @endphp
        <div class="experiencia-card">
            <div class="experiencia-fotos">
                @if($exp->fotos->count() === 1)
                    <img src="{{ asset('storage/experiencias/' . $exp->fotos->first()->nombre_archivo) }}"
                         alt="{{ $exp->titulo }}" class="experiencia-foto-unica">
                @else
                    <div class="experiencia-fotos-grid">
                        @foreach($exp->fotos->take(4) as $foto)
                        <div class="experiencia-foto-item">
                            <img src="{{ asset('storage/experiencias/' . $foto->nombre_archivo) }}" alt="">
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="experiencia-contenido">
                <div class="experiencia-autor">
                    @if($exp->usuario->foto_perfil)
                        <img src="{{ Storage::url($exp->usuario->foto_perfil) }}" alt="{{ $exp->usuario->name }}" class="experiencia-avatar experiencia-avatar-foto">
                    @else
                        <div class="experiencia-avatar">{{ strtoupper(substr($exp->usuario->name, 0, 1)) }}</div>
                    @endif
                    <div>
                        <span class="experiencia-nombre">{{ $exp->usuario->name }}</span>
                        <span class="experiencia-fecha">{{ $exp->created_at->diffForHumans() }}</span>
                    </div>
                    <span class="{{ $badges[$exp->estado] ?? '' }}" style="margin-left:auto">{{ $textos[$exp->estado] ?? $exp->estado }}</span>
                </div>
                <h2 class="experiencia-titulo">{{ $exp->titulo }}</h2>
                <p class="experiencia-texto">{{ $exp->texto }}</p>

                @if($exp->estado === 'pendiente')
                <div class="experiencia-acciones">
                    <form method="POST" action="{{ route('admin.experiencias.aprobar', $exp) }}"
                          onsubmit="return confirm('¿Aprobar esta experiencia?')">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary">Aprobar</button>
                    </form>
                    <form method="POST" action="{{ route('admin.experiencias.rechazar', $exp) }}"
                          onsubmit="return confirm('¿Rechazar y eliminar esta experiencia?')">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-peligro">Rechazar</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection
