<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Profesor;
use App\Models\Materia;

class Proyecto extends Model
{
    /** @use HasFactory<\Database\Factories\ProyectoFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tbl_proyectos';

    protected $fillable = [
        'titulo',
        'descripcion',
        'slug',
        'estatus',
        'codigo_acceso',
        'profesor_id',
        'materia_id',
        'periodo_semestral',
    ];

    protected $casts = [
        'estatus' => 'string',
    ];

    // Relaciones
    public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'profesor_id');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }
}
