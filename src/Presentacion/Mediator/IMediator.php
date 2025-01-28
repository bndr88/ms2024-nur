<?php

namespace Mod2Nur\Presentacion\Mediator;

interface IMediator
{
    public function handle(object $message): mixed;
}
