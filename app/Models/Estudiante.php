<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'usuario_id' => 'integer',
        'programa_academico_id' => 'integer',
    ];

    /**
     * El estudiante puede o no tener cuenta de usuario.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * El estudiante pertenece a un programa académico.
     */
    public function programaAcademico(): BelongsTo
    {
        return $this->belongsTo(ProgramaAcademico::class, 'programa_academico_id');
    }
    
    /**
     * El estudiante puede participar en muchos proyectos.
     */
    public function proyectos(): BelongsToMany
    {
        return $this->belongsToMany(Proyecto::class, 
                                    'tbl_autores_proyecto', 'estudiante_id', 
                                    'proyecto_id')
                    ->using(AutorProyecto::class)
                    ->withPivot('es_lider')
                    ->withTimestamps();
    }
}
