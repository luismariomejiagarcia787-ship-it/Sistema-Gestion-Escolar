<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','documento','telefono','direccion',
        'fecha_nacimiento','genero','curso_id','estado','foto'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class);
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    public function getFotoUrlAttribute(): string
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('assets/img/default-avatar.png');
    }

    public function getPromedioAttribute(): float
    {
        $avg = $this->calificaciones()->avg('nota');
        return round($avg ?? 0, 2);
    }

    public function getNombreCompletoAttribute(): string
    {
        return $this->user->name ?? '';
    }
}
