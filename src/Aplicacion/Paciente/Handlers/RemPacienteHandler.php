<?php

namespace Mod2Nur\Aplicacion\Paciente\Handlers;

use Mod2Nur\Aplicacion\Paciente\Commands\RemPacienteCommand;
use Mod2Nur\Dominio\Paciente\Paciente;
use Mod2Nur\Dominio\Paciente\PacienteRepository;

class RemPacienteHandler
{
    private PacienteRepository $repository;

    public function __construct(PacienteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(RemPacienteCommand $command): void
    {
        $this->repository->delete($command->id);
    }
}