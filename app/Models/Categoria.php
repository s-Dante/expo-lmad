<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    /** @use HasFactory<\Database\Factories\CategoriaFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tbl_categorias';

    protected $fillable = [
        'nombre',
        'slug',
    ];

    /**
     * Una categoria puede tener muchas materias.
     */
    public function materias(): HasMany
    {
        return $this->hasMany(Materia::class, 'categoria_id');
    }
}
