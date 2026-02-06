<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Software extends Model
{
    /** @use HasFactory<\Database\Factories\SoftwareFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tbl_softwares';

    protected $fillable = [
        'nombre',
        'descripcion',
        'estatus',
    ];

    protected $casts = [
        'estatus' => 'boolean',
    ];

    /**
     * Que proyectos utilizan este software
     */
    public function proyectos(): BelongsToMany
    {
        return $this->belongsToMany(Proyecto::class,
                                    'tbl_softwares_por_proyectos',
                                    'software_id', 'proyecto_id'
        )->withTimestamps();
    }
}
