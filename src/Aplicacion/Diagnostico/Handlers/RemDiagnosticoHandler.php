<?php

namespace Mod2Nur\Aplicacion\Diagnostico\Handlers;

use Mod2Nur\Aplicacion\Diagnostico\Commands\RemDiagnosticoCommand;
use Mod2Nur\Dominio\Diagnostico\DiagnosticoRepository;

class RemDiagnosticoHandler
{
    private DiagnosticoRepository $repository;

    public function __construct(DiagnosticoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(RemDiagnosticoCommand $command): void
    {
        $this->repository->delete($command->id);
    }
}

