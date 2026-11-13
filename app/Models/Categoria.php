<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $table = 'Categorias';
    protected $primaryKey = 'Identificador';
    public $timestamps = false;

    protected $fillable = [
        'Categoria',
    ];

    public function peliculas(): HasMany
    {
        return $this->hasMany(Pelicula::class, 'IDCategoria', 'Identificador');
    }
}
