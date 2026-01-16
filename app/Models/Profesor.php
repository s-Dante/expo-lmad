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

class Profesor extends Model
{
    /** @use HasFactory<\Database\Factories\ProfesorFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tbl_profesores';

    protected $fillable = [
        'numero_empleado',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'usuario_id',
        'email',
    ];

    protected $casts = [
        'usuario_id' => 'integer',
    ];

    /**
     * Un Profesor puede o no tener cuenta de usuario
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Un Profesor puede estar asociado a varios Programas Académicos
     */
    public function programasAcademicos()
    {
        return $this->belongsToMany(ProgramaAcademico::class, 
                                    'tbl_profesor_programa', 'profesor_id', 
                                    'programa_academico_id')
                    ->withTimestamps();
    }

    /**
     * Materias que imparte el profesor.
     */
    public function materias(): BelongsToMany
    {
        return $this->belongsToMany(Materia::class, 'tbl_materia_profesor',
                                    'profesor_id', 'materia_id')
                    ->withTimestamps();
    }
}
