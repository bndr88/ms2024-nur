<?php

namespace Mod2Nur\Aplicacion\Paciente\Handlers;

use Mod2Nur\Aplicacion\Paciente\Queries\GetPacienteByIdQuery;
use Mod2Nur\Dominio\Paciente\PacienteRepository;

class GetPacienteByIdHandler
{
    private PacienteRepository $pacienteRepository;

    public function __construct(PacienteRepository $pacienteRepository)
    {
        $this->pacienteRepository = $pacienteRepository;
    }

    public function __invoke(GetPacienteByIdQuery $query)
    {
        // Buscar el paciente por su ID (UUID)
        $paciente = $this->pacienteRepository->findById($query->getId());

        if (!$paciente) {
            throw new \Exception("Paciente no encontrado");
        }

        return $paciente;
    }
}
