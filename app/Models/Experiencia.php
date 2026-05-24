<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experiencia extends Model
{
    protected $table = 'experiencias';
    protected $fillable = ['id_usuario', 'titulo', 'texto', 'estado'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function fotos()
    {
        return $this->hasMany(FotoExperiencia::class, 'id_experiencia');
    }

    public function primeraFoto()
    {
        return $this->hasOne(FotoExperiencia::class, 'id_experiencia')->oldestOfMany();
    }
}
