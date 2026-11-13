<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pelicula extends Model
{
    protected $table = 'Peliculas';
    protected $primaryKey = 'Identificador';
    public $timestamps = false;

    protected $fillable = [
        'Titulo',
        'IDDirector',
        'Duracion',
        'IDCategoria',
        'Sinopsis',
    ];

    public function director(): BelongsTo
    {
        return $this->belongsTo(Director::class, 'IDDirector', 'IDDirector');
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'IDCategoria', 'Identificador');
    }
}
