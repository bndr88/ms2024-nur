<?php
require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$host = 'host.docker.internal';
$port = 5672;
$user = 'storeUser';
$password = 'storeUserPassword';
$vhost = '/';

$queue = 'contratacion-paciente-creado';

$connection = new AMQPStreamConnection($host, $port, $user, $password, $vhost);
$channel = $connection->channel();

$channel->queue_declare($queue, false, true, false, false);

echo " [*] Esperando mensajes en '$queue'. CTRL+C para salir.\n";

$callback = function ($msg) {
    echo " [x] Recibido: ", $msg->body, "\n";

    $data = json_decode($msg->body, true);

    if (json_last_error() === JSON_ERROR_NONE) {
        $url = 'http://nur-app/paciente/add'; // nombre del contenedor
        $options = [
            'http' => [
                'method'  => 'POST',
                'header'  => "Content-Type: application/json\r\n",
                'content' => json_encode($data),
                'timeout' => 5
            ]
        ];

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result === FALSE) {
            echo " [!] Error al enviar los datos al endpoint.\n";
        } else {
            echo " [+] Paciente enviado correctamente: $result\n";
        }
    } else {
        echo " [!] Error al decodificar el mensaje JSON\n";
    }
};

$channel->basic_consume($queue, '', false, true, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}
