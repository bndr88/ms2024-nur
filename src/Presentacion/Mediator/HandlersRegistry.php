<?php

namespace Mod2Nur\Presentacion\Mediator;

class HandlersRegistry
{
    private array $handlers = [];

    public function register(string $messageClass, callable $handler): void
    {
        $this->handlers[$messageClass] = $handler;
    }

    public function getHandlerFor(object $message): ?callable
    {
        return $this->handlers[get_class($message)] ?? null;
    }
}
