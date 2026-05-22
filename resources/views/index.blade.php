@extends('layouts.main')

@section('titulo', 'Animales en adopcion — NombrePaginaWeb')

@section('contenido')

@if($carrusel->count())
<div class="carrusel" id="carrusel">

    @foreach($carrusel as $i => $c)
    <div class="carrusel-slide {{ $i === 0 ? 'activa' : '' }}">
        <div class="carrusel-izq">
            <p class="carrusel-subtitulo">Encuéntrales un hogar</p>
            <h2 class="carrusel-titulo">{{ $c->nombre }}</h2>
            <p class="carrusel-meta">{{ $c->raza ?? $c->especie }} &middot; {{ $c->sexo === 'macho' ? 'Macho' : 'Hembra' }} &middot; {{ floor($c->edad_meses / 12) > 0 ? floor($c->edad_meses / 12).' año'.( floor($c->edad_meses / 12) > 1 ? 's' : '') : $c->edad_meses.' meses' }}</p>
            <p class="carrusel-desc">{{ Str::limit($c->descripcion, 120) }}</p>
            <div class="carrusel-botones">
                <a href="{{ route('animales.show', $c) }}" class="btn btn-primary">Conocer a {{ $c->nombre }}</a>
                <a href="{{ route('adoptar') }}" class="btn btn-gris">Ver todos los animales</a>
            </div>
        </div>
        <div class="carrusel-der">
            <img src="{{ asset('storage/animales/' . $c->primeraFoto->nombre_archivo) }}" alt="{{ $c->nombre }}">
            <span class="carrusel-nombre-foto">{{ $c->nombre }}</span>
        </div>
    </div>
    @endforeach

    <button class="carrusel-flecha carrusel-prev" id="carrusel-prev">&#10094;</button>
    <button class="carrusel-flecha carrusel-next" id="carrusel-next">&#10095;</button>

    <div class="carrusel-dots" id="carrusel-dots">
        @foreach($carrusel as $i => $c)
        <span class="carrusel-dot {{ $i === 0 ? 'activo' : '' }}" data-index="{{ $i }}"></span>
        @endforeach
    </div>
</div>
@endif


<div class="voluntarios-banner">
    <video class="voluntarios-video" autoplay muted loop playsinline>
        <source src="{{ route('video', 'perritos.mp4') }}" type="video/mp4">
    </video>
    <div class="voluntarios-contenido">
        <div class="voluntarios-texto">
            <h2>¿Quieres ser voluntario?</h2>
            <p>Detrás de cada animal que recupera la confianza y encuentra un hogar, hay un voluntario dedicando su tiempo y su cariño.</p>
            <p>No necesitas experiencia, solo ganas de ayudar.</p>
            <p>Conviértete en la razón de sus ladridos de alegría y en parte de su historia de superación.</p>
            <p>Aún no tenemos un portal de voluntariado con toda la información pertinente. Estamos trabajando en ello, pero mientras tanto contáctanos directamente y te haremos saber todos los detalles acerca de la experiencia.</p>
            <a href="{{ route('contacto') }}" class="btn-voluntario">¡Me interesa!</a>
        </div>
    </div>
</div>

<div class="donaciones-seccion">
<h2 class="donaciones-titulo">Donaciones</h2>

<div class="donaciones-grid">

    {{-- Tarjeta PayPal --}}
    <div class="donacion-card">
        <p class="donacion-card-titulo">Tu ayuda es su futuro: dona de forma fácil y segura</p>
        <div class="donacion-metodos-logos">
            <span class="metodo-logo">VISA</span>
            <span class="metodo-logo">Mastercard</span>
            <span class="metodo-logo">Maestro</span>
            <span class="metodo-logo">AMEX</span>
        </div>
        <a href="#" class="btn-paypal">
            <span style="font-size:1.2rem; font-weight:900; font-style:italic;">P</span>
            Donar con PayPal
        </a>
        <p class="donacion-nota">Tu donación es 100% segura y se gestiona a través de PayPal</p>
    </div>

    {{-- Tarjeta alternativas --}}
    <div class="donacion-card">
        <p class="donacion-card-titulo">O tal vez prefieras...</p>
        <a href="#" class="btn-bizum">
            <span>📱</span> Donar con Bizum
        </a>
        <a href="#" class="btn-transferencia">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="32" height="32" xmlns="http://www.w3.org/2000/svg"><line x1="3" y1="22" x2="21" y2="22"/><rect x="2" y="11" width="20" height="11"/><polyline points="2 11 12 2 22 11"/><line x1="9" y1="22" x2="9" y2="15"/><line x1="15" y1="22" x2="15" y2="15"/></svg>
            <div>
                <span class="transferencia-label">TRANSFERENCIA</span>
                <span class="transferencia-sublabel">BANCARIA</span>
            </div>
        </a>
    </div>

    {{-- Tarjeta Teaming --}}
    <div class="donacion-card donacion-card-teaming">
        <div class="teaming-icono">🐾</div>
        <p class="teaming-titulo">NombrePaginaWeb</p>
        <a href="#" class="btn-teaming">Únete por 1€ al mes</a>
        <p class="donacion-nota">¿Sabías que por solo 1€ al mes puedes hacer mucho por este refugio?</p>
    </div>

</div>
</div>
@endsection
