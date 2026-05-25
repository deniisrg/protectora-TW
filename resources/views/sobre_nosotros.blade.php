@extends('layouts.main')

@section('titulo', 'Sobre nosotros — Pawtect')

@section('contenido')
<h1>Sobre nosotros</h1>

<div class="sobre-tarjeta">
    <p>Esta aplicacion web ha sido desarrollada como proyecto de la asignatura Tecnologias Web.</p>

    <dl class="info-equipo">
        <dt>Desarrolladores</dt>
        <dd>Jairo Robles Balderas, Hugo Bautista Arenas, Denis Reverón Gordillo</dd>

        <dt>Universidad</dt>
        <dd>Universidad de Granada</dd>

        <dt>Asignatura</dt>
        <dd>Tecnologias Web</dd>

        <dt>Curso</dt>
        <dd>2025-2026</dd>
    </dl>
</div>

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

<div class="sobre-historia-wrapper">
    <div class="sobre-tarjeta sobre-historia">
        <h2>Nuestra historia</h2>
        <p>Esta protectora nació en 2018 de la mano de un pequeño grupo de voluntarios de Granada que no podían quedarse de brazos cruzados ante el abandono animal en la ciudad. Lo que empezó como una red de acogidas temporales entre amigos fue creciendo poco a poco hasta convertirse en un refugio con instalaciones propias.</p>
        <p>Hoy seguimos siendo un equipo reducido, pero con muchas ganas. Creemos que cada animal merece una segunda oportunidad, y que encontrar un buen hogar es solo el principio de una historia mejor.</p>
    </div>
    <img src="https://thumbs.dreamstime.com/b/un-grupo-de-amigos-con-sus-perros-mostrándoles-afecto-perro-concepto-y-mascota-242901226.jpg"
         alt="Voluntarios con sus perros" class="sobre-historia-img">
</div>

<p class="sobre-pdf">
    <a href="/como_se_hizo.pdf" target="_blank" class="btn btn-gris">Ver informe tecnico (PDF)</a>
</p>
@endsection
