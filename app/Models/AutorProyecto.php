<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class AutorProyecto extends Pivot
{
    /** @use HasFactory<\Database\Factories\AutorProyectoFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tbl_autores_proyecto';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'proyecto_id',
        'estudiante_id',
        'es_lider',
    ];

    protected $casts = [
        'es_lider' => 'boolean',
        'proyecto_id' => 'integer',
        'estudiante_id' => 'integer',
    ];
}
