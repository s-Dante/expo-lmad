<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Proyecto;

class MultimediaProyecto extends Model
{
    /** @use HasFactory<\Database\Factories\MultimediaProyectoFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tbl_multimedia_proyectos';

    protected $fillable = [
        'proyecto_id',
        'tipo',
        'url',
        'titulo',
        'descripcion',
        'es_portada',
    ];

    protected $casts = [
        'es_portada' => 'boolean',
    ];

    // Relaciones
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }
}
