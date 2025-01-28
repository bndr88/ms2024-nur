<?php

namespace Mod2Nur\Presentacion\Mediator;

use Mod2Nur\Presentacion\Mediator\Exceptions\HandlerNotFoundException;
use Mod2Nur\Presentacion\Mediator\HandlersRegistry;

class Mediator implements IMediator
{
    private HandlersRegistry $registry;

    public function __construct(HandlersRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function handle(object $message): mixed
    {
        $handler = $this->registry->getHandlerFor($message);

        if (!$handler) {
            throw new HandlerNotFoundException('No handler found for message: ' . get_class($message));
        }

        //return $handler->handle($message);
        return $handler($message);
    }
}
