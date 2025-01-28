<?php

namespace Mod2Nur\Presentacion\Mediator;

class QueryBus
{
    private IMediator $mediator;

    public function __construct(IMediator $mediator)
    {
        $this->mediator = $mediator;
    }

    public function ask(object $query): mixed
    {
        return $this->mediator->handle($query);
    }
}
