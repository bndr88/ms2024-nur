<?php

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('pacientes', function ($table) {
    $table->uuid('id')->primary();
    $table->string('nombre');
    $table->date('fecha_nacimiento');
    $table->timestamps(); // Agrega columnas created_at y updated_at
});
