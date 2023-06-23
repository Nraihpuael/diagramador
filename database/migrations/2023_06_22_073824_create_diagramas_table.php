<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagramasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagramas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion');
            $table->text('contenido')->nullable();
            $table->smallInteger('favorito')->default(0); /* 0:en progreso 1:terminado */
            $table->smallInteger('terminado')->default(0); /* 0:en progreso 1:terminado */
            $table->foreignId('user_id')
            ->nullable()
            ->constrained('users')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diagramas');
    }
}
