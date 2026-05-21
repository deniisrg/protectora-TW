<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudAdopcion extends Model
{
    protected $table = 'solicitudes_adopcion';
    protected $fillable = ['id_animal', 'id_usuario', 'telefono', 'mensaje', 'estado'];

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'id_animal');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
