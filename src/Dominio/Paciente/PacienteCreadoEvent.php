<?php

namespace Mod2Nur\Dominio\Paciente;

class PacienteCreadoEvent
{
    private string $idPaciente;

    public function __construct(string $idPaciente)
    {
        $this->idPaciente = $idPaciente;
    }

    public function getIdPaciente(): string
    {
        return $this->idPaciente;
    }
}
