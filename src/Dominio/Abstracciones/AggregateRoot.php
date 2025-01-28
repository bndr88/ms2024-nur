<?php

namespace Mod2Nur\Dominio\Abstracciones;

abstract class AggregateRoot extends Entity
{
    protected function __construct(string $id)
    {        
        parent::__construct($id);
    }
}