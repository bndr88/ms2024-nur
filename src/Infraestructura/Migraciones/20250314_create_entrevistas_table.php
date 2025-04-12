<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

require_once __DIR__ . '/../../../env.php';

if (!Capsule::schema()->hasTable('entrevista')) {
	Capsule::schema()->create('entrevista', function (Blueprint $table) {
		$table->uuid('id')->primary();
		$table->uuid('pacienteId');
		$table->date('fechaRealizacion');
		$table->foreign('pacienteId')->references('id')->on('paciente')->onDelete('cascade');
		$table->timestamps();
	});

	echo "Migración ejecutada: tabla 'Entrevista' creada existosamente.\n";
} else {
	echo "La tabla 'Entrevista' ya existe. No se realizó ningún cambio.\n";
}
