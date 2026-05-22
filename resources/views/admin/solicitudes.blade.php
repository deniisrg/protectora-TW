@extends('layouts.main')

@section('titulo', 'Solicitudes de adopción — NombrePaginaWeb')

@section('contenido')
<h1>Solicitudes de adopción</h1>

<div class="tabla-con-filtro">

    {{-- BOTÓN + PANEL --}}
    <button class="btn-abrir-filtros" id="btn-abrir-filtros">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="6" x2="20" y2="6"/><line x1="8" y1="12" x2="16" y2="12"/><line x1="11" y1="18" x2="13" y2="18"/></svg>
        @if(request()->hasAny(['usuario', 'animal', 'estado', 'orden']))
            <span class="filtros-activos-dot"></span>
        @endif
        <span class="btn-filtros-tooltip">Filtrar</span>
    </button>

    <div class="panel-filtros {{ request()->hasAny(['usuario', 'animal', 'estado', 'orden']) ? 'abierto' : '' }}" id="panel-filtros">
        <form method="GET" action="{{ route('admin.solicitudes.index') }}">
            <div class="panel-filtros-cabecera">
                <span class="panel-filtros-titulo">Filtros</span>
                @if(request()->hasAny(['usuario', 'animal', 'estado', 'orden']))
                    <a href="{{ route('admin.solicitudes.index') }}" class="panel-filtros-limpiar">Limpiar</a>
                @endif
            </div>
            <div class="filtro-grupo">
                <label class="filtro-label">Solicitante</label>
                <input type="text" name="usuario" value="{{ request('usuario') }}" placeholder="Nombre..." class="filtro-input">
            </div>
            <div class="filtro-grupo">
                <label class="filtro-label">Animal</label>
                <input type="text" name="animal" value="{{ request('animal') }}" placeholder="Nombre del animal..." class="filtro-input">
            </div>
            <div class="filtro-grupo">
                <label class="filtro-label">Estado</label>
                <div class="filtro-opciones">
                    @foreach(['pendiente' => 'Pendiente', 'aprobada' => 'Aprobada', 'rechazada' => 'Rechazada'] as $val => $label)
                    <label class="filtro-check">
                        <input type="radio" name="estado" value="{{ $val }}" {{ request('estado') === $val ? 'checked' : '' }}>
                        <span class="badge-{{ $val === 'pendiente' ? 'en-proceso' : ($val === 'aprobada' ? 'disponible' : 'adoptado') }}">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            <div class="filtro-grupo">
                <label class="filtro-label">Ordenar por</label>
                <select name="orden" class="filtro-input">
                    <option value="reciente" {{ request('orden', 'reciente') === 'reciente' ? 'selected' : '' }}>Más reciente primero</option>
                    <option value="antigua"  {{ request('orden') === 'antigua'  ? 'selected' : '' }}>Más antigua primero</option>
                    <option value="nombre"   {{ request('orden') === 'nombre'   ? 'selected' : '' }}>Nombre solicitante</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%">Aplicar</button>
        </form>
    </div>

    {{-- TABLA --}}
    @if($solicitudes->isEmpty())
        <div class="sin-resultados"><p>No hay solicitudes con estos filtros.</p></div>
    @else
        <table class="tabla-admin">
            <thead>
                <tr>
                    <th>Animal</th><th>Solicitante</th><th>Teléfono</th>
                    <th>Fecha</th><th>Estado</th><th>Acciones</th>
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
                    <td>{{ $s->fecha_solicitud }}</td>
                    <td><span class="{{ $badges[$s->estado] ?? '' }}">{{ $textos[$s->estado] ?? $s->estado }}</span></td>
                    <td class="acciones">
                        <a href="{{ route('admin.solicitudes.show', $s) }}" class="btn btn-sm btn-gris">Ver detalle</a>
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
                        @endif
                        <form method="POST" action="{{ route('admin.solicitudes.destroy', $s) }}"
                              onsubmit="return confirm('{{ $s->estado === 'pendiente' ? 'Esta solicitud está pendiente. Al eliminarla se marcará como rechazada automáticamente. ¿Continuar?' : '¿Eliminar esta solicitud definitivamente?' }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icono-peligro" title="Eliminar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

</div>
@endsection

@push('scripts')
<script>
(function() {
    var btn   = document.getElementById('btn-abrir-filtros');
    var panel = document.getElementById('panel-filtros');
    if (!btn || !panel) return;
    btn.addEventListener('click', function() {
        panel.classList.toggle('abierto');
    });
    document.addEventListener('click', function(e) {
        if (!panel.contains(e.target) && !btn.contains(e.target)) {
            panel.classList.remove('abierto');
        }
    });
})();
</script>
@endpush
