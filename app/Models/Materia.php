<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','codigo','intensidad_horaria','profesor_id'];

    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }

    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'curso_materia');
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class);
    }
}
