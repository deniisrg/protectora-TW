@extends('layouts.main')

@section('titulo', 'Mensajes de contacto — NombrePaginaWeb')

@section('contenido')
<div class="section-header">
    <h1>Mensajes de contacto</h1>
</div>

<div class="filtros">
    <a href="{{ route('admin.mensajes.index') }}" class="btn btn-sm {{ $filtro === null ? 'btn-primary' : 'btn-gris' }}">Todos</a>
    <a href="{{ route('admin.mensajes.index', ['filtro' => 'no_leidos']) }}" class="btn btn-sm {{ $filtro === 'no_leidos' ? 'btn-primary' : 'btn-gris' }}">No leídos</a>
    <a href="{{ route('admin.mensajes.index', ['filtro' => 'leidos']) }}" class="btn btn-sm {{ $filtro === 'leidos' ? 'btn-primary' : 'btn-gris' }}">Leídos</a>
</div>

@if($mensajes->isEmpty())
    <div class="sin-resultados"><p>No hay mensajes{{ $filtro === 'no_leidos' ? ' sin leer' : ($filtro === 'leidos' ? ' leídos' : '') }}.</p></div>
@else
    <table class="tabla-admin">
        <thead>
            <tr>
                <th>Nombre</th><th>Ciudad</th><th>Teléfono</th><th>Email</th><th>Mensaje</th><th>Fecha</th><th>Estado</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($mensajes as $m)
            <tr class="{{ $m->leido ? '' : 'mensaje-nuevo' }}">
                <td>{{ $m->nombre }}</td>
                <td>{{ $m->ciudad }}</td>
                <td>{{ $m->telefono ?? '—' }}</td>
                <td><a href="mailto:{{ $m->email }}">{{ $m->email }}</a></td>
                <td>{{ \Illuminate\Support\Str::limit($m->mensaje, 80) }}</td>
                <td>{{ $m->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <span class="{{ $m->leido ? 'badge-disponible' : 'badge-en-proceso' }}">
                        {{ $m->leido ? 'Leído' : 'Nuevo' }}
                    </span>
                </td>
                <td class="acciones">
                    @if(!$m->leido)
                        <form method="POST" action="{{ route('admin.mensajes.leido', $m) }}">
                            @csrf
                            <input type="hidden" name="filtro" value="{{ $filtro }}">
                            <button type="submit" class="btn btn-sm btn-primary">Marcar leído</button>
                        </form>
                    @endif
                    <form method="POST" action="{{ route('admin.mensajes.destroy', $m) }}" onsubmit="return confirm('¿Eliminar este mensaje?')">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="filtro" value="{{ $filtro }}">
                        <button type="submit" class="btn btn-sm btn-peligro">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
@endsection
