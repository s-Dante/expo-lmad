<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use App\Models\Visitante;

class Patrocinador extends Model
{
    /** @use HasFactory<\Database\Factories\PatrocinadorFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tbl_patrocinadores';

    protected $fillable = [
        'nombre',
        'tier',
        'logo_url',
        'website_url',
    ];

    /**
     * Visitantes que son representantes de un patrocinador
     */
    public function representantes(): BelongsToMany
    {
        return $this->belongsToMany(
            Visitante::class,
            'tbl_representantes_patrocinador',
            'patrocinador_id',
            'visitante_id'
        )
        ->withPivot(['cargo', 'deleted_at'])
        ->withTimestamps()
        ->wherePivotNull('deleted_at'); // Fundamental para respetar el SoftDelete de la tabla intermedia
    }
}
