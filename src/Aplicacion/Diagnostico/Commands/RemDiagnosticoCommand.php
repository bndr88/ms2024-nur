<?php

namespace Mod2Nur\Aplicacion\Diagnostico\Commands;

class RemDiagnosticoCommand
{
    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}
