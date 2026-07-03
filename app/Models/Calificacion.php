<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    use HasFactory;
protected $table = 'calificaciones';
    protected $fillable = ['estudiante_id','materia_id','profesor_id','nota','periodo','observacion'];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }

    public function getNotaColorAttribute(): string
    {
        if ($this->nota >= 4.0) return 'nota-alta';
        if ($this->nota >= 3.0) return 'nota-media';
        return 'nota-baja';
    }
}
