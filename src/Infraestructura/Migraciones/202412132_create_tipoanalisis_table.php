<?php

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('tipo_analisis', function ($table) {
    $table->uuid('id')->primary();
    $table->string('descripcion');
    $table->timestamps();
});
