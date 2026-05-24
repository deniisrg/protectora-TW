@extends('layouts.main')

@section('titulo', 'Compartir experiencia — Pawtect')

@section('contenido')
<h1>Compartir mi experiencia</h1>

@if($errors->any())
    <div class="alert alert-error">
        @foreach($errors->all() as $err)
            <p>{{ $err }}</p>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('experiencias.store') }}" enctype="multipart/form-data" class="form-adopcion">
    @csrf

    <div class="form-seccion">
        <h2 class="form-seccion-titulo">Tu historia</h2>

        <div class="form-group">
            <label for="titulo">Título <span class="form-requerido">*</span></label>
            <input type="text" id="titulo" name="titulo" value="{{ old('titulo') }}" required maxlength="150">
        </div>

        <div class="form-group">
            <label for="texto">Cuéntanos tu experiencia <span class="form-requerido">*</span></label>
            <textarea id="texto" name="texto" required maxlength="3000" rows="8">{{ old('texto') }}</textarea>
            <span class="form-ayuda">Máximo 3000 caracteres</span>
        </div>
    </div>

    <div class="form-seccion">
        <h2 class="form-seccion-titulo">Fotos <span class="form-requerido">*</span></h2>
        <div class="form-group">
            <label for="fotos">Añade entre 1 y 5 fotos</label>
            <input type="file" id="fotos" name="fotos[]" accept="image/*" multiple required>
            <span class="form-ayuda">Formatos admitidos: JPG, PNG, WEBP. Máximo 4MB por foto.</span>
        </div>
        <div id="preview-fotos" class="preview-fotos"></div>
    </div>

    <div class="form-seccion">
        <p style="color:var(--texto-suave); font-size:0.9rem;">Tu publicación será revisada por el equipo antes de aparecer en el feed. Recibirás una notificación cuando sea aprobada.</p>
    </div>

    <div class="form-acciones">
        <a href="{{ route('experiencias.index') }}" class="btn btn-gris">Cancelar</a>
        <button type="submit" class="btn btn-primary">Enviar experiencia</button>
    </div>
</form>

@push('scripts')
<script>
document.getElementById('fotos').addEventListener('change', function() {
    var preview = document.getElementById('preview-fotos');
    preview.innerHTML = '';
    Array.from(this.files).slice(0, 5).forEach(function(file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'preview-foto-img';
            preview.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endpush
@endsection
