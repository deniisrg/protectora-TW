<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudAdopcion extends Model
{
    protected $table = 'solicitudes_adopcion';
    protected $fillable = [
        'id_animal', 'id_usuario', 'estado',
        // datos personales
        'apellidos', 'fecha_nacimiento', 'telefono', 'direccion', 'ciudad', 'provincia', 'codigo_postal',
        // mensaje y cuestionario
        'mensaje', 'familia_miembros', 'donde_vivira', 'razones_adoptar', 'mascotas_anteriores', 'mascotas_actuales', 'opinion_esterilizacion', 'gasto_veterinario', 'acepta_visitas',
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'id_animal');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
