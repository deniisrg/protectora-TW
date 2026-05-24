<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificaciones';

    protected $fillable = ['id_usuario', 'tipo', 'mensaje', 'enlace', 'leida'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
