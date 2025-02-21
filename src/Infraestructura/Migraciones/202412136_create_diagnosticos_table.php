<?php

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('diagnosticos', function ($table) {
    $table->uuid('id')->primary();
    $table->uuid('paciente_id');
    $table->date('fecha');
    $table->float('peso');
    $table->float('altura');
    $table->text('descripcion');
    $table->string('estado_diagnostico');
    $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
    $table->timestamps();
});
