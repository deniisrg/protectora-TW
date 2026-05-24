@extends('layouts.main')

@section('titulo', 'Notificaciones — Pawtect')

@section('contenido')
<div class="section-header">
    <h1>Notificaciones</h1>
    @if($notificaciones->isNotEmpty())
        <form method="POST" action="{{ route('notificaciones.destroy.todas') }}"
              onsubmit="return confirm('¿Eliminar todas las notificaciones?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-peligro">Eliminar todas</button>
        </form>
    @endif
</div>

@if($notificaciones->isEmpty())
    <div class="sin-resultados"><p>No tienes notificaciones todavía.</p></div>
@else
    <div class="notif-portal">
        @foreach($notificaciones as $notif)
        <div class="notif-portal-item {{ $notif->leida ? 'notif-portal-leida' : 'notif-portal-nueva' }}">
            <div class="notif-portal-icono notif-icono-{{ $notif->tipo }}">
                @if(str_contains($notif->tipo, 'aprobada'))
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                @elseif(str_contains($notif->tipo, 'rechazada'))
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                @endif
            </div>
            <div class="notif-portal-contenido">
                <p class="notif-portal-mensaje">{{ $notif->mensaje }}</p>
                <span class="notif-portal-fecha">{{ $notif->created_at->diffForHumans() }}</span>
            </div>
            <div style="display:flex;gap:0.5rem;align-items:center;flex-shrink:0">
                @if($notif->enlace)
                    <a href="{{ $notif->enlace }}" class="btn btn-sm btn-gris">Ver</a>
                @endif
                <form method="POST" action="{{ route('notificaciones.destroy', $notif) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-notif-borrar" aria-label="Eliminar notificación">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection
