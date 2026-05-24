@extends('layouts.main')

@section('titulo', 'Experiencias — Pawtect')

@section('contenido')

<div class="experiencias-cabecera">
    <h1>Experiencias de nuestra comunidad</h1>
    @auth
        <a href="{{ route('experiencias.create') }}" class="btn btn-primary">Compartir mi experiencia</a>
    @else
        <a href="{{ route('login') }}" class="btn btn-gris">Inicia sesión para compartir</a>
    @endauth
</div>

@if($experiencias->isEmpty())
    <div class="sin-resultados">
        <p>Todavía no hay experiencias publicadas. ¡Sé el primero en compartir la tuya!</p>
    </div>
@else
    <div class="experiencias-feed">
        @foreach($experiencias as $exp)
        <div class="experiencia-card">
            {{-- FOTOS --}}
            <div class="experiencia-fotos">
                @if($exp->fotos->count() === 1)
                    <img src="{{ asset('storage/experiencias/' . $exp->fotos->first()->nombre_archivo) }}"
                         alt="{{ $exp->titulo }}" class="experiencia-foto-unica">
                @else
                    <div class="experiencia-fotos-grid">
                        @foreach($exp->fotos->take(4) as $i => $foto)
                        <div class="experiencia-foto-item {{ $exp->fotos->count() > 4 && $i === 3 ? 'experiencia-foto-mas' : '' }}"
                             data-resto="{{ $exp->fotos->count() - 4 }}">
                            <img src="{{ asset('storage/experiencias/' . $foto->nombre_archivo) }}" alt="">
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- TEXTO --}}
            <div class="experiencia-contenido">
                <div class="experiencia-autor">
                    @if($exp->usuario->foto_perfil)
                        <img src="{{ Storage::url($exp->usuario->foto_perfil) }}" alt="{{ $exp->usuario->name }}" class="experiencia-avatar experiencia-avatar-foto">
                    @else
                        <div class="experiencia-avatar">{{ strtoupper(substr($exp->usuario->name, 0, 1)) }}</div>
                    @endif
                    <div>
                        <span class="experiencia-nombre">{{ $exp->usuario->name }}</span>
                        <span class="experiencia-fecha">{{ $exp->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <h2 class="experiencia-titulo">{{ $exp->titulo }}</h2>
                <p class="experiencia-texto">{{ $exp->texto }}</p>
                <button class="btn-leer-mas" onclick="toggleTexto(this)">Leer más</button>
            </div>
        </div>
        @endforeach
    </div>
@endif

@push('scripts')
<script>
function toggleTexto(btn) {
    var texto = btn.previousElementSibling;
    var expandido = texto.classList.toggle('expandido');
    btn.textContent = expandido ? 'Leer menos' : 'Leer más';
}
</script>
@endpush
@endsection
