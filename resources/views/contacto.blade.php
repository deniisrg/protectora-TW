@extends('layouts.main')

@section('titulo', 'Contacto — NombrePaginaWeb')

@section('contenido')
<h1>Contacto</h1>

<div class="form-container">
    <p class="form-descripcion">¿Tienes alguna pregunta o necesitas ayuda? Escríbenos y te responderemos lo antes posible.</p>

    <form method="POST" action="{{ route('contacto.store') }}">
        @csrf
        <div class="form-group">
            <input type="text" name="nombre" placeholder="Nombre *" value="{{ old('nombre') }}" required maxlength="100" class="input-moderno @error('nombre') input-moderno-error @enderror">
            @error('nombre')<span class="campo-error">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <input type="text" name="ciudad" placeholder="Ciudad *" value="{{ old('ciudad') }}" required maxlength="100" class="input-moderno @error('ciudad') input-moderno-error @enderror">
            @error('ciudad')<span class="campo-error">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <input type="tel" name="telefono" placeholder="Teléfono (opcional)" value="{{ old('telefono') }}" maxlength="20" class="input-moderno">
        </div>
        <div class="form-group">
            <input type="email" name="email" placeholder="Correo electrónico *" value="{{ old('email') }}" required maxlength="255" class="input-moderno @error('email') input-moderno-error @enderror">
            @error('email')<span class="campo-error">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <textarea name="mensaje" placeholder="Mensaje *" required maxlength="2000" class="input-moderno textarea-moderno @error('mensaje') input-moderno-error @enderror">{{ old('mensaje') }}</textarea>
            @error('mensaje')<span class="campo-error">{{ $message }}</span>@enderror
        </div>
        <button type="submit" class="btn btn-form-principal">Enviar mensaje</button>
    </form>
</div>
@endsection
