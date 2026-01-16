<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    
    //Relaciones
    public function programaAcademico()
    {
        return $this->belongsTo(ProgramaAcademico::class, 'programa_academico_id');
    }
}
