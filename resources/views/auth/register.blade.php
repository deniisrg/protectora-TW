@extends('layouts.main')

@section('titulo', 'Registrarse — Pawtect')

@section('contenido')

@if($errors->any())
    <div class="alert alert-error">
        @foreach($errors->all() as $err)
            <p>{{ $err }}</p>
        @endforeach
    </div>
@endif

<div class="form-container">
    <h2 class="form-titulo">Crear cuenta</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <input type="text" name="name" placeholder="Nombre" value="{{ old('name') }}" required autofocus maxlength="255" class="input-moderno">
        </div>
        <div class="form-group">
            <input type="email" name="email" placeholder="Dirección de email" value="{{ old('email') }}" required maxlength="255" class="input-moderno">
        </div>
        <div class="form-group">
            <div class="input-con-boton">
                <input type="password" name="password" id="password-registro" placeholder="Contraseña" required autocomplete="new-password" class="input-moderno">
                <button type="button" class="btn-ver-password oculto" onclick="
                    var input = document.getElementById('password-registro');
                    input.type = input.type === 'password' ? 'text' : 'password';
                    this.classList.toggle('oculto');
                    this.classList.toggle('visible');
                "></button>
            </div>
        </div>
        <button type="submit" class="btn btn-form-principal">Registrarse</button>
        <p class="form-pie">¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
    </form>
</div>
@endsection
