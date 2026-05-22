<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AdopcionController;
use App\Http\Controllers\MisSolicitudesController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\Admin\MensajeController as AdminMensajeController;
use App\Http\Controllers\Admin\AnimalController as AdminAnimalController;
use App\Http\Controllers\Admin\SolicitudController as AdminSolicitudController;

// Servir vídeo con soporte de range requests (necesario para HTML5 video)
Route::get('/video/{nombre}', function ($nombre) {
    $path = public_path('videos/' . $nombre);
    abort_if(!file_exists($path), 404);
    return response()->file($path, ['Content-Type' => 'video/mp4']);
})->where('nombre', '[a-zA-Z0-9_\-]+\.mp4')->name('video');

// Rutas públicas
Route::get('/', [AnimalController::class, 'index'])->name('home');
Route::get('/adoptar', [AnimalController::class, 'adoptar'])->name('adoptar');
Route::get('/animales/{animal}', [AnimalController::class, 'show'])->name('animales.show');
Route::get('/contacto', [ContactoController::class, 'create'])->name('contacto');
Route::post('/contacto', [ContactoController::class, 'store'])->name('contacto.store');
Route::get('/sobre-nosotros', fn() => view('sobre_nosotros'))->name('sobre_nosotros');

// Área de usuario (requiere login)
Route::middleware('auth')->group(function () {
    Route::get('/adopcion/{animal}', [AdopcionController::class, 'create'])->name('adopcion.create');
    Route::post('/adopcion/{animal}', [AdopcionController::class, 'store'])->name('adopcion.store');
    Route::get('/mis-solicitudes', [MisSolicitudesController::class, 'index'])->name('mis_solicitudes');
    Route::get('/perfil', [PerfilController::class, 'show'])->name('perfil');
    Route::get('/configuracion', [PerfilController::class, 'configuracion'])->name('configuracion');
    Route::post('/configuracion/foto', [PerfilController::class, 'actualizarFoto'])->name('configuracion.foto');
    Route::post('/configuracion/nombre', [PerfilController::class, 'actualizarNombre'])->name('configuracion.nombre');
    Route::post('/configuracion/email', [PerfilController::class, 'actualizarEmail'])->name('configuracion.email');
    Route::post('/configuracion/password', [PerfilController::class, 'actualizarPassword'])->name('configuracion.password');
    Route::delete('/configuracion/eliminar', [PerfilController::class, 'eliminarCuenta'])->name('configuracion.eliminar');
});

// Panel de administración (requiere login + admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/animales', [AdminAnimalController::class, 'index'])->name('animales.index');
    Route::get('/animales/nuevo', [AdminAnimalController::class, 'create'])->name('animales.create');
    Route::post('/animales', [AdminAnimalController::class, 'store'])->name('animales.store');
    Route::get('/animales/{animal}/editar', [AdminAnimalController::class, 'edit'])->name('animales.edit');
    Route::put('/animales/{animal}', [AdminAnimalController::class, 'update'])->name('animales.update');
    Route::delete('/animales/{animal}', [AdminAnimalController::class, 'destroy'])->name('animales.destroy');
    Route::delete('/fotos/{foto}', [AdminAnimalController::class, 'destroyFoto'])->name('fotos.destroy');

    Route::get('/solicitudes', [AdminSolicitudController::class, 'index'])->name('solicitudes.index');
    Route::get('/solicitudes/{solicitud}', [AdminSolicitudController::class, 'show'])->name('solicitudes.show');
    Route::post('/solicitudes/{solicitud}/aprobar', [AdminSolicitudController::class, 'aprobar'])->name('solicitudes.aprobar');
    Route::post('/solicitudes/{solicitud}/rechazar', [AdminSolicitudController::class, 'rechazar'])->name('solicitudes.rechazar');
    Route::delete('/solicitudes/{solicitud}', [AdminSolicitudController::class, 'destroy'])->name('solicitudes.destroy');

    Route::get('/mensajes', [AdminMensajeController::class, 'index'])->name('mensajes.index');
    Route::post('/mensajes/{mensaje}/leido', [AdminMensajeController::class, 'marcarLeido'])->name('mensajes.leido');
    Route::delete('/mensajes/{mensaje}', [AdminMensajeController::class, 'destroy'])->name('mensajes.destroy');
});

require __DIR__.'/auth.php';
