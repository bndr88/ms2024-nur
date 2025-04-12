<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

require_once __DIR__ . '/../../../env.php';

if (!Capsule::schema()->hasTable('tipodiagnostico')) {
	Capsule::schema()->create('tipodiagnostico', function (Blueprint $table) {
		$table->uuid('id')->primary();
		$table->string('descripcion');
		$table->timestamps();
	});

	echo "Migración ejecutada: tabla 'Tipo Diagnostico' creada existosamente.\n";
} else {
	echo "La tabla 'Tipo Diagnostico' ya existe. No se realizó ningún cambio.\n";
}
