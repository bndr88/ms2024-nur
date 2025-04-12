<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

require_once __DIR__ . '/../../../env.php';

if (!Capsule::schema()->hasTable('tipoanalisis')) {
	Capsule::schema()->create('tipoanalisis', function (Blueprint $table) {
		$table->uuid('id')->primary();
		$table->string('descripcion');
		$table->timestamps();
	});

	echo "Migración ejecutada: tabla para 'Tipo Analisis clinico' creada existosamente.\n";
} else {
	echo "La tabla para 'Tipo Analisis clinico' ya existe. No se realizó ningún cambio.\n";
}
