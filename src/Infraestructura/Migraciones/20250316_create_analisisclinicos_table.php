<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

require_once __DIR__ . '/../../../env.php';

if (!Capsule::schema()->hasTable('analisisclinico')) {
	Capsule::schema()->create('analisisclinico', function (Blueprint $table) {
		$table->uuid('id')->primary();
		$table->uuid('diagnosticoId');
		$table->date('fechaRealizacion');
		$table->text('observaciones')->nullable();
		$table->text('conclusion')->nullable();
		$table->boolean('estaconcluido')->default(false);
		$table->uuid('tipoAnalisis_id');
		$table->foreign('diagnosticoId')->references('id')->on('diagnostico')->onDelete('cascade');
		$table->foreign('tipoAnalisis_id')->references('id')->on('tipoanalisis')->onDelete('cascade');
		$table->timestamps();
	});

	echo "Migración ejecutada: tabla para 'Tipo Analisis clinico' creada existosamente.\n";
} else {
	echo "La tabla para 'Tipo Analisis clinico' ya existe. No se realizó ningún cambio.\n";
}
