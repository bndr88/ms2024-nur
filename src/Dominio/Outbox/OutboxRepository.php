<?php
namespace Mod2Nur\Dominio\Outbox;
//use Mod2Nur\Dominio\Outbox\OutboxMessage;

interface OutboxRepository
{
    public function guardar(OutboxMessage $mensaje): ?OutboxMessage;
}
