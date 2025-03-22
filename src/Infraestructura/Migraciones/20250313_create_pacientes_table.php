<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

require_once __DIR__ . '/../../../env.php';

if (!Capsule::schema()->hasTable('paciente')) {
    Capsule::schema()->create('paciente', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->string('nombre');
        $table->date('fechaNacimiento');
        $table->timestamps();
    });

    echo "Migración ejecutada: tabla 'paciente' creada existosamente.\n";
} else {
    echo "La tabla 'paciente' ya existe. No se realizó ningún cambio.\n";
}