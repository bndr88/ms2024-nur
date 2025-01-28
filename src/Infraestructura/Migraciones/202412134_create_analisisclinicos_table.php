<?php

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('analisis_clinicos', function ($table) {
    $table->uuid('id')->primary();
    $table->uuid('diagnostico_id');
    $table->date('fecha_realizacion');
    $table->text('observaciones');
    $table->text('conclusion');
    $table->boolean('esta_concluido')->default(false);
    $table->foreign('diagnostico_id')->references('id')->on('diagnosticos')->onDelete('cascade');
    $table->timestamps();
});
