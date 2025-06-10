<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use Mod2Nur\Infraestructura\RepositoriosEloquent\EloquentPacienteRepository;
use Mod2Nur\Dominio\Paciente\Paciente;

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

// Crear instancia del repositorio (sin UnitOfWork)
$repositorio = new EloquentPacienteRepository(null); // null ya que ignoramos UnitOfWork

$callback = function ($msg) use ($repositorio) {
    echo " [x] Recibido: ", $msg->body, "\n";

    $data = json_decode($msg->body, true);

    if (json_last_error() === JSON_ERROR_NONE && isset($data['id'], $data['nombre'], $data['fechaNacimiento'])) {
        $paciente = new Paciente(
            $data['id'],
            $data['nombre'],
            new DateTime($data['fechaNacimiento'])
        );

        // Usar el repositorio directamente
        $repositorio->save($paciente);

        echo " [✓] Paciente guardado correctamente.\n";
    } else {
        echo " [!] Error en el formato del mensaje JSON\n";
    }
};

$channel->basic_consume($queue, '', false, true, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}
