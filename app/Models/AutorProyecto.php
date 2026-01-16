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

    public $timestamps = false;

    protected $fillable = [
        'proyecto_id',
        'estudiante_id',
        'es_lider',
    ];
}
