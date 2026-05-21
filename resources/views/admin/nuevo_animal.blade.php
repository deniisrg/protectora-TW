@extends('layouts.main')

@php $modo = isset($animal) ? 'editar' : 'nuevo'; @endphp

@section('titulo', ($modo === 'nuevo' ? 'Nuevo animal' : 'Editar animal') . ' — NombrePaginaWeb')

@section('contenido')
<h1>{{ $modo === 'nuevo' ? 'Nuevo animal' : 'Editar animal' }}</h1>

@if($errors->any())
    <div class="alert alert-error">
        @foreach($errors->all() as $err)
            <p>{{ $err }}</p>
        @endforeach
    </div>
@endif

<form method="POST"
      action="{{ $modo === 'nuevo' ? route('admin.animales.store') : route('admin.animales.update', $animal) }}"
      enctype="multipart/form-data">
    @csrf
    @if($modo === 'editar') @method('PUT') @endif

    <div class="form-group">
        <label>Nombre</label>
        <input type="text" name="nombre" value="{{ old('nombre', $animal->nombre ?? '') }}" required maxlength="100">
    </div>

    <div class="form-group">
        <label>Especie</label>
        <select name="especie" required>
            <option value="">— Seleccionar —</option>
            @foreach($especies as $esp)
                <option value="{{ $esp }}" {{ old('especie', $animal->especie ?? '') === $esp ? 'selected' : '' }}>
                    {{ $esp }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Sexo</label>
        <select name="sexo" required>
            <option value="">— Seleccionar —</option>
            <option value="macho"  {{ old('sexo', $animal->sexo ?? '') === 'macho'  ? 'selected' : '' }}>Macho</option>
            <option value="hembra" {{ old('sexo', $animal->sexo ?? '') === 'hembra' ? 'selected' : '' }}>Hembra</option>
        </select>
    </div>

    <div class="form-group">
        <label>Raza</label>
        <input type="text" name="raza" value="{{ old('raza', $animal->raza ?? '') }}">
    </div>

    <div class="form-group">
        <label>Edad (meses)</label>
        <input type="number" name="edad_meses" min="0" value="{{ old('edad_meses', $animal->edad_meses ?? '') }}">
    </div>

    <div class="form-group">
        <label>Descripción</label>
        <textarea name="descripcion">{{ old('descripcion', $animal->descripcion ?? '') }}</textarea>
    </div>

    <div class="form-group">
        <label>Estado de salud</label>
        <textarea name="estado_salud">{{ old('estado_salud', $animal->estado_salud ?? '') }}</textarea>
    </div>

    <div class="form-group">
        <label>Estado</label>
        <select name="estado">
            <option value="disponible" {{ old('estado', $animal->estado ?? 'disponible') === 'disponible' ? 'selected' : '' }}>Disponible</option>
            <option value="en_proceso" {{ old('estado', $animal->estado ?? '') === 'en_proceso' ? 'selected' : '' }}>En proceso</option>
            <option value="adoptado"   {{ old('estado', $animal->estado ?? '') === 'adoptado'   ? 'selected' : '' }}>Adoptado</option>
        </select>
    </div>

    <div class="form-group">
        <label>Fecha de ingreso</label>
        <input type="date" name="fecha_ingreso"
               value="{{ old('fecha_ingreso', isset($animal) ? $animal->fecha_ingreso : date('Y-m-d')) }}" required>
    </div>

    <div class="form-group">
        <label>Añadir fotos</label>
        <input type="file" name="fotos[]" multiple accept="image/jpeg,image/png,image/webp">
        <small>Puedes seleccionar varias fotos a la vez.</small>
    </div>

    <button type="submit" class="btn btn-primary">
        {{ $modo === 'nuevo' ? 'Crear animal' : 'Guardar cambios' }}
    </button>
    <a href="{{ route('admin.animales.index') }}" class="btn btn-gris">Cancelar</a>
</form>

@if($modo === 'editar' && $animal->fotos->isNotEmpty())
<div class="form-group" style="margin-top:1.5rem">
    <label>Fotos actuales</label>
    <div style="display:flex;gap:1rem;flex-wrap:wrap;margin-top:0.5rem">
        @foreach($animal->fotos as $f)
        <div style="text-align:center">
            <img src="{{ asset('storage/animales/' . $f->nombre_archivo) }}"
                 style="width:80px;height:80px;object-fit:cover">
            <form method="POST" action="{{ route('admin.fotos.destroy', $f) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-peligro"
                        onclick="return confirm('¿Eliminar foto?')">X</button>
            </form>
        </div>
        @endforeach
    </div>
</div>
@endif
@endsection
