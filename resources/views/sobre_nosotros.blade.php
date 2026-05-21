@extends('layouts.main')

@section('titulo', 'Sobre nosotros — NombrePaginaWeb')

@section('contenido')
<h1>Sobre nosotros</h1>

<p>Esta aplicacion web ha sido desarrollada como proyecto de la asignatura Tecnologias Web.</p>

<dl class="info-equipo">
    <dt>Nombre</dt>
    <dd><!-- Tu nombre aqui --></dd>

    <dt>Correo</dt>
    <dd><a href="mailto:"><!-- correo@ejemplo.com --></a></dd>

    <dt>Universidad</dt>
    <dd><!-- Nombre de la universidad --></dd>

    <dt>Asignatura</dt>
    <dd>Tecnologias Web</dd>

    <dt>Curso</dt>
    <dd>2024-2025</dd>
</dl>

<div class="mapa-contacto">
    <h2>Nuestra ubicación</h2>
    <iframe
        src="https://www.google.com/maps?q=37.15683,-3.58670&z=15&output=embed"
        width="100%"
        height="400"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
    </iframe>
    <a href="{{ route('sobre_nosotros') }}" class="btn btn-gris">Centrar mapa</a>
</div>

<p class="sobre-pdf">
    <a href="/como_se_hizo.pdf" target="_blank" class="btn btn-gris">Ver informe tecnico (PDF)</a>
</p>
@endsection
