<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Director;
use App\Models\Pelicula;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Pelicula::truncate();
        Director::truncate();
        Categoria::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $directores = [
            ['IDDirector' => 1, 'Director' => 'Christopher Nolan'],
            ['IDDirector' => 2, 'Director' => 'Guillermo del Toro'],
            ['IDDirector' => 3, 'Director' => 'Denis Villeneuve'],
            ['IDDirector' => 4, 'Director' => 'Greta Gerwig'],
            ['IDDirector' => 5, 'Director' => 'Hayao Miyazaki'],
            ['IDDirector' => 6, 'Director' => 'Alfonso Cuarón'],
        ];

        foreach ($directores as $dir) {
            Director::create($dir);
        }

        $categorias = [
            ['Identificador' => 1, 'Categoria' => 'Ciencia Ficción'],
            ['Identificador' => 2, 'Categoria' => 'Fantasía Oscura'],
            ['Identificador' => 3, 'Categoria' => 'Acción y Aventura'],
            ['Identificador' => 4, 'Categoria' => 'Drama Histórico'],
            ['Identificador' => 5, 'Categoria' => 'Animación'],
            ['Identificador' => 6, 'Categoria' => 'Suspenso Espacial'],
        ];

        foreach ($categorias as $cat) {
            Categoria::create($cat);
        }

        $peliculas = [
            [
                'Identificador' => 1,
                'Titulo' => 'Interstellar',
                'IDDirector' => 1,
                'Duracion' => '169 min',
                'IDCategoria' => 1,
                'Sinopsis' => 'Un grupo de exploradores espaciales viaja a través de un agujero de gusano cerca de Saturno en busca de un nuevo hogar para la humanidad mientras la Tierra agoniza.',
            ],
            [
                'Identificador' => 2,
                'Titulo' => 'El Laberinto del Fauno',
                'IDDirector' => 2,
                'Duracion' => '118 min',
                'IDCategoria' => 2,
                'Sinopsis' => 'En la España de 1944, la joven Ofelia descubre un antiguo laberinto habitado por un fauno que le revela que ella es la reencarnación de una princesa subterránea y debe superar tres pruebas.',
            ],
            [
                'Identificador' => 3,
                'Titulo' => 'Dune: Parte Dos',
                'IDDirector' => 3,
                'Duracion' => '166 min',
                'IDCategoria' => 1,
                'Sinopsis' => 'Paul Atreides se une a Chani y a los Fremen mientras busca venganza contra los conspiradores que destruyeron a su familia en el desierto de Arrakis.',
            ],
            [
                'Identificador' => 4,
                'Titulo' => 'Oppenheimer',
                'IDDirector' => 1,
                'Duracion' => '180 min',
                'IDCategoria' => 4,
                'Sinopsis' => 'La historia del físico estadounidense J. Robert Oppenheimer y su papel al frente del Proyecto Manhattan en el desarrollo de la primera arma nuclear durante la Segunda Guerra Mundial.',
            ],
            [
                'Identificador' => 5,
                'Titulo' => 'El Viaje de Chihiro',
                'IDDirector' => 5,
                'Duracion' => '125 min',
                'IDCategoria' => 5,
                'Sinopsis' => 'Chihiro, una niña de diez años, queda atrapada en un mundo mágico gobernado por dioses, brujas y espíritus, donde los humanos son transformados en bestias y debe trabajar en una casa de baños para liberar a sus padres.',
            ],
            [
                'Identificador' => 6,
                'Titulo' => 'Gravity',
                'IDDirector' => 6,
                'Duracion' => '91 min',
                'IDCategoria' => 6,
                'Sinopsis' => 'Dos astronautas quedan a la deriva en la inmensidad del espacio tras la destrucción de su transbordador por desechos orbitales y deben encontrar la forma de regresar a la Tierra.',
            ],
        ];

        foreach ($peliculas as $pelicula) {
            Pelicula::create($pelicula);
        }
    }
}
