<?php

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('tipo_diagnosticos', function ($table) {
    $table->uuid('id')->primary();
    $table->string('descripcion');
    $table->timestamps();
});
