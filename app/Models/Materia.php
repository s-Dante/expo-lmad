<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\PlanAcademico;
use App\Models\ProgramaAcademico;

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
    ];

    protected $casts = [
        'creditos' => 'integer',
        'semestre' => 'integer',
    ];

    //Relaciones
    public function planAcademico()
    {
        return $this->belongsTo(PlanAcademico::class, 'plan_academico_id');
    }
}
