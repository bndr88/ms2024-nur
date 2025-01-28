<?php

namespace Mod2Nur\Presentacion\Mediator;

class CommandBus
{
    private IMediator $mediator;

    public function __construct(IMediator $mediator)
    {
        $this->mediator = $mediator;
    }

    public function dispatch(object $command): mixed
    {
        return $this->mediator->handle($command);
    }
}
