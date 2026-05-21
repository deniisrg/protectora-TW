@extends('layouts.main')

@section('titulo', 'Iniciar sesión — NombrePaginaWeb')

@section('contenido')

@if(session('status'))
    <div class="alert alert-exito">{{ session('status') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-error">
        @foreach($errors->all() as $err)
            <p>{{ $err }}</p>
        @endforeach
    </div>
@endif

<div class="form-container">
    <h2 class="form-titulo">Iniciar sesión</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <input type="email" name="email" placeholder="Dirección de email" value="{{ old('email') }}" required autofocus class="input-moderno">
        </div>
        <div class="form-group">
            <div class="input-con-boton">
                <input type="password" name="password" id="password-login" placeholder="Contraseña" required class="input-moderno">
                <button type="button" class="btn-ver-password oculto" onclick="
                    var input = document.getElementById('password-login');
                    input.type = input.type === 'password' ? 'text' : 'password';
                    this.classList.toggle('oculto');
                    this.classList.toggle('visible');
                "></button>
            </div>
        </div>
        <button type="submit" class="btn btn-form-principal">Iniciar sesión</button>
        <p class="form-pie">¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate</a></p>
    </form>
</div>
@endsection
