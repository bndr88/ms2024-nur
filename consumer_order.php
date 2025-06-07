<?php
require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$host = 'localhost';
$port = 5672;
$user = 'storeUser';
$password = 'storeUserPassword';
$vhost = '/';

$queue = 'billing-order-created';

$connection = new AMQPStreamConnection($host, $port, $user, $password, $vhost);
$channel = $connection->channel();

$channel->queue_declare($queue, false, true, false, false);

echo " [*] Esperando mensajes en '$queue'. CTRL+C para salir.\n";

$callback = function ($msg) {
    echo " [x] Recibido: ", $msg->body, "\n";
};

$channel->basic_consume($queue, '', false, true, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}
