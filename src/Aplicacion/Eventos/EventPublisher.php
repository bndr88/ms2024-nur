<?php
namespace Mod2Nur\Aplicacion\Eventos;

interface EventPublisher {
    public function publish(string $exchange, array $payload): void;
}
