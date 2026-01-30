<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Estudiante;

class AsistenciaGeneral extends Model
{
    /** @use HasFactory<\Database\Factories\AsistenciaGeneralFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tbl_asistencias_general';

    protected $fillable = [
        'estudiante_id',
        'hora_entrada',
    ];

    public $timestamps = true;

    /**
     * Relación con el modelo Estudiante
     */
    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }
}
