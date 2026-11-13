<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Director extends Model
{
    protected $table = 'Directores';
    protected $primaryKey = 'IDDirector';
    public $timestamps = false;

    protected $fillable = [
        'Director',
    ];

    public function peliculas(): HasMany
    {
        return $this->hasMany(Pelicula::class, 'IDDirector', 'IDDirector');
    }
}
