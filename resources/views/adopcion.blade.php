@extends('layouts.main')

@section('titulo', 'Solicitar adopción — NombrePaginaWeb')

@section('contenido')
<h1>Solicitar adopción de {{ $animal->nombre }}</h1>

@if($ya_solicitado)
    <div class="alert alert-exito">Ya tienes una solicitud pendiente para este animal.</div>
@else
    @if($errors->any())
        <div class="alert alert-error">
            @foreach($errors->all() as $err)
                <p>{{ $err }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('adopcion.store', $animal) }}" class="form-adopcion">
        @csrf

        {{-- DATOS PERSONALES --}}
        <div class="form-seccion">
            <h2 class="form-seccion-titulo">Datos personales</h2>

            <div class="form-fila">
                <div class="form-group">
                    <label>Nombre <span class="form-requerido">*</span></label>
                    <input type="text" value="{{ Auth::user()->name }}" disabled class="input-disabled">
                </div>
                <div class="form-group">
                    <label for="apellidos">Apellidos <span class="form-requerido">*</span></label>
                    <input type="text" id="apellidos" name="apellidos" value="{{ old('apellidos') }}" required maxlength="150">
                </div>
            </div>

            <div class="form-fila">
                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de nacimiento <span class="form-requerido">*</span></label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required>
                    <span class="form-ayuda">Debes ser mayor de 18 años</span>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono de contacto <span class="form-requerido">*</span></label>
                    <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}" required maxlength="20">
                </div>
            </div>

            <div class="form-group">
                <label for="direccion">Dirección <span class="form-requerido">*</span></label>
                <input type="text" id="direccion" name="direccion" value="{{ old('direccion') }}" required maxlength="255" placeholder="Calle, número, piso...">
            </div>

            <div class="form-fila form-fila-3">
                <div class="form-group">
                    <label for="ciudad">Ciudad <span class="form-requerido">*</span></label>
                    <input type="text" id="ciudad" name="ciudad" value="{{ old('ciudad') }}" required maxlength="100">
                </div>
                <div class="form-group">
                    <label for="provincia">Provincia <span class="form-requerido">*</span></label>
                    <input type="text" id="provincia" name="provincia" value="{{ old('provincia') }}" required maxlength="100">
                </div>
                <div class="form-group">
                    <label for="codigo_postal">Código postal <span class="form-requerido">*</span></label>
                    <input type="text" id="codigo_postal" name="codigo_postal" value="{{ old('codigo_postal') }}" required maxlength="10">
                </div>
            </div>
        </div>

        {{-- CUESTIONARIO --}}
        <div class="form-seccion">
            <h2 class="form-seccion-titulo">Cuestionario de adopción</h2>

            <div class="form-group">
                <label for="familia_miembros">¿Con quién convives? <span class="form-requerido">*</span></label>
                <textarea id="familia_miembros" name="familia_miembros" required maxlength="500" placeholder="Describe los miembros de tu hogar (adultos, niños, edades...)">{{ old('familia_miembros') }}</textarea>
            </div>

            <div class="form-group">
                <label for="donde_vivira">¿Dónde vivirá el animal? <span class="form-requerido">*</span></label>
                <textarea id="donde_vivira" name="donde_vivira" required maxlength="500" placeholder="Tipo de vivienda, espacio disponible, si tiene jardín o terraza...">{{ old('donde_vivira') }}</textarea>
            </div>

            <div class="form-group">
                <label for="razones_adoptar">¿Por qué quieres adoptar a {{ $animal->nombre }}? <span class="form-requerido">*</span></label>
                <textarea id="razones_adoptar" name="razones_adoptar" required maxlength="1000" placeholder="Cuéntanos tus motivos...">{{ old('razones_adoptar') }}</textarea>
            </div>

            <div class="form-fila">
                <div class="form-group">
                    <label for="mascotas_anteriores">¿Has tenido animales antes?</label>
                    <textarea id="mascotas_anteriores" name="mascotas_anteriores" maxlength="500" placeholder="Qué animales, durante cuánto tiempo, qué pasó con ellos...">{{ old('mascotas_anteriores') }}</textarea>
                </div>
                <div class="form-group">
                    <label for="mascotas_actuales">¿Tienes animales actualmente?</label>
                    <textarea id="mascotas_actuales" name="mascotas_actuales" maxlength="500" placeholder="Qué animales tienes ahora en casa...">{{ old('mascotas_actuales') }}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="opinion_esterilizacion">¿Cuál es tu opinión sobre la esterilización? <span class="form-requerido">*</span></label>
                <textarea id="opinion_esterilizacion" name="opinion_esterilizacion" required maxlength="500">{{ old('opinion_esterilizacion') }}</textarea>
            </div>

            <div class="form-group">
                <label for="gasto_veterinario">¿Estás dispuesto/a a asumir gastos veterinarios? <span class="form-requerido">*</span></label>
                <textarea id="gasto_veterinario" name="gasto_veterinario" required maxlength="500" placeholder="Vacunas, revisiones, posibles enfermedades...">{{ old('gasto_veterinario') }}</textarea>
            </div>

            <div class="form-group">
                <label>¿Aceptas una visita de seguimiento post-adopción? <span class="form-requerido">*</span></label>
                <div class="form-radio-grupo">
                    <label class="form-radio-label">
                        <input type="radio" name="acepta_visitas" value="1" {{ old('acepta_visitas') == '1' ? 'checked' : '' }} required>
                        Sí, acepto
                    </label>
                    <label class="form-radio-label">
                        <input type="radio" name="acepta_visitas" value="0" {{ old('acepta_visitas') === '0' ? 'checked' : '' }}>
                        No acepto
                    </label>
                </div>
            </div>
        </div>

        {{-- MENSAJE ADICIONAL --}}
        <div class="form-seccion">
            <h2 class="form-seccion-titulo">Información adicional</h2>
            <div class="form-group">
                <label for="mensaje">¿Quieres añadir algo más? (opcional)</label>
                <textarea id="mensaje" name="mensaje" maxlength="1000" placeholder="Cualquier cosa que creas relevante...">{{ old('mensaje') }}</textarea>
            </div>
        </div>

        <div class="form-acciones">
            <a href="{{ route('animales.show', $animal) }}" class="btn btn-gris">Cancelar</a>
            <button type="submit" class="btn btn-primary">Enviar solicitud</button>
        </div>

    </form>
@endif
@endsection
