@extends('layouts.main')

@section('titulo', 'Mi perfil — NombrePaginaWeb')

@section('contenido')
<div class="perfil-header">
    <div class="perfil-avatar-wrap">
        @if(Auth::user()->foto_perfil)
            <img src="{{ Storage::url(Auth::user()->foto_perfil) }}" alt="Foto de perfil" class="perfil-avatar">
        @else
            <div class="perfil-avatar perfil-avatar-placeholder">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        @endif
    </div>
    <div class="perfil-header-info">
        <h1>{{ Auth::user()->name }}</h1>
        <span class="{{ Auth::user()->es_admin ? 'badge-admin' : 'badge-normal' }}">
            {{ Auth::user()->es_admin ? 'Administrador' : 'Usuario' }}
        </span>
        <p class="perfil-miembro">Miembro desde {{ Auth::user()->created_at->format('d/m/Y') }}</p>
    </div>
    <a href="{{ route('configuracion') }}" class="btn btn-gris">&#9881; Configuración de cuenta</a>
</div>

<div class="perfil-datos-grid">
    <div class="perfil-dato-card">
        <div class="perfil-dato-label">Nombre</div>
        <div class="perfil-dato-valor">{{ Auth::user()->name }}</div>
    </div>
    <div class="perfil-dato-card">
        <div class="perfil-dato-label">Correo electrónico</div>
        <div class="perfil-dato-valor">{{ Auth::user()->email }}</div>
    </div>
</div>

<div class="perfil-solicitudes">
    <h2>Mis solicitudes de adopción</h2>
    @if($solicitudes->isEmpty())
        <div class="sin-resultados">
            <p>Todavía no has enviado ninguna solicitud.</p>
            <a href="{{ route('home') }}" class="btn btn-naranja">Ver animales</a>
        </div>
    @else
        <table class="tabla-admin">
            <thead>
                <tr><th>Animal</th><th>Fecha</th><th>Estado</th></tr>
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
</div>
@endsection
