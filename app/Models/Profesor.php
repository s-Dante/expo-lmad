<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;

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

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function programasAcademicos()
    {
        return $this->belongsToMany(ProgramaAcademico::class, 'tbl_profesor_programa_academico');
    }
}
