<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','codigo','jornada','anio_lectivo','profesor_id'];

    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class);
    }

    public function materias()
    {
        return $this->belongsToMany(Materia::class, 'curso_materia');
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    public function getJornadaLabelAttribute(): string
    {
        return match($this->jornada) {
            'manana'   => 'Mañana',
            'tarde'    => 'Tarde',
            'noche'    => 'Noche',
            'completa' => 'Jornada Completa',
            default    => $this->jornada,
        };
    }
}
