<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory;

    protected $fillable = ['estudiante_id','curso_id','fecha_matricula','anio_lectivo','estado'];

    protected $casts = [
        'fecha_matricula' => 'date',
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function getEstadoBadgeAttribute(): string
    {
        return match($this->estado) {
            'activa'    => '<span class="badge bg-success">Activa</span>',
            'retirada'  => '<span class="badge bg-danger">Retirada</span>',
            'finalizada'=> '<span class="badge bg-secondary">Finalizada</span>',
            default     => '<span class="badge bg-secondary">'.$this->estado.'</span>',
        };
    }
}
