<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    use HasFactory;
    protected $table = 'profesores';
    protected $fillable = [
        'user_id','documento','telefono','especialidad',
        'fecha_ingreso','estado','foto'
    ];

    protected $casts = [
        'fecha_ingreso' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }

    public function materias()
    {
        return $this->hasMany(Materia::class);
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class);
    }

    public function getFotoUrlAttribute(): string
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('assets/img/default-avatar.png');
    }

    public function getNombreCompletoAttribute(): string
    {
        return $this->user->name ?? '';
    }
}
