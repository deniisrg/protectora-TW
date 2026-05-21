<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoAnimal extends Model
{
    protected $table = 'fotos_animales';
    protected $fillable = ['id_animal', 'nombre_archivo'];

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'id_animal');
    }
}
