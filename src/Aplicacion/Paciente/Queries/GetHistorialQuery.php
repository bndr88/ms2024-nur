<?php

namespace Mod2Nur\Aplicacion\Paciente\Queries;

class GetHistorialQuery
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