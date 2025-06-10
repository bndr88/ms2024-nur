<?php
require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$host = 'localhost';
$port = 5672;
$user = 'storeUser';
$password = 'storeUserPassword';
$vhost = '/';

$exchange = 'diagnosticos-realizados';

$connection = new AMQPStreamConnection($host, $port, $user, $password, $vhost);
$channel = $connection->channel();

$channel->exchange_declare($exchange, 'fanout', true, true, false);

$data = json_encode([
    'id'=> 'a1b2c3d4-e5f6-7890-1234-56789abcdef0',
    'descripcion'=> 'Análisis de sangre 34',
    'pacienteId'=> '12345678-90ab-cdef-1234-567890abcdef'
]);

$msg = new AMQPMessage($data, ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);

$channel->basic_publish($msg, $exchange);

echo " [x] Enviado al exchange '$exchange': $data\n";

$channel->close();
$connection->close();

