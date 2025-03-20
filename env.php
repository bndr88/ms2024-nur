<?php

namespace Mod2Nur;

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

/*function env($key, $default = null) {
    return getenv($key) ?: $default;
}*/

$capsule = new Capsule();
$capsule->addConnection([
    'driver'    => env('DB_CONNECTION', 'mysql'),
    'host'      => env('DB_HOST', '127.0.0.1'),
    'database'  => env('DB_DATABASE', 'nutrinur'), 
    'username'  => env('DB_USERNAME', 'root'),
    'password'  => env('DB_PASSWORD', 'Lm12345'), 
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
], 'default');

/*$capsule = new Capsule();
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
*/
$capsule->setAsGlobal();
$capsule->bootEloquent();

return $capsule;
