<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;
use App\Models\ProgramaAcademico;
use App\Models\Proyecto;
use App\Models\AutorProyecto;

class Estudiante extends Model
{
    /** @use HasFactory<\Database\Factories\EstudainteFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tbl_estudiantes';

    protected $fillable = [
        'matricula',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'semestre',
        'usuario_id',
        'email',
        'programa_academico_id',
    ];

    protected $casts = [
        'semestre' => 'integer',
    ];

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function programaAcademico()
    {
        return $this->belongsTo(ProgramaAcademico::class, 'programa_academico_id');
    }
    
    public function proyectos()
    {
        return $this->belongsToMany(Proyecto::class, 'tbl_autores_proyecto', 'estudiante_id', 'proyecto_id')
                    ->using(AutorProyecto::class)
                    ->withPivot('es_lider');
    }
}
