<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    protected $table = 'animales';

    protected $fillable = [
        'nombre', 'especie', 'raza', 'edad_meses', 'sexo',
        'descripcion', 'estado_salud', 'estado', 'fecha_ingreso',
    ];

    public function fotos()
    {
        return $this->hasMany(FotoAnimal::class, 'id_animal');
    }

    public function solicitudes()
    {
        return $this->hasMany(SolicitudAdopcion::class, 'id_animal');
    }

    public function primeraFoto()
    {
        return $this->hasOne(FotoAnimal::class, 'id_animal')->oldestOfMany();
    }
}
