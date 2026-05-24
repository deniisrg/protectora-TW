@extends('layouts.main')

@section('titulo', $animal->nombre . ' — Pawtect')

@section('contenido')
@php
function edad_texto_blade($meses) {
    if ($meses === null) return 'Desconocida';
    $anios = intdiv($meses, 12);
    $m     = $meses % 12;
    if ($anios === 0) return $m . ' ' . ($m === 1 ? 'mes' : 'meses');
    if ($m === 0)     return $anios . ' ' . ($anios === 1 ? 'año' : 'años');
    return $anios . ' ' . ($anios === 1 ? 'año' : 'años') . ' y ' . $m . ' ' . ($m === 1 ? 'mes' : 'meses');
}

$badges = ['disponible' => 'badge-disponible', 'en_proceso' => 'badge-en-proceso', 'adoptado' => 'badge-adoptado'];
$textos = ['disponible' => 'Disponible', 'en_proceso' => 'En proceso', 'adoptado' => 'Adoptado'];
@endphp

<div class="section-header">
    <h1>{{ $animal->nombre }}</h1>
    <span class="{{ $badges[$animal->estado] ?? '' }}">{{ $textos[$animal->estado] ?? $animal->estado }}</span>
</div>

<div class="animal-detalle">

    <div>
        @if($animal->fotos->isNotEmpty())
            @php $fotos = $animal->fotos; $total = $fotos->count(); @endphp
            <div class="carrusel-wrapper">
                @if($total > 1)
                    <button class="carrusel-btn prev" onclick="moverCarrusel(-1)">&#10094;</button>
                    <button class="carrusel-btn next" onclick="moverCarrusel(1)">&#10095;</button>
                    <div class="carrusel-contador"><span id="foto-actual">1</span> / {{ $total }}</div>
                @endif
                <div class="carrusel-contenedor" id="carrusel">
                    @foreach($fotos as $foto)
                        <img src="{{ asset('storage/animales/' . $foto->nombre_archivo) }}"
                             alt="Foto de {{ $animal->nombre }}">
                    @endforeach
                </div>
            </div>
            @if($total > 1)
            <script>
                const carrusel = document.getElementById('carrusel');
                const contador = document.getElementById('foto-actual');
                let indice = 0;
                const total = {{ $total }};

                // scrollTo con posición absoluta evita acumulación de error de scrollBy,
                // que podía saltar fotos si la posición no coincidía exactamente con el snap point
                function moverCarrusel(dir) {
                    indice = (indice + dir + total) % total;
                    carrusel.scrollTo({ left: carrusel.clientWidth * indice, behavior: 'smooth' });
                    contador.textContent = indice + 1;
                }
            </script>
            @endif
        @else
            <div class="sin-foto" style="height:260px;border-radius:6px">Sin foto disponible</div>
        @endif
    </div>

    <div class="animal-info">
        <dl>
            <dt>Especie</dt>  <dd>{{ $animal->especie }}</dd>
            <dt>Raza</dt>     <dd>{{ $animal->raza ?? 'Desconocida' }}</dd>
            <dt>Edad</dt>     <dd>{{ edad_texto_blade($animal->edad_meses) }}</dd>
            <dt>Sexo</dt>     <dd>{{ $animal->sexo === 'macho' ? 'Macho' : 'Hembra' }}</dd>
            <dt>Salud</dt>    <dd>{{ $animal->estado_salud ?? 'Sin datos' }}</dd>
            <dt>En la protectora desde</dt>
            <dd>{{ $animal->fecha_ingreso }}</dd>
        </dl>

        @if($animal->descripcion)
        <div class="animal-descripcion">
            <h2>Sobre {{ $animal->nombre }}</h2>
            <p>{!! nl2br(e($animal->descripcion)) !!}</p>
        </div>
        @endif

        <div style="margin-top:1.5rem">
            @if($animal->estado === 'disponible')
                @auth
                    <a href="{{ route('adopcion.create', $animal) }}" class="btn btn-naranja">Solicitar adopcion</a>
                @else
                    <p>
                        <a href="{{ route('login') }}">Inicia sesion</a>
                        para solicitar la adopcion de {{ $animal->nombre }}.
                    </p>
                @endauth
            @elseif($animal->estado === 'en_proceso')
                <p>Este animal tiene una solicitud de adopcion en tramite.</p>
            @else
                <p>Este animal ya ha sido adoptado. ¡Que alegria!</p>
            @endif
        </div>
    </div>

</div>

<p style="margin-top:1.5rem">
    <a href="{{ route('home') }}">&larr; Volver al listado</a>
</p>
@endsection
