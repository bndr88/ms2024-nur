<?php
namespace Mod2Nur\Dominio\Outbox;
use DateTime;

class OutboxMessage
{
    public function __construct(
        public readonly string $id,
        public readonly string $tipo,
        public readonly array $contenido,
        public readonly DateTime $fechaCreacion,
        public bool $fueProcesado = false,
        public ?DateTime $fechaProcesamiento = null,
    ) {}
}
