<?php

namespace Mod2Nur\Aplicacion\Paciente\Commands;

class RemPacienteCommand
{
    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}