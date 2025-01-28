<?php

namespace Mod2Nur;

//require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => '127.0.0.1',
    'database'  => 'nutrinur',
    'username'  => 'root',
    'password'  => 'Lm12345',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
], 'default');

$capsule->setAsGlobal();
$capsule->bootEloquent();

return $capsule;
