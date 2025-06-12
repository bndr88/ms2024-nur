<?php
namespace Mod2Nur\Infraestructura\Publicador;

use Mod2Nur\Aplicacion\Eventos\EventPublisher;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQEventPublisher implements EventPublisher
{
    private AMQPStreamConnection $connection;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            'host.docker.internal',
            5672,
            'storeUser',
            'storeUserPassword'
        );
    }

    public function publish(string $exchange, array $payload): void
    {
        $channel = $this->connection->channel();
        $channel->exchange_declare($exchange, 'fanout', true, true, false);
        $msg = new AMQPMessage(json_encode($payload), [
            'content_type' => 'application/json',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
        ]);

        $channel->basic_publish($msg, $exchange);
        $channel->close();
        $this->connection->close();
    }
}
