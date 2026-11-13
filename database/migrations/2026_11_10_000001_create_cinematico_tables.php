<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tabla Directores (IDDirector, Director)
        Schema::create('Directores', function (Blueprint $table) {
            $table->id('IDDirector');
            $table->string('Director', 150);
        });

        // 2. Tabla Categorías (Identificador, Categoría)
        Schema::create('Categorias', function (Blueprint $table) {
            $table->id('Identificador');
            $table->string('Categoria', 100);
        });

        // 3. Tabla Películas (Identificador, Titulo, IDDirector, Duración, IDCategoria, Sinopsis)
        Schema::create('Peliculas', function (Blueprint $table) {
            $table->id('Identificador');
            $table->string('Titulo', 200);
            $table->unsignedBigInteger('IDDirector');
            $table->string('Duracion', 50);
            $table->unsignedBigInteger('IDCategoria');
            $table->text('Sinopsis');

            $table->foreign('IDDirector')
                ->references('IDDirector')
                ->on('Directores')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('IDCategoria')
                ->references('Identificador')
                ->on('Categorias')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Peliculas');
        Schema::dropIfExists('Categorias');
        Schema::dropIfExists('Directores');
    }
};
