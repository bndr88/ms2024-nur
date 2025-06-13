<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

require_once __DIR__ . '/../../../env.php';

if (!Capsule::schema()->hasTable('outbox')) {
	Capsule::schema()->create('outbox', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('tipo');
            $table->json('contenido');
            $table->timestamp('fecha_creacion')->default('2025-06-12');
            $table->boolean('fue_procesado')->default(false);
            $table->timestamp('fecha_procesamiento')->nullable();
        });

	echo "Migración ejecutada: tabla 'outbox' creada existosamente.\n";
} else {
	echo "La tabla 'outbox' ya existe. No se realizó ningún cambio.\n";
}
/*

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('outbox', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('tipo');
            $table->json('contenido');
            $table->timestamp('fecha_creacion')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean('fue_procesado')->default(false);
            $table->timestamp('fecha_procesamiento')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('outbox');
    }
};
*/
