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
        Schema::create('Reparticion', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('Dependencia_padre_id')->default(0);
            // $table->foreignId('Tipo_dependencia_id')->constrained('Unidad')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('Reparticion', 250)->nullable();
            $table->string('Codigo', 30)->nullable();
            $table->string('Descripcion',300)->nullable();
            $table->unsignedTinyInteger('prioridad')->default(0);
            $table->integer('estado')->default(1);

            $table->nullableTimestamps();
            $table->SoftDeletes();
            $table->string('CreatorUserName', 250)->nullable();
            $table->string('CreatorFullUserName', 250)->nullable();
            $table->string('CreatorIP', 250)->nullable();
            $table->string('UpdaterUserName', 250)->nullable();
            $table->string('UpdaterFullUserName', 250)->nullable();
            $table->string('UpdaterIP', 250)->nullable();
            $table->string('DeleterUserName', 250)->nullable();
            $table->string('DeleterFullUserName', 250)->nullable();
            $table->string('DeleterIP', 250)->nullable();

        });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reparticion');
    }
};
