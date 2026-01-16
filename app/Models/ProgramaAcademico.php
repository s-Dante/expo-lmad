<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

}
