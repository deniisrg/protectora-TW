<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoExperiencia extends Model
{
    protected $table = 'fotos_experiencia';
    protected $fillable = ['id_experiencia', 'nombre_archivo'];

    public function experiencia()
    {
        return $this->belongsTo(Experiencia::class, 'id_experiencia');
    }
}
