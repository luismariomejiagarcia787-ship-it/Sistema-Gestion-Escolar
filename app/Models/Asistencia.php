<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = ['estudiante_id','curso_id','fecha','estado'];

    protected $casts = ['fecha' => 'date'];

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
            'presente' => '<span class="badge status-presente">Presente</span>',
            'ausente'  => '<span class="badge status-ausente">Ausente</span>',
            'excusado' => '<span class="badge status-excusado">Excusado</span>',
            'tardanza' => '<span class="badge status-tardanza">Tardanza</span>',
            default    => '<span class="badge bg-secondary">'.$this->estado.'</span>',
        };
    }
}
