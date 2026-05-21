@extends('layouts.main')

@section('titulo', 'Configuración — NombrePaginaWeb')

@section('contenido')
<h1>Configuración de cuenta</h1>

{{-- Foto de perfil --}}
<div class="config-seccion">
    <div class="config-seccion-titulo">
        <h2>Foto de perfil</h2>
    </div>
    <div class="config-seccion-contenido">
        <div class="config-foto-actual">
            @if(Auth::user()->foto_perfil)
                <img src="{{ Storage::url(Auth::user()->foto_perfil) }}" alt="Foto de perfil" class="perfil-avatar">
            @else
                <div class="perfil-avatar perfil-avatar-placeholder">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            @endif
        </div>
        <form method="POST" action="{{ route('configuracion.foto') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="file" name="foto_perfil" accept="image/*" required class="input-moderno @error('foto_perfil') input-moderno-error @enderror">
                @error('foto_perfil')<span class="campo-error">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="btn btn-primary">Actualizar foto</button>
        </form>
    </div>
</div>

{{-- Cambiar nombre --}}
<div class="config-seccion">
    <div class="config-seccion-titulo">
        <h2>Cambiar nombre</h2>
    </div>
    <div class="config-seccion-contenido">
        <form method="POST" action="{{ route('configuracion.nombre') }}">
            @csrf
            <div class="form-group">
                <label class="perfil-label">Nuevo nombre</label>
                <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required maxlength="255" class="input-moderno @error('name') input-moderno-error @enderror">
                @error('name')<span class="campo-error">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
</div>

{{-- Cambiar email --}}
<div class="config-seccion">
    <div class="config-seccion-titulo">
        <h2>Cambiar correo electrónico</h2>
        <p class="config-seccion-desc">Tu correo actual: <strong>{{ Auth::user()->email }}</strong></p>
    </div>
    <div class="config-seccion-contenido">
        <form method="POST" action="{{ route('configuracion.email') }}">
            @csrf
            <div class="form-group">
                <label class="perfil-label">Nuevo correo</label>
                <input type="email" name="email" value="{{ old('email') }}" required maxlength="255" class="input-moderno @error('email') input-moderno-error @enderror">
                @error('email')<span class="campo-error">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
</div>

{{-- Cambiar contraseña --}}
<div class="config-seccion">
    <div class="config-seccion-titulo">
        <h2>Cambiar contraseña</h2>
    </div>
    <div class="config-seccion-contenido">
        <form method="POST" action="{{ route('configuracion.password') }}">
            @csrf
            <div class="form-group">
                <label class="perfil-label">Contraseña actual</label>
                <div class="input-con-boton">
                    <input type="password" name="password_actual" required class="input-moderno @error('password_actual') input-moderno-error @enderror">
                    <button type="button" class="btn-ver-password oculto" onclick="this.previousElementSibling.type=this.previousElementSibling.type==='password'?'text':'password';this.classList.toggle('oculto');this.classList.toggle('visible')"></button>
                </div>
                @error('password_actual')<span class="campo-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label class="perfil-label">Nueva contraseña</label>
                <div class="input-con-boton">
                    <input type="password" name="password" required minlength="8" class="input-moderno @error('password') input-moderno-error @enderror">
                    <button type="button" class="btn-ver-password oculto" onclick="this.previousElementSibling.type=this.previousElementSibling.type==='password'?'text':'password';this.classList.toggle('oculto');this.classList.toggle('visible')"></button>
                </div>
                @error('password')<span class="campo-error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label class="perfil-label">Confirmar nueva contraseña</label>
                <div class="input-con-boton">
                    <input type="password" name="password_confirmation" required class="input-moderno">
                    <button type="button" class="btn-ver-password oculto" onclick="this.previousElementSibling.type=this.previousElementSibling.type==='password'?'text':'password';this.classList.toggle('oculto');this.classList.toggle('visible')"></button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
</div>

{{-- Eliminar cuenta --}}
<div class="config-seccion config-seccion-peligro">
    <div class="config-seccion-titulo">
        <h2>Eliminar cuenta</h2>
        <p class="config-seccion-desc">Esta acción es permanente y no se puede deshacer. Se eliminarán tus datos y solicitudes.</p>
    </div>
    <div class="config-seccion-contenido">
        <form method="POST" action="{{ route('configuracion.eliminar') }}" onsubmit="return confirm('¿Seguro que quieres eliminar tu cuenta? Esta acción no se puede deshacer.')">
            @csrf
            @method('DELETE')
            <div class="form-group">
                <label class="perfil-label">Confirma tu contraseña para continuar</label>
                <input type="password" name="password" required class="input-moderno @error('password_eliminar') input-moderno-error @enderror">
                @error('password_eliminar')<span class="campo-error">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="btn btn-peligro">Eliminar mi cuenta</button>
        </form>
    </div>
</div>
@endsection
