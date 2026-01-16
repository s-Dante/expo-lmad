<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\ProgramaAcademico;

class PlanAcademico extends Model
{
    /** @use HasFactory<\Database\Factories\PlanAcademicoFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tbl_planes_academicos'; //<- Debe de usar esta tabla

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre',
        'estatus',
        'programa_academico_id', 
    ];

    protected $casts = [
        'estatus' => 'boolean',
    ];

    /**
     * Un plan academico pertenece a un programa academico
     */
    public function programaAcademico(): BelongsTo
    {
        return $this->belongsTo(ProgramaAcademico::class, 'programa_academico_id');
    }

    /**
     * Un plan académico puede tener muchas materias.
     */
    public function materias(): HasMany
    {
        return $this->hasMany(Materia::class, 'plan_academico_id');
    }
}
