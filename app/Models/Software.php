<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Software extends Model
{
    /** @use HasFactory<\Database\Factories\SoftwareFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tbl_softwares';

    protected $fillable = [
        'software_name',
        'software_description',
        'estatus',
    ];

    protected $casts = [
        'estatus' => 'boolean',
    ];

    // Relaciones
    public function proyectos()
    {
        return $this->belongsToMany(
            Proyecto::class,
            'tbl_softwares_por_proyectos',
            'software_id',
            'proyecto_id'
        );
    }
}
