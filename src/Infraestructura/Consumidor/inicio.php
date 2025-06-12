<?php
require_once __DIR__.'/../../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use Mod2Nur\Infraestructura\RepositoriosEloquent\EloquentPacienteRepository;
use Mod2Nur\Dominio\Paciente\Paciente;

// Configuración de RabbitMQ
$host = 'host.docker.internal';
$port = 5672;
$user = 'storeUser';
$password = 'storeUserPassword';
$vhost = '/';

// Colas a consumir
$queues = [
    'contratacion-paciente-creado',
    'paciente-actualizado'
];

$connection = new AMQPStreamConnection($host, $port, $user, $password, $vhost);
$channel = $connection->channel();

// Crear instancia del repositorio (sin UnitOfWork)
$repositorio = new EloquentPacienteRepository(null); // null ya que ignoramos UnitOfWork


foreach ($queues as $queue) {
    $channel->queue_declare($queue, false, true, false, false);

    $channel->basic_consume($queue, '', false, true, false, false, function ($msg) use ($repositorio, $queue) {
        echo " [x] Recibido desde {$queue}: ", $msg->body, "\n";

        $data = json_decode($msg->body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo " [!] Error de formato JSON en cola {$queue}.\n";
            return;
        }

        switch ($queue) {
            case 'contratacion-paciente-creado':
                if (isset($data['id'], $data['nombre'], $data['fechaNacimiento'])) {
                    $paciente = new Paciente(
                        $data['id'],
                        $data['nombre'],
                        new DateTime($data['fechaNacimiento'])
                    );
                    $repositorio->save($paciente);
                    echo " [✓] Paciente registrado desde {$queue}.\n";
                } else {
                    echo " [!] Faltan campos obligatorios en {$queue}.\n";
                }
                break;

            case 'paciente-actualizado':
                // Aquí puedes implementar lógica distinta para actualizar al paciente
                echo " [~] Procesar actualización de paciente... (a implementar)\n";
                break;

            default:
                echo " [!] Cola no reconocida: {$queue}\n";
                break;
        }
    });
}

echo " [*] Esperando mensajes en múltiples colas. CTRL+C para salir.\n";

while ($channel->is_consuming()) {
    $channel->wait();
}
