<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

require_once __DIR__ . '/../../../env.php';

if (!Capsule::schema()->hasTable('diagnostico')) {
    Capsule::schema()->create('diagnostico', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->uuid('pacienteId')->default('1990-02-25');
        $table->date('fecha');
        $table->float('peso');
        $table->float('altura');
        $table->text('descripcion');
        $table->uuid('tipoDiagnostico_id');
        $table->enum('estadoDiagnostico', ['Pendiente', 'Confirmado', 'Cancelado']);
        $table->foreign('pacienteId')->references('id')->on('paciente')->onDelete('cascade');
        $table->foreign('tipoDiagnostico_id')->references('id')->on('tipoDiagnostico')->onDelete('cascade');
        $table->timestamps();
    });

    echo "Migración ejecutada: tabla 'diagnostico' creada existosamente.\n";
} else {
    echo "La tabla 'diagnostico' ya existe. No se realizó ningún cambio.\n";
}