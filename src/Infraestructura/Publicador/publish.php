<?php

//require __DIR__ . '/vendor/autoload.php';
require_once __DIR__.'/../../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPIOException;
use PhpAmqpLib\Message\AMQPMessage;


/*$dsn = "mysql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_DATABASE']}";
echo $dsn;*/

$db = new PDO(
    "mysql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_DATABASE']}",
    $_ENV['DB_USERNAME'],
    $_ENV['DB_PASSWORD']
);

$connection = new AMQPStreamConnection(
    $_ENV['RABBITMQ_HOST'],
    $_ENV['RABBITMQ_PORT'],
    $_ENV['RABBITMQ_USER'],
    $_ENV['RABBITMQ_PASSWORD']
);
// Declarar exchange si no existe
//$channel->exchange_declare('diagnostico', 'direct', false, true, false);


// Activar modo de confirmación
//$channel->confirm_select();

while (true) {
    $stmt = $db->query("SELECT * FROM outbox WHERE fue_procesado = 0");
    $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($eventos as $evento) {
		$exchange = $evento['tipo'];
		$eventoDominio = $evento['contenido'];
        $msg = new AMQPMessage(
            $eventoDominio,
            ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]
        );

        try {
			$channel = $connection->channel();
			$channel->exchange_declare($exchange, 'fanout', true, true, false);
			// Activar modo de confirmación
			$channel->confirm_select();
			$channel->basic_publish($msg, $exchange );
            $channel->wait_for_pending_acks_returns();

            $update = $db->prepare("UPDATE outbox SET fue_procesado = 1 WHERE id = ?");
            $update->execute([$evento['id']]);

            echo "[" . date('Y-m-d H:i:s') . "] ✅ Evento ID {$evento['id']} publicado y marcado como enviado.\n";

        } catch (Exception $e) {
            echo "[" . date('Y-m-d H:i:s') . "] ❌ Error al publicar evento ID {$evento['id']}: {$e->getMessage()}\n";
        } catch (AMQPIOException $e) {
            echo "[" . date('Y-m-d H:i:s') . "] ❌ Error al publicar evento ID {$evento['id']}: {'Servidor RabbitMQ Caído'}\n";
        } finally {
			$channel->close();
		}
    }

    sleep(5);
}

$connection->close();
/*while (true) {
    $stmt = $pdo->query("SELECT * FROM outbox WHERE fue_procesado = 0");

    $mensajes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($mensajes) > 0) {
        foreach ($mensajes as $mensaje) {
            $tipo = $mensaje['tipo'];
            $contenido = json_encode(json_decode($mensaje['contenido'], true));

            $msg = new AMQPMessage($contenido, ['content_type' => 'application/json']);
            $channel->basic_publish($msg, '', $tipo);

            $update = $pdo->prepare("UPDATE outbox SET fue_procesado = 1, fecha_procesamiento = NOW() WHERE id = ?");
            $update->execute([$mensaje['id']]);

            echo "[x] Evento publicado: {$tipo} - ID: {$mensaje['id']}\n";
        }
    }

    sleep(5); // Espera 5 segundos antes de volver a consultar
}*/


