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
        Schema::create('lendings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->references('id')->on('equipments')->onDelete('cascade');
            $table->string('solicitante');
            $table->string('ramal');
            $table->string('secao');
            $table->dateTime('inicio');
            $table->dateTime('previsto');
            $table->dateTime('fim')->nullable();
            $table->text('observacoes')->nullable();
            $table->boolean('devolvido')->default(false);
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
        Schema::dropIfExists('lendings');
    }
};
