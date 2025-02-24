<?php

namespace Mod2Nur\Aplicacion\Paciente\Handlers;

use Mod2Nur\Aplicacion\Paciente\Queries\GetHistorialQuery;
use Mod2Nur\Dominio\Paciente\PacienteRepository;

class GetHistorialHandler
{
    private PacienteRepository $pacienteRepository;

    public function __construct(PacienteRepository $pacienteRepository)
    {
        $this->pacienteRepository = $pacienteRepository;
    }

    public function __invoke(GetHistorialQuery $query)
    {     
        $historialClinico = $this->pacienteRepository->historialClinico($query->getIdPaciente());

        if (empty($historialClinico)) {
            return [];
        }

        return $historialClinico;
    }
}
