<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Persona', function (Blueprint $table) {
            $table->id();
            $table->string('paterno')->nullable();
            $table->string('materno')->nullable();
            $table->string('nombres');
            $table->unsignedBigInteger('ci');
            $table->string('complemento')->nullable()->default('');
            //$table->foreignId('expedido_id')->constrained('expedidos')->cascadeOnUpdate()->restrictOnDelete();
            $table->date('fecha_nacimiento')->nullable();
            //$table->foreignId('lugar_nacimiento_id')->constrained('nacimiento')->cascadeOnUpdate()->restrictOnDelete();
            $table->unsignedBigInteger('telefono')->nullable();
            $table->string('foto')->nullable();
            $table->string('firma_digital');
            $table->boolean('activo')->default(true);

            $table->unsignedBigInteger('usuario_creado_id');
            $table->timestamp('fecha_creado');
            $table->unsignedBigInteger('usuario_modificado_id');
            $table->timestamp('fecha_modificado');

            //$table->unique(['ci', 'complemento', 'expedido_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personas');
    }
};
