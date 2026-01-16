<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Evento;

class Conferencista extends Model
{
    /** @use HasFactory<\Database\Factories\ConferencistaFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tbl_conferencistas';

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'nickname',
        'biografia',
        'email',
        'telefono',
        'empresa',
        'cargo',
        'foto_url',
        'estatus',
    ];

    protected $casts = [
        'estatus' => 'boolean',
    ];

    /**
     * Eventos en los que participa el conferencista.
     */
    public function eventos(): BelongsToMany
    {
        return $this->belongsToMany(
            Evento::class,
            'tbl_conferencista_evento',
            'conferencista_id',
            'evento_id'
        )->withTimestamps(); // Importante si quisieras timestamps en el pivot, aunque tu migración actual no los tiene, es buena práctica dejarlos listos en la relación.
    }
}
