<?php

namespace Mod2Nur;

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();
$capsule->addConnection([
	'driver' => env('DB_CONNECTION', 'mysql'),
	'host' => env('DB_HOST', '127.0.0.1'),
	'database' => env('DB_DATABASE', 'nutrinur2'),
'username' => env('DB_USERNAME', 'root'),
'password' => env('DB_PASSWORD', 'Lm12345'),
	'charset' => 'utf8'  ,
	'collation' => 'utf8_unicode_ci',
	'prefix' => '',
], 'default');

$capsule->setAsGlobal();
$capsule->bootEloquent();

// Habilitar el gestor de esquemas para las migraciones
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

$schema = $capsule->schema();

return $capsule;
