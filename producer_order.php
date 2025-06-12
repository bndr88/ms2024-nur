<?php
require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$host = 'localhost';
$port = 5672;
$user = 'storeUser';
$password = 'storeUserPassword';
$vhost = '/';

$exchange = 'paciente-creado';

$connection = new AMQPStreamConnection($host, $port, $user, $password, $vhost);
$channel = $connection->channel();

$channel->exchange_declare($exchange, 'fanout', true, true, false);

$data = json_encode([
    'id'=> '',
    'nombre'=> 'Pablo Marmol',
    'fechaNacimiento'=> '2025-05-25'
]);

$msg = new AMQPMessage($data, ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);

$channel->basic_publish($msg, $exchange);

echo " [x] Enviado al exchange '$exchange': $data\n";

$channel->close();
$connection->close();

