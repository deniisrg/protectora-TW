@extends('layouts.main')

@section('titulo', 'Solicitar adopcion — NombrePaginaWeb')

@section('contenido')
<h1>Solicitar adopcion de {{ $animal->nombre }}</h1>

@if($ya_solicitado)
    <div class="alert alert-exito">Ya tienes una solicitud pendiente para este animal.</div>
@else
    @if($errors->any())
        <div class="alert alert-error">
            @foreach($errors->all() as $err)
                <p>{{ $err }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('adopcion.store', $animal) }}">
        @csrf
        <div class="form-group">
            <label>Teléfono de contacto</label>
            <input type="text" name="telefono" value="{{ old('telefono') }}" required maxlength="20">
        </div>
        <div class="form-group">
            <label>Mensaje (opcional)</label>
            <textarea name="mensaje" maxlength="1000">{{ old('mensaje') }}</textarea>
        </div>
        <button type="submit" class="btn btn-naranja">Enviar solicitud</button>
        <a href="{{ route('animales.show', $animal) }}" class="btn btn-gris">Cancelar</a>
    </form>
@endif
@endsection
