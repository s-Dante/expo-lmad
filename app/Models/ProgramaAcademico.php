<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Catálogo base de programas académicos.
 * Estos registros se cargan vía seeder y rara vez cambian.
 */
class ProgramaAcademico extends Model
{
    /** @use HasFactory<\Database\Factories\ProgramaAcademicoFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tbl_programas_academicos'; //<- Debe de usar esta tabla
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre',
        'abreviatura',
        'descripcion',
        'estatus',
    ];

    protected $casts = [
        'estatus' => 'boolean',
    ];

    /**
     * Un programa académico puede tener muchos planes de estudio.
     */
    public function planes(): HasMany
    {
        return $this->hasMany(PlanAcademico::class, 'programa_id'); 
    }
}
