<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use App\Models\PlanAcademico;
use App\Models\ProgramaAcademico;
use App\Models\Profesor;

use Database\Factories\PlanAcademicoFactory;
use Database\Factories\MateriaFactory;

class Materia extends Model
{
     /** @use HasFactory<\Database\Factories\PlanAcademicoFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tbl_materias'; //<- Debe de usar esta tabla

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'clave',
        'nombre',
        'abreviatura',
        'descripcion',
        'creditos',
        'semestre',
        'plan_academico_id', 
        'categoria_id',
    ];

    protected $casts = [
        'creditos' => 'integer',
        'semestre' => 'integer',
        'categoria_id' => 'integer',
    ];

    /**
     * La materia pertenece a un plan académico.
     */
    public function planAcademico(): BelongsTo
    {
        return $this->belongsTo(PlanAcademico::class, 'plan_academico_id');
    }

    /**
     * Profesores que imparten la materia.
     */
    public function profesores(): BelongsToMany
    {
        return $this->belongsToMany(
            Profesor::class,
            'tbl_materia_profesor',
            'materia_id',
            'profesor_id'
        )->withTimestamps();
    }

    /**
     * La materia pertenece a una categoría 
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}
